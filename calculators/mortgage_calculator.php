<?hh // strict
class MortgageCalculator {
  public function __construct(private float $total, private float $downpay_ratio, private float $interest_rate, private float $insurance, private float $property_tax_rate, private float $pmi_rate, private int $months, private int $months_pmi, private float $hoa) {
  }

  public function getPayment(): float {
    $loan = $this->total * (1 - $this->downpay_ratio / 100);
    $rate = $this->interest_rate / 12 / 100;
    $tax = $this->total * $this->property_tax_rate / 12 / 100;
    $pmi = $this->total * $this->pmi_rate / 12 / 100 * $this->months_pmi / $this->months;
    $hoa = $this->hoa;
    $principal_interest = $loan * $rate * pow(1 + $rate, $this->months) / (pow(1 + $rate, $this->months) - 1);
    return $principal_interest + $tax + $pmi + $this->insurance / 12 + $hoa;
  }

  public function getInterestExpense(int $months_paid): float {
    $loan = $this->total * (1 - $this->downpay_ratio / 100);
    $rate = $this->interest_rate / 12 / 100;
    $payment = $this->getPayment();
    $loan_balance = $loan * (pow(1 + $rate, $this->months) - pow(1 + $rate, $months_paid)) / (pow(1 + $rate, $this->months) - 1);
    return $loan_balance + $payment * $months_paid - $loan;
  }
}
