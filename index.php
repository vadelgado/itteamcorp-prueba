<?php
// index.php

include_once './controllers/EmployeeController.php';


$employeeController = new EmployeeController();



$requestMethod = $_SERVER["REQUEST_METHOD"];
$pathInfo = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '';

/**
 * Handles HTTP requests for employee-related operations.
 *
 * Routes:
 * - POST /employees: Calls the createEmployee method to create a new employee.
 * - GET /employees: Calls the getEmployees method to retrieve a list of employees.
 * - GET /employees/{id}: Calls the getEmployeeById method to retrieve a specific employee by ID.
 * - GET /employeesAll: Calls the getAllEmployees method to retrieve all employees.
 * - Any other endpoint: Returns a JSON message indicating that the endpoint was not found.
 *
 * @param string $requestMethod The HTTP request method (e.g., 'GET', 'POST').
 * @param string $pathInfo The path information from the request URI.
 * @param object $employeeController The controller object that handles employee operations.
 */
if ($requestMethod == 'POST' && $pathInfo == '/employees') {
    $employeeController->createEmployee();
} elseif ($requestMethod == 'GET' && $pathInfo == '/employees') {
    $employeeController->getEmployees();
} elseif ($requestMethod == 'GET' && preg_match('/\/employees\/(\d+)/', $pathInfo, $matches)) {
    $employeeId = $matches[1];
    $employeeController->getEmployeeById($employeeId);

} else {
    echo json_encode(array('message' => 'Endpoint not found.'));
}
