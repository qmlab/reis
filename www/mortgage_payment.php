<?hh // partial
require_once(__DIR__."/../vendor/hh_autoload.php");

class MortgageCalculator {
  public function __construct(private float $total, private float $downpay_ratio, private float $interest_rate, private float $insurance, private float $property_tax_rate, private float $pmi_rate, private int $months, private int $months_pmi) {
  }

  public function getPayment(): float {
    $loan = $this->total * (1 - $this->downpay_ratio / 100);
    $rate = $this->interest_rate / 12 / 100;
    $tax = $this->total * $this->property_tax_rate / 12 / 100;
    $pmi = $this->total * $this->pmi_rate / 12 / 100 * $this->months_pmi / $this->months;
    $principal_interest = $loan * $rate * pow(1 + $rate, $this->months) / (pow(1 + $rate, $this->months) - 1);
    return $principal_interest + $tax + $pmi + $this->insurance / 12;
  }
}

function main() {
  $mc = new MortgageCalculator((float)$_POST['total'], (float)$_POST['downpay_ratio'], (float)$_POST['interest_rate'], (float)$_POST['insurance'], (float)$_POST['property_tax_rate'], (float)$_POST['pmi_rate'], (int)$_POST['months'], (int)$_POST['months_pmi']);
  $payment = round($mc->getPayment(), 2);
  echo 
    <strong>{$payment}</strong>;
}

main();
