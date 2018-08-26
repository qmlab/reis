<?hh // partial
require_once(__DIR__."/mortgage_calculator.php");


//Quick test
$cal = new SellingROICalculator(1000000.0, 20.0, 4.5, 1000.0, 1.0, 0.0, 360, 0, 50000.0, 1200000.0, 6.0, 1.28, 15000.0, 6);
print_r("result=" . $cal->getROI() . "\n");
