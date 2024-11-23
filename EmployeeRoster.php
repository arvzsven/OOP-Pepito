<?php

class EmployeeRoster {
    private array $employees = [];

    public function addEmployee($employee) {
        $this->employees[] = $employee;
    }

    public function getEmployees(): array {
        return $this->employees;
    }

    public function deleteEmployee($index): bool {
        if (isset($this->employees[$index])) {
            array_splice($this->employees, $index, 1);
            return true;
        }
        return false;
    }
}

?>
