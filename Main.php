<?php

require_once 'Employee.php';
require_once 'Commission.php';
require_once 'HourlyEmployee.php';
require_once 'PieceWorker.php';
require_once 'EmployeeRoster.php';

class Main {
    private EmployeeRoster $roster;
    private $size;

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

    // Function to validate integer input
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
        $choice = 0;

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
                case 4:
                    $this->updateMenu();
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
        echo "[4] Update Employee\n";
        echo "[0] Exit\n";
    }

    public function addMenu() {
        
        $currentCount = count($this->roster->getEmployees());
        echo "Debug: Current employee count: $currentCount, Maximum allowed: {$this->size}\n";
    
        if ($currentCount >= $this->size) {
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
                echo "Employee added successfully as a Commission Employee.\n"; // Success message
                break;
            case 2:
                $hourlyRate = $this->getValidInput("Enter Hourly Rate: ", 'positiveInteger');
                $hoursWorked = $this->getValidInput("Enter Hours Worked: ", 'positiveInteger');
                $employee = new HourlyEmployee($name, $address, $age, $companyName, $hourlyRate, $hoursWorked);
                $this->roster->addEmployee($employee);
                echo "Employee added successfully as an Hourly Employee.\n"; 
                break;
            case 3:
                $ratePerItem = $this->getValidInput("Enter Rate Per Item: ", 'positiveInteger');
                $itemsProduced = $this->getValidInput("Enter Items Produced: ", 'positiveInteger');
                $employee = new PieceWorker($name, $address, $age, $companyName, $ratePerItem, $itemsProduced);
                $this->roster->addEmployee($employee);
                echo "Employee added successfully as a Piece Worker.\n"; 
                break;
            default:
                echo "Invalid choice. Returning to the main menu.\n";
                break;
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

    public function deleteMenu() {
        $employees = $this->roster->getEmployees();
        
        if (empty($employees)) {
            echo "No employees in the roster.\n";
        } else {
            echo "*** Employee List ***\n";
            foreach ($employees as $index => $employee) {
                echo "[$index] " . $employee->getDetails() . "\n";
            }
            
           
            $choice = $this->getValidInput("Enter employee index to delete: ", 'positiveInteger');
            
            if ($choice !== null && $choice >= 0 && $choice < count($employees)) {
                $this->roster->deleteEmployee($choice);
                echo "Employee deleted successfully.\n";
            
             
                echo "*** Updated Employee List ***\n";
                $updatedEmployees = $this->roster->getEmployees();
                if (empty($updatedEmployees)) {
                    echo "No employees left in the roster.\n";
                } else {
                    foreach ($updatedEmployees as $index => $employee) {
                        echo "[$index] " . $employee->getDetails() . "\n";
                    }
                }
            } else {
                echo "Invalid index. Please enter a valid number from the list.\n";
            }
        }
        readline("Press Enter to return to the main menu...");
    }

    public function updateMenu() {
        $employees = $this->roster->getEmployees();
        
        if (empty($employees)) {
            echo "No employees in the roster.\n";
        } else {
            echo "*** Employee List ***\n";
            foreach ($employees as $index => $employee) {
                echo "[$index] " . $employee->getDetails() . "\n";
            }
            
            $choice = $this->getValidInput("Enter employee index to update: ", 'positiveInteger');
            
       
            if ($choice !== null && $choice >= 0 && $choice < count($employees)) {
                $employee = $employees[$choice];
                echo "Updating details for employee: " . $employee->getDetails() . "\n";

           
                $name = $this->getEmployeeDetails("Enter new Employee Name (leave blank to keep current): ");
                if (!empty($name)) {
                    $employee->setName($name);  
                }

                $address = $this->getEmployeeDetails("Enter new Employee Address (leave blank to keep current): ");
                if (!empty($address)) {
                    $employee->setAddress($address);  
                }

                $age = $this->getValidInput("Enter new Employee Age (leave blank to keep current): ", 'positiveInteger');
                if ($age !== null) {
                    $employee->setAge($age);  
                }

                $companyName = $this->getEmployeeDetails("Enter new Company Name (leave blank to keep current): ");
                if (!empty($companyName)) {
                    $employee->setCompanyName($companyName);  
                }

            
                $this->updateEmployeeSpecificDetails($employee);

                echo "Employee updated successfully.\n";
            } else {
                echo "Invalid index. Please enter a valid number from the list.\n";
            }
        }
        readline("Press Enter to return to the main menu...");
    }

    public function updateEmployeeSpecificDetails($employee) {
       
        if ($employee instanceof Commission) {
            $this->updateCommissionEmployee($employee);
        } elseif ($employee instanceof HourlyEmployee) {
            $this->updateHourlyEmployee($employee);
        } elseif ($employee instanceof PieceWorker) {
            $this->updatePieceWorker($employee);
        }
    }

    public function updateCommissionEmployee(Commission $employee) {
        $regularSalary = $this->getValidInput("Enter new Regular Salary (leave blank to keep current): ", 'positiveInteger');
        if ($regularSalary !== null) {
            $employee->setRegularSalary($regularSalary);  
        }

        $itemsSold = $this->getValidInput("Enter new Items Sold (leave blank to keep current): ", 'positiveInteger');
        if ($itemsSold !== null) {
            $employee->setItemsSold($itemsSold);  
        }

        $commissionRate = $this->getValidInput("Enter new Commission Rate (leave blank to keep current): ", 'positiveInteger');
        if ($commissionRate !== null) {
            $employee->setCommissionRate($commissionRate);  
        }
    }

    public function updateHourlyEmployee(HourlyEmployee $employee) {
        $hourlyRate = $this->getValidInput("Enter new Hourly Rate (leave blank to keep current): ", 'positiveInteger');
        if ($hourlyRate !== null) {
            $employee->setHourlyRate($hourlyRate); 
        }

        $hoursWorked = $this->getValidInput("Enter new Hours Worked (leave blank to keep current): ", 'positiveInteger');
        if ($hoursWorked !== null) {
            $employee->setHoursWorked($hoursWorked);  
        }
    }

    public function updatePieceWorker(PieceWorker $employee) {
        $ratePerItem = $this->getValidInput("Enter new Rate Per Item (leave blank to keep current): ", 'positiveInteger');
        if ($ratePerItem !== null) {
            $employee->setRatePerItem($ratePerItem);  
        }

        $itemsProduced = $this->getValidInput("Enter new Items Produced (leave blank to keep current): ", 'positiveInteger');
        if ($itemsProduced !== null) {
            $employee->setItemsProduced($itemsProduced);  
        }
    }

    public function exitProgram() {
        echo "Thank you for using the Employee Roster System.\n";
        exit;
    }

    public function clear() {
     
        echo "\033[H\033[J";
    }
}

?>
