<?hh // partial
require_once(__DIR__."/mortgage_calculator.php");

class RentalROICalculator {
  private MortgageCalculator $mc;
  public function __construct(private float $total, private float $downpay_ratio, private float $interest_rate, private float $insurance, private float $property_tax_rate, private float $pmi_rate, private int $months, private int $months_pmi, private float $fixing_cost, private float $estimated_rental, private float $property_management_rate, private float $maintenance_rate, private int $holding_months, private int $months_rental, private float $hoa) {
    $this->mc = new MortgageCalculator($total, $downpay_ratio, $interest_rate, $insurance, $property_tax_rate, $pmi_rate, $months, $months_pmi, $hoa);
  }

  public function getExpense(): float {
    $payment = $this->mc->getPayment();
    return $this->fixing_cost + ($this->maintenance_rate / 100 + $this->property_management_rate / 100 + $payment) * $this->holding_months;
  }

  // Monthly cash flow
  public function getCashFlow(): float {
    $payment = $this->mc->getPayment();
    $cash = ($this->estimated_rental * (1 - $this->property_management_rate / 100 - $this->maintenance_rate / 100) * ($this->months_rental - $this->holding_months) - $payment * $this->months_rental - $this->fixing_cost) / $this->months_rental;
    return $cash;
  }

  public function getROI(): float {
    $cash = $this->getCashFlow();
    $roi = $cash * 12 / ($this->total * $this->downpay_ratio / 100 + $this->getExpense());
    return $roi;
  }
}

class SellingROICalculator {
  private MortgageCalculator $mc;
  public function __construct(private float $total, private float $downpay_ratio, private float $interest_rate, private float $insurance, private float $property_tax_rate, private float $pmi_rate, private int $months, private int $months_pmi, private float $fixing_cost, private float $estimated_price, private float $commission_rate, private float $excise_tax_rate, private float $closing_cost, private int $holding_months, private float $hoa) {
    $this->mc = new MortgageCalculator($total, $downpay_ratio, $interest_rate, $insurance, $property_tax_rate, $pmi_rate, $months, $months_pmi, $hoa);
  }

  public function getExpense(): float{
    $payment = $this->mc->getPayment();
    return $this->estimated_price * ($this->commission_rate + $this->excise_tax_rate) / 100 + $payment * $this->holding_months + $this->fixing_cost + $this->closing_cost;
  }

  public function getEarning(): float {
    $expense = $this->getExpense();
    return $this->estimated_price - $expense - $this->total;
  }

  public function getROI(): float {
    return $this->getEarning() / ($this->total * $this->downpay_ratio / 100 + $this->getExpense());
  }

  public function getYearlyROI(): float {
    $roi = $this->getROI();
    $yearly = $roi / $this->holding_months * 12;
    return $yearly;
  }
}
