<?php

namespace App\Controllers\API;

use App\Models\EstudianteModel;
use CodeIgniter\RESTful\ResourceController; //clase de codeIgneter

class Estudiantes extends ResourceController
{
    public function __construct()
    {
        $this->model = $this->setModel(new EstudianteModel());
        helper('access_rol');
    }

    public function index()
    {
        try {
         //validacion
         if (!validateAccess(array('admin', 'student', 'teacher'), $this->request->getServer('HTTP_AUTHORIZATION')))
            return  $this->failServerError('El rol no posee acceso al recurso!!');

        $estudiantes = $this->model->findAll();
        if($estudiantes == null)
            return $this->failNotFound("No se han encontrado registros!!");
        return $this->respond($estudiantes);
        }catch (\Exception $e) {
        //log_message('error','[ERROR] {exception}',['exception' => $e]);
            return $this->failServerError('Ha ocurriodo un error en el servidor');
        }
    }


    //Crear un nuevo estudiante
    public function create()
    {
        try {
             //validacion
             if (!validateAccess(array('admin'), $this->request->getServer('HTTP_AUTHORIZATION')))
                return  $this->failServerError('El rol no posee acceso al recurso!!');

            $estudiante = $this->request->getJSON();
            if ($this->model->insert($estudiante)) : //metodo devuelve un bool cuando se ejecute
                $estudiante->id = $this->model->insertID();
                return $this->respondCreated($estudiante);
            else :
                return $this->failValidationError($this->model->validation->listErrors());
            endif;
        } catch (\Exception $e) {
            return $this->failServerError('Ha ocurriodo un error en el servidor');
        }
    }

    //Editar o actualizar registro
    //busqueda
    public function edit($id = null)
    {
        try {
            //validacion
            if (!validateAccess(array('admin', 'student'), $this->request->getServer('HTTP_AUTHORIZATION')))
                return  $this->failServerError('El rol no posee acceso al recurso!!');

            if ($id == null)
                return $this->failValidationError('No se ha ingresado un ID valido');

            $estudiante = $this->model->find($id);
            if ($estudiante == null)
                return $this->failNotFound('No se ha encontrado registro con el id: ' . $id);

            return $this->respond($estudiante);
        } catch (\Exception $e) {
            return $this->failServerError('Ha ocurriodo un error en el servidor');
        }
    }
    //actualizacion
    public function update($id = null)
    {
        try {
            //validacion
            if (!validateAccess(array('admin'), $this->request->getServer('HTTP_AUTHORIZATION')))
                return  $this->failServerError('El rol no posee acceso al recurso!!');

            if ($id == null)
                return $this->failValidationError('No se ha ingresado un ID valido');

            //verifica si existe
            $estudianteVerificado = $this->model->find($id);
            if ($estudianteVerificado == null)
                return $this->failNotFound('No se ha encontrado registro con el id: ' . $id);

            //actualizar
            $estudiante = $this->request->getJSON(); //obtenemos el cuerpo de la peticion

            if ($this->model->update($id, $estudiante)) : //metodo devuelve un bool cuando se ejecute
                $estudiante->id = $id;
                return $this->respondUpdated($estudiante);
            else :
                return $this->failValidationError($this->model->validation->listErrors());
            endif;
        } catch (\Exception $e) {
            return $this->failServerError('Ha ocurriodo un error en el servidor');
        }
    }

    //metodo de eliminacion
    public function delete($id = null)
    {
        try {
             //validacion
             if (!validateAccess(array('admin'), $this->request->getServer('HTTP_AUTHORIZATION')))
                return  $this->failServerError('El rol no posee acceso al recurso!!');

            if ($id == null)
                return $this->failValidationError('No se ha ingresado un ID valido');

            //verifica si existe
            $estudianteVerificado = $this->model->find($id);
            if ($estudianteVerificado == null)
                return $this->failNotFound('No se ha encontrado registro con el id: ' . $id);

            //actualizar

            if ($this->model->delete($id)) : //metodo devuelve un bool cuando se ejecute
                return $this->respondDeleted($estudianteVerificado);
            else :
                return $this->failServerError('No se ha podido eliminar el registro');
            endif;
        } catch (\Exception $e) {
            return $this->failServerError('Ha ocurriodo un error en el servidor');
        }
    }
}
