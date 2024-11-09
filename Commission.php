<?php
require_once 'Employee.php';

class Commission extends Employee {
    private $regularSalary;
    private $itemsSold;
    private $commissionRate;

    public function __construct($name, $address, $age, $companyName, $regularSalary, $itemsSold, $commissionRate) {
        parent::__construct($name, $address, $age, $companyName);
        $this->regularSalary = $regularSalary;
        $this->itemsSold = $itemsSold;
        $this->commissionRate = $commissionRate;
    }

    public function getDetails() {
        return parent::getDetails() . ", Regular Salary: $this->regularSalary, Items Sold: $this->itemsSold, Commission Rate: $this->commissionRate%";
    }

    public function setRegularSalary($regularSalary) {
        $this->regularSalary = $regularSalary;
    }

    public function setItemsSold($itemsSold) {
        $this->itemsSold = $itemsSold;
    }

    public function setCommissionRate($commissionRate) {
        $this->commissionRate = $commissionRate;
    }
}
?>
