<?php
// controllers/EmployeeController.php

include_once __DIR__ . '/../config/database.php';
include_once __DIR__ . '/../models/Employee.php';


class EmployeeController
{
    private $db;
    private $employee;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->employee = new Employee($this->db);
    }

    // Obtener todos los empleados
    public function getAllEmployees()
    {
        $result = $this->employee->read();
        $num = $result->rowCount();

        if ($num > 0) {
            $employees_arr = array();
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $employee_item = array(
                    'id' => $id,
                    'nombre' => $nombre,
                    'email' => $email,
                    'puesto' => $puesto,
                    'salario' => $salario,
                    'fecha_contratacion' => $fecha_contratacion,
                    'departamento_id' => $departamento_id,
                    'rol_id' => $rol_id
                );
                array_push($employees_arr, $employee_item);
            }
            echo json_encode($employees_arr);
        } else {
            echo json_encode(array('message' => 'No employees found.'));
        }
    }

    // Crear un nuevo empleado
    public function createEmployee()
    {
        $data = json_decode(file_get_contents("php://input"));

        if (!empty($data->nombre) && !empty($data->email) && !empty($data->departamento_id)) {
            $this->employee->nombre = $data->nombre;
            $this->employee->email = $data->email;
            $this->employee->puesto = $data->puesto;
            $this->employee->salario = $data->salario;
            $this->employee->fecha_contratacion = $data->fecha_contratacion;
            $this->employee->departamento_id = $data->departamento_id;
            $this->employee->rol_id = $data->rol_id;

            if ($this->employee->create()) {
                echo json_encode(array('message' => 'Employee created successfully.'));
            } else {
                echo json_encode(array('message' => 'Unable to create employee.'));
            }
        } else {
            echo json_encode(array('message' => 'Incomplete data.'));
        }
    }

    // Obtener empleados con paginación y filtros
    public function getEmployees()
    {
        $nombre = isset($_GET['nombre']) ? $_GET['nombre'] : '';
        $departamento_id = isset($_GET['departamento_id']) ? $_GET['departamento_id'] : null;
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $limit = 10;
        $offset = ($page - 1) * $limit;

        $result = $this->employee->readFilter($nombre, $departamento_id, $offset, $limit);
        $num = $result->rowCount();

        if ($num > 0) {
            $employees_arr = array();
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $employee_item = array(
                    'id' => $id,
                    'nombre' => $nombre,
                    'email' => $email,
                    'puesto' => $puesto,
                    'salario' => $salario,
                    'fecha_contratacion' => $fecha_contratacion,
                    'departamento_id' => $departamento_id,
                    'departamento_nombre' => $departamento_nombre,
                    'rol_id' => $rol_id,
                    'rol_nombre' => $rol_nombre
                );
                array_push($employees_arr, $employee_item);
            }
            echo json_encode($employees_arr);
        } else {
            echo json_encode(array('message' => 'No employees found.'));
        }
    }

    // Obtener un empleado por ID
    public function getEmployeeById($id)
    {
        $employee = $this->employee->readOne($id);

        if ($employee) {
            echo json_encode($employee);
        } else {
            echo json_encode(array('message' => 'Employee not found.'));
        }
    }
}
