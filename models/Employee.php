<?php
// models/Employee.php

class Employee
{
    private $conn;
    private $table = 'employees';

    public $id;
    public $nombre;
    public $email;
    public $puesto;
    public $salario;
    public $fecha_contratacion;
    public $departamento_id;
    public $rol_id;

    public function __construct($db)
    {
        $this->conn = $db;        
    }

    public function read()
    {
        $query = 'SELECT * FROM ' . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Crear un nuevo empleado
    public function create()
    {
        $query = "INSERT INTO " . $this->table . " 
            SET nombre=:nombre, email=:email, puesto=:puesto, 
                salario=:salario, fecha_contratacion=:fecha_contratacion,
                departamento_id=:departamento_id, rol_id=:rol_id";

        $stmt = $this->conn->prepare($query);

        // Sanitizar datos
        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->puesto = htmlspecialchars(strip_tags($this->puesto));
        $this->salario = htmlspecialchars(strip_tags($this->salario));
        $this->fecha_contratacion = htmlspecialchars(strip_tags($this->fecha_contratacion));
        $this->departamento_id = htmlspecialchars(strip_tags($this->departamento_id));
        $this->rol_id = htmlspecialchars(strip_tags($this->rol_id));

        // Vincular parámetros
        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':puesto', $this->puesto);
        $stmt->bindParam(':salario', $this->salario);
        $stmt->bindParam(':fecha_contratacion', $this->fecha_contratacion);
        $stmt->bindParam(':departamento_id', $this->departamento_id);
        $stmt->bindParam(':rol_id', $this->rol_id);

        return $stmt->execute(); // Retorna true o false
    }

    // Leer empleados con filtros
    public function readFilter($nombre = '', $departamento_nombre = null, $rol_nombre = null, $offset = 0, $limit = 10)
    {
        $query = "SELECT e.*, 
                         d.nombre AS departamento_nombre, 
                         r.nombre AS rol_nombre,
                         (CASE 
                             WHEN e.salario > (SELECT AVG(salario) FROM " . $this->table . " WHERE departamento_id = e.departamento_id) 
                             THEN 'por encima' 
                             ELSE 'por debajo' 
                         END) AS salario_comparacion
                  FROM " . $this->table . " e
                  LEFT JOIN departments d ON e.departamento_id = d.id
                  LEFT JOIN roles r ON e.rol_id = r.id
                  WHERE (:nombre IS NULL OR e.nombre LIKE :nombre) 
                  AND (:departamento_nombre IS NULL OR d.nombre LIKE :departamento_nombre)
                  AND (:rol_nombre IS NULL OR r.nombre LIKE :rol_nombre)
                  LIMIT :offset, :limit";
    
        $stmt = $this->conn->prepare($query);
    
        // Preparar parámetros
        $nombre = !empty($nombre) ? "%$nombre%" : null;
        $departamento_nombre = !empty($departamento_nombre) ? "%$departamento_nombre%" : null;
        $rol_nombre = !empty($rol_nombre) ? "%$rol_nombre%" : null;
    
        // Vincular parámetros
        $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $stmt->bindParam(':departamento_nombre', $departamento_nombre, PDO::PARAM_STR);
        $stmt->bindParam(':rol_nombre', $rol_nombre, PDO::PARAM_STR);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    
        // Ejecutar consulta
        $stmt->execute();
    
        return $stmt;
    }

    // Leer un empleado por id
    public function readOne($id)
    {
        $query = "SELECT e.*, 
                         d.nombre as departamento_nombre, 
                         r.nombre as rol_nombre,
                         CASE 
                             WHEN e.salario > (SELECT AVG(salario) 
                                               FROM " . $this->table . " 
                                               WHERE departamento_id = e.departamento_id) 
                             THEN 'Por encima del promedio' 
                             ELSE 'Por debajo del promedio' 
                         END as salario_comparacion
                  FROM " . $this->table . " e
                  LEFT JOIN departments d ON e.departamento_id = d.id
                  LEFT JOIN roles r ON e.rol_id = r.id
                  WHERE e.id = ? LIMIT 0,1";
    
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();
    
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
