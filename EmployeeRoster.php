<?php

class EmployeeRoster {
    private array $employees = [];

    public function addEmployee(Employee $employee) {
        $this->employees[] = $employee;
    }

    public function deleteEmployee(int $index) {
        if (isset($this->employees[$index])) {
            unset($this->employees[$index]);
            $this->employees = array_values($this->employees); 
        }
    }

    public function getEmployees(): array {
        return $this->employees;
    }
}

?>

