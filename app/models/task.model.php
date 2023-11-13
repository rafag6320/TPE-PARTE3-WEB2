<?php 

class TaskModel {
    private $db;
    function __construct() {
        $this->db = new PDO('mysql:host='. MYSQL_HOST .';dbname='. MYSQL_DB .';charset=utf8', MYSQL_USER, MYSQL_PASS);
    }

    function getTasks() {
        $query = $this->db->prepare('SELECT * FROM productos');
        $query->execute();

        // $tasks es un arreglo de tareas
        $tasks = $query->fetchAll(PDO::FETCH_OBJ);

        return $tasks;
    }

    function getTask($id) {
        $query = $this->db->prepare('SELECT * FROM productos WHERE id = ?');
        $query->execute([$id]);

        // $task es una tarea sola
        $task = $query->fetch(PDO::FETCH_OBJ);

        return $task;
    }
    function getCreciente() {
        $query = $this->db->prepare('SELECT * FROM productos ORDER BY nombre ASC');
        $query->execute();

        $tasks = $query->fetchAll(PDO::FETCH_OBJ);

        return $tasks;
    }
    function getDecreciente() {
        $query = $this->db->prepare('SELECT * FROM productos ORDER BY nombre DESC');
        $query->execute();

        $tasks = $query->fetchAll(PDO::FETCH_OBJ);

        return $tasks;
    }

    /**
     * Inserta la tarea en la base de datos
     */
    function insertTask($nombre, $descripcion, $genero, $precio) {
        $query = $this->db->prepare('INSERT INTO productos (nombre, descripcion, id_genero, precio) VALUES(?,?,?,?)');
        $query->execute([$nombre, $descripcion, $genero, $precio]);

        return $this->db->lastInsertId();
    }
    
    function deleteTask($id) {
        $query = $this->db->prepare('DELETE FROM productos WHERE id = ?');
        $query->execute([$id]);
    }
    function updateTaskData($id, $descripcion, $nombre,$genero, $precio) {    
        $query = $this->db->prepare('UPDATE productos SET nombre = ?, descripcion = ?, id_genero = ?, precio = ? WHERE id = ?');
        $query->execute([$nombre, $descripcion, $genero, $precio, $id]);
    }
}

?>