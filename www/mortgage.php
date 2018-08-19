<?hh // partial
require_once(__DIR__."/../calculators/mortgage_calculator.php");
require_once(__DIR__."/../vendor/hh_autoload.php");

function main() {
  $mc = new MortgageCalculator((float)$_POST['total'], (float)$_POST['downpay_ratio'], (float)$_POST['interest_rate'], (float)$_POST['insurance'], (float)$_POST['property_tax_rate'], (float)$_POST['pmi_rate'], (int)$_POST['months'], (int)$_POST['months_pmi']);
  $payment = round($mc->getPayment(), 2);
  echo
    <strong>{$payment}</strong>;
}

main();
