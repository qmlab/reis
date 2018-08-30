<?hh // partial
require_once(__DIR__."/roi_calculator.php");

function vf(int $tid, float $expected, float $actual) {
	$diff = $expected - $actual;
	report($tid, $diff < 0.001 && $diff > -0.001);
}

function report(int $tid, bool $rst) {
	if ($rst) {
		print_r("Test " . $tid . " passed" . PHP_EOL);
	} else {
		print_r("Test " . $tid . " failed" . PHP_EOL);
	}
}

//Test 1
$cal = new SellingROICalculator(1000000.0, 20.0, 4.5, 1000.0, 1.0, 0.0, 360, 0, 50000.0, 1200000.0, 6.0, 1.28, 15000.0, 6, 200.0);
vf(1, 0.043348808849543, $cal->getROI());

//Test 2
$cal = new SellingROICalculator(555000.0, 0.0, 12.02, 1000.0, 1.0, 0.0, 360, 0, 80000.0, 800000.0, 6.0, 0.5, 5000.0, 6, 50.0);
print_r($cal->getROI());
