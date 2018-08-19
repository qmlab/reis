<?hh // strict

class RentalROICalculator {
  private MortgageCalculator $mc;
  public function __construct(private float $total, private float $downpay_ratio, private float $interest_rate, private float $insurance, private float $property_tax_rate, private float $pmi_rate, private int $months, private int $months_pmi, private float $fixing_cost, private float $estimated_rental, private float $property_management_rate, private float $maintenance_rate, private float $holding_months, private int $months_rental) {
    $this->mc = new MortgageCalculator($total, $downpay_ratio, $interest_rate, $insurance, $property_tax_rate, $pmi_rate, $months, $months_pmi);
  }

  // Monthly cash flow
  public function getCashFlow(): float {
    $payment = $this->mc->getPayment();
    $cash = ($this->$estimated_rental * (1 - $this->property_management_rate / 100 - $this->maintenance_rate / 100) * ($this->months_rental - $this->holding_months) - $payment * $this->months_rental - $this->fixing_cost) / $this->months_rental;
    return $cash;
  }

  public function getROI(): float {
    $cash = $this->getCashFlow();
    $roi = $cash * 12 / ($this->total * $this->downpay_ratio / 100);
    return $roi;
  }
}

class SellingROICalculator {
  private MortgageCalculator $mc;
  public function __construct(private float $total, private float $downpay_ratio, private float $interest_rate, private float $insurance, private float $property_tax_rate, private float $pmi_rate, private int $months, private int $months_pmi, private float $fixing_cost, private float $estimated_price, private float $commission_rate, private float $excise_tax_rate, private float $closing_cost, private float $holding_months) {
    $this->mc = new MortgageCalculator($total, $downpay_ratio, $interest_rate, $insurance, $property_tax_rate, $pmi_rate, $months, $months_pmi);
  }

  public function getROI(): float {
    $payment = $this->mc->getPayment();
    $earning = $this->estimated_price * (1 - $this->commission_rate / 100 - $this->excise_tax_rate / 100) - $payment * $this->holding_months - $this->fixing_cost - $this->closing_cost;
    $roi = $earning / ($this->total * $this->downpay_ratio / 100);
    return $roi;
  }

  public function getYearlyROI(): float {
    $roi = $this->getROI();
    $yearly = $roi / $this->holding_months * 12;
    return $yearly;
  }
}
