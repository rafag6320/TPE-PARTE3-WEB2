<?php 
require_once ('./app/models/task.model.php');
require_once ('./app/views/api.view.php');
class TaskApiController {
    private $model;
    private $view;
    private $data;


    function __construct() {
        $this->model = new TaskModel();
        $this->view = new ApiView();
        $this->data = file_get_contents('php://input');    
    }
    function getData() {
        return json_decode($this->data);
    }
    function get($params = []) {
        if (empty($params)){
            $tareas = $this->model->getTasks();
            $this->view->response($tareas, 200);
        } else {
            $tarea = $this->model->getTask($params[':ID']);
            if(!empty($tarea)) {
                if($params[':subrecurso']) {
                    switch ($params[':subrecurso']) {
                        case 'titulo':
                            $this->view->response($tarea->titulo, 200);
                            break;
                        case 'descripcion':
                            $this->view->response($tarea->descripcion, 200);
                            break;
                            
                        default:
                        $this->view->response(
                            'La tarea no contiene '.$params[':subrecurso'].'.'
                            , 404);
                            break;
                    }
                } else
                    $this->view->response($tarea, 200);
            } else {
                $this->view->response(
                    'La tarea con el id='.$params[':ID'].' no existe.'
                    , 404);
            }
        }
    }
    function create($params = []) {
        $body = $this->getData();

        $nombre = $body->nombre;
        $descripcion = $body->descripcion;
        $genero = $body->id_genero;
        $precio = $body->precio;

        if (empty($nombre) || empty($descripcion) || empty($precio) || empty($genero)) {
            $this->view->response("Complete los datos", 400);
        } else {
            $id = $this->model->insertTask($nombre, $descripcion, $genero, $precio);

            // en una API REST es buena práctica es devolver el recurso creado
            $tarea = $this->model->getTask($id);
            $this->view->response($tarea, 201);
        }

    }

    function update($params = []) {
        $id = $params[':ID'];
        $tarea = $this->model->getTask($id);

        if($tarea) {
            $body = $this->getData();
            $nombre = $body->nombre;
            $descripcion = $body->descripcion;
            $genero = $body->id_genero;
            $precio = $body->precio;
            $this->model->updateTaskData($id, $descripcion, $nombre,$genero, $precio);

            $this->view->response('La tarea con id='.$id.' ha sido modificada.', 200);
        } else {
            $this->view->response('La tarea con id='.$id.' no existe.', 404);
        }
    }
}

?>