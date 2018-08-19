<?hh // partial

class MortgageCalculator {
  public function __construct(private float $total, private float $downpay_ratio, private float $interest_rate, private float $insurance, private float $property_tax_rate, private float $pmi_rate, private int $months, private int $months_pmi) {
  }

  public function getPayment(): float {
    $loan = $this->total * (1 - $this->downpay_ratio);
    $rate = $this->interest_rate / 12;
    $tax = $this->total * $this->property_tax_rate;
    $pmi = $this->total * $this->pmi_rate / 12 * $this->months_pmi / $this->months;
    $principal_interest = $loan * $rate * pow(1 + $rate, $this->months) / (pow(1 + $rate, $this->months) - 1);
    return $principal_interest + $tax + $pmi + $this->insurance / 12;
  }
}

function main() {
  $mc = new MortgageCalculator($_POST['total'], $_POST['downpay_ratio'], $_POST['interest_rate'], $_POST['insurance'], $_POST['property_tax_rate'], $_POST['pmi_rate'], $_POST['months'], $_POST['months_pmi']);
  $payment = $mc->getPayment();
  return
    <p>The estimated monthly payment is {$payment}</p>;
}
