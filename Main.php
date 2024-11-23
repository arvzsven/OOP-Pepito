<?php

require_once 'Employee.php';
require_once 'Commission.php';
require_once 'HourlyEmployee.php';
require_once 'PieceWorker.php';
require_once 'EmployeeRoster.php';

class Main {
    private EmployeeRoster $roster;
    private int $size;

    public function __construct() {
        $this->roster = new EmployeeRoster();
        $this->size = 0;
    }

    public function start() {
        $this->clear();
        echo "Welcome to the Employee Roster System!\n";
        
        do {
            $this->size = $this->getValidInput("Enter the size of the roster: ", 'positiveInteger');
            if ($this->size === null) {
                echo "Invalid input. Please enter a positive number.\n";
            }
        } while ($this->size === null);

        $this->entrance();
    }

    public function getValidInput($prompt, $type) {
        $input = readline($prompt);
        switch ($type) {
            case 'positiveInteger':
                if (is_numeric($input) && $input > 0) {
                    return (int)$input;
                }
                return null;
            default:
                return $input;
        }
    }

    public function entrance() {
        while (true) {
            $this->clear();
            $this->menu();
            $choice = $this->getValidInput("Enter your choice: ", 'positiveInteger');

            switch ($choice) {
                case 1:
                    $this->addMenu();
                    break;
                case 2:
                    $this->deleteMenu();
                    break;
                case 3:
                    $this->displayMenu();
                    break;
                case 0:
                    $this->exitProgram();
                    break;
                default:
                    echo "Invalid input. Please try again.\n";
                    readline("Press \"Enter\" key to continue...");
                    break;
            }
        }
    }

    public function menu() {
        echo "*** EMPLOYEE ROSTER MENU ***\n";
        echo "[1] Add Employee\n";
        echo "[2] Delete Employee\n";
        echo "[3] Display Employees\n";
        echo "[0] Exit\n";
    }

    public function addMenu() {
        if (count($this->roster->getEmployees()) >= $this->size) {
            echo "Roster is full. You cannot add more employees.\n";
            readline("Press Enter to return to the main menu...");
            return;
        }

        $name = $this->getEmployeeDetails("Enter Employee Name: ");
        $address = $this->getEmployeeDetails("Enter Employee Address: ");
        $age = $this->getValidInput("Enter Employee Age: ", 'positiveInteger');
        $companyName = $this->getEmployeeDetails("Enter Company Name: ");

        $this->empType($name, $address, $age, $companyName);
    }

    public function getEmployeeDetails($prompt) {
        return readline($prompt);
    }

    public function empType($name, $address, $age, $companyName) {
        echo "[1] Commission Employee\n";
        echo "[2] Hourly Employee\n";
        echo "[3] Piece Worker\n";
        $type = $this->getValidInput("Choose Employee Type: ", 'positiveInteger');
    
        switch ($type) {
            case 1:
                $regularSalary = $this->getValidInput("Enter Regular Salary: ", 'positiveInteger');
                $itemsSold = $this->getValidInput("Enter Items Sold: ", 'positiveInteger');
                $commissionRate = $this->getValidInput("Enter Commission Rate: ", 'positiveInteger');
                $employee = new Commission($name, $address, $age, $companyName, $regularSalary, $itemsSold, $commissionRate);
                $this->roster->addEmployee($employee);
                break;
            case 2:
                $hourlyRate = $this->getValidInput("Enter Hourly Rate: ", 'positiveInteger');
                $hoursWorked = $this->getValidInput("Enter Hours Worked: ", 'positiveInteger');
                $employee = new HourlyEmployee($name, $address, $age, $companyName, $hourlyRate, $hoursWorked);
                $this->roster->addEmployee($employee);
                break;
            case 3:
                $ratePerItem = $this->getValidInput("Enter Rate Per Item: ", 'positiveInteger');
                $itemsProduced = $this->getValidInput("Enter Items Produced: ", 'positiveInteger');
                $employee = new PieceWorker($name, $address, $age, $companyName, $ratePerItem, $itemsProduced);
                $this->roster->addEmployee($employee);
                break;
            default:
                echo "Invalid choice. Returning to the main menu.\n";
        }
        readline("Press Enter to return to the main menu...");
    }

    public function deleteMenu() {
        $employees = $this->roster->getEmployees();
    
        if (empty($employees)) {
            echo "No employees in the roster.\n";
        } else {
            echo "*** Employee List ***\n";
            foreach ($employees as $index => $employee) {
                echo "[$index] " . $employee->getDetails() . "\n";
            }
    
            $choice = $this->getValidInput("Enter employee index to delete: ", 'nonNegativeInteger'); 
    
            if ($choice !== null && $choice >= 0 && $choice < count($employees)) {
                $this->roster->deleteEmployee($choice);
                echo "Employee deleted successfully.\n";
            } else {
                echo "Invalid index. Please try again.\n";
            }
        }
        readline("Press Enter to return to the main menu...");
    }
    

    public function displayMenu() {
        $employees = $this->roster->getEmployees();

        if (empty($employees)) {
            echo "No employees in the roster.\n";
        } else {
            foreach ($employees as $employee) {
                echo $employee->getDetails() . "\n";
            }
        }
        readline("Press Enter to return to the main menu...");
    }

    public function exitProgram() {
        echo "Thank you for using the Employee Roster System.\n";
        exit;
    }

    public function clear() {
        echo "\033[H\033[J";
    }
}

$main = new Main();
$main->start();

?>
