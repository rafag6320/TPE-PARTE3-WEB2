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
        $query = $this->db->prepare('SELECT * FROM tareas WHERE id = ?');
        $query->execute([$id]);

        // $task es una tarea sola
        $task = $query->fetch(PDO::FETCH_OBJ);

        return $task;
    }

    /**
     * Inserta la tarea en la base de datos
     */
    function insertTask($title, $description, $priority) {
        $query = $this->db->prepare('INSERT INTO tareas (titulo, descripcion, prioridad) VALUES(?,?,?)');
        $query->execute([$title, $description, $priority]);

        return $this->db->lastInsertId();
    }
    
    function deleteTask($id) {
        $query = $this->db->prepare('DELETE FROM tareas WHERE id = ?');
        $query->execute([$id]);
    }

    function updateTask($id) {    
        $query = $this->db->prepare('UPDATE tareas SET finalizada = 1 WHERE id = ?');
        $query->execute([$id]);
    }

    function updateTaskData($id, $titulo, $descripcion, $prioridad) {    
        $query = $this->db->prepare('UPDATE tareas SET titulo = ?, descripcion = ?, prioridad = ? WHERE id = ?');
        $query->execute([$titulo, $descripcion, $prioridad, $id]);
    }
}

?>