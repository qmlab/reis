<?hh // partial
require_once(__DIR__."/../calculators/roi_calculator.php");
require_once(__DIR__."/../vendor/hh_autoload.php");

function get_rental_expense() {
  $rc = new RentalROICalculator((float)$_POST['total'], (float)$_POST['downpay_ratio'], (float)$_POST['interest_rate'], (float)$_POST['insurance'], (float)$_POST['property_tax_rate'], (float)$_POST['pmi_rate'], (int)$_POST['months'], (int)$_POST['months_pmi'], (float)$_POST['fixing_cost'], (float)$_POST['estimated_rental'], (float)$_POST['property_management_rate'], (float)$_POST['maintenance_rate'], (int)$_POST['holding_months'], (int)$_POST['months_rental'], (float)$_POST['hoa']);
  $exp = number_format($rc->getExpense(), 2, ".", ",");
  echo
	  <div>
	   <strong>${$exp}</strong>
	  </div>;
}

get_rental_expense();
