<?hh // partial
require_once(__DIR__."/../calculators/roi_calculator.php");
require_once(__DIR__."/../vendor/hh_autoload.php");

function get_sale_roi() {
  $rc = new SellingROICalculator((float)$_POST['total'], (float)$_POST['downpay_ratio'], (float)$_POST['interest_rate'], (float)$_POST['insurance'], (float)$_POST['property_tax_rate'], (float)$_POST['pmi_rate'], (int)$_POST['months'], (int)$_POST['months_pmi'], (float)$_POST['fixing_cost'], (float)$_POST['estimated_price'], (float)$_POST['commission_rate'], (float)$_POST['excise_tax_rate'], (float)$_POST['closing_cost'], (int)$_POST['holding_months'], (float)$_POST['hoa']);
  $roi = round($rc->getROI() * 100, 2);
  echo
	  <div>
	   <strong id="sale_roi_value">{$roi}%</strong>
	  </div>;
}

get_sale_roi();
