<?php
require_once 'Employee.php';

class PieceWorker extends Employee {
    private $ratePerItem;
    private $itemsProduced;

    public function __construct($name, $address, $age, $companyName, $ratePerItem, $itemsProduced) {
        parent::__construct($name, $address, $age, $companyName);
        $this->ratePerItem = $ratePerItem;
        $this->itemsProduced = $itemsProduced;
    }

    public function getDetails() {
        return parent::getDetails() . ", Rate Per Item: $this->ratePerItem, Items Produced: $this->itemsProduced";
    }


    public function setRatePerItem($ratePerItem) {
        $this->ratePerItem = $ratePerItem;
    }

    public function setItemsProduced($itemsProduced) {
        $this->itemsProduced = $itemsProduced;
    }
}
?>
