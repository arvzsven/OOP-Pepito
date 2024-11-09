<?php
require_once 'Employee.php';

class HourlyEmployee extends Employee {
    private $hourlyRate;
    private $hoursWorked;

    public function __construct($name, $address, $age, $companyName, $hourlyRate, $hoursWorked) {
        parent::__construct($name, $address, $age, $companyName);
        $this->hourlyRate = $hourlyRate;
        $this->hoursWorked = $hoursWorked;
    }

    public function getDetails() {
        return parent::getDetails() . ", Hourly Rate: $this->hourlyRate, Hours Worked: $this->hoursWorked";
    }

    
    public function setHourlyRate($hourlyRate) {
        $this->hourlyRate = $hourlyRate;
    }

    public function setHoursWorked($hoursWorked) {
        $this->hoursWorked = $hoursWorked;
    }
}
?>
