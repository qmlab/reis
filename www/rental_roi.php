<?hh // partial
require_once(__DIR__."/../calculators/roi_calculator.php");
require_once(__DIR__."/../vendor/hh_autoload.php");

function get_rental_roi() {
  $rc = new RentalROICalculator((float)$_POST['total'], (float)$_POST['downpay_ratio'], (float)$_POST['interest_rate'], (float)$_POST['insurance'], (float)$_POST['property_tax_rate'], (float)$_POST['pmi_rate'], (int)$_POST['months'], (int)$_POST['months_pmi'], (float)$_POST['fixing_cost'], (float)$_POST['estimated_rental'], (float)$_POST['property_management_rate'], (float)$_POST['maintenance_rate'], (int)$_POST['holding_months'], (int)$_POST['months_rental']);
  $cashflow = round($rc->getCashFlow(), 2);
  $roi = round($rc->getROI() * 100, 2);
  echo
	  <div>
	  <p><strong>Cashflow {$cashflow}</strong></p>
	  <p><strong>ROI {$roi}</strong></p>
	  </div>;
}

get_rental_roi();
