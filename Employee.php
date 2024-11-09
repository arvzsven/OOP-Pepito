
<?php

class Employee {
    private $name;
    private $address;
    private $age;
    private $companyName;

    public function __construct($name, $address, $age, $companyName) {
        $this->name = $name;
        $this->address = $address;
        $this->age = $age;
        $this->companyName = $companyName;
    }

    public function getDetails() {
        return "Name: $this->name, Address: $this->address, Age: $this->age, Company: $this->companyName";
    }


    public function setName($name) {
        $this->name = $name;
    }

    public function setAddress($address) {
        $this->address = $address;
    }

    public function setAge($age) {
        $this->age = $age;
    }

    public function setCompanyName($companyName) {
        $this->companyName = $companyName;
    }
}
?>
