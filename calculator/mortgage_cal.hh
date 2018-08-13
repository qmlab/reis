<?hh // partial

namespace REIS;
class MortgageCalculator {
  public function __construct(private float $total, private float $downpay_ratio, private float $interest_rate, private float $insurance, private float $property_tax_rate, private float $pmi_rate, private int $months, private int $months_pmi) {
  }

  public function get_payment(): float {
    $loan = $this->total * (1 - $this->downpay_ratio);
    var_dump($loan);
    $rate = $this->interest_rate / 12;
    var_dump($rate);
    $tax = $this->total * $this->property_tax_rate;
    var_dump($tax);
    $pmi = $this->total * $this->pmi_rate / 12 * $this->months_pmi / $this->months;
    var_dump($pmi);
    $principal_interest = $loan * $rate * pow(1 + $rate, $this->months) / (pow(1 + $rate, $this->months) - 1);
    var_dump($principal_interest);
    return $principal_interest + $tax + $pmi + $this->insurance / 12;
  }
}

$mc = new MortgageCalculator(300000.0, 0.2, 0.05, 1500.0, 0.01, 0.005, 360, 31);
var_dump($mc->get_payment());
