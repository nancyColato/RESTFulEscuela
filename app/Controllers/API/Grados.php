<?php

namespace App\Controllers\API;

use App\Models\GradoModel;
use CodeIgniter\RESTful\ResourceController; //clase de codeIgneter

class Grados extends ResourceController
{
    //constructor de seteo del modelo
    public function __construct()
    {
        $this->model = $this->setModel(new GradoModel());
        helper('access_rol');
    }

    //Vista principal
    public function index()
    {
        try {
            //validacion
            if (!validateAccess(array('admin'), $this->request->getServer('HTTP_AUTHORIZATION')))
                return  $this->failServerError('El rol no posee acceso al recurso!!');

            //Datos de secuencia
            $grados = $this->model->findAll();
            if ($grados == null)
                return $this->failNotFound("No se han encontrado registros!!");
            return $this->respond($grados);
        } catch (\Exception $e) {
            return $this->failServerError('Ha ocurriodo un error en el servidor');
        }
    }

    //Crear un nuevo grado
    public function create()
    {
        try {
            //validacion de usuario
            if (!validateAccess(array('admin'), $this->request->getServer('HTTP_AUTHORIZATION')))
                return  $this->failServerError('El rol no posee acceso al recurso!!');

            //Datos de secuencia
            $grado = $this->request->getJSON();
            if ($this->model->insert($grado)) : //metodo devuelve un bool cuando se ejecute
                $grado->id = $this->model->insertID();
                return $this->respondCreated($grado);
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
            if (!validateAccess(array('admin'), $this->request->getServer('HTTP_AUTHORIZATION')))
                return  $this->failServerError('El rol no posee acceso al recurso!!');

            //Datos de secuencia
            if ($id == null)
                return $this->failValidationError('No se ha ingresado un ID valido');

            $grado = $this->model->find($id);
            if ($grado == null)
                return $this->failNotFound('No se ha encontrado registro con el id: ' . $id);

            return $this->respond($grado);
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

            //Datos de secuencia
            if ($id == null)
                return $this->failValidationError('No se ha ingresado un ID valido');

            //verifica si existe
            $gradoVerificado = $this->model->find($id);
            if ($gradoVerificado == null)
                return $this->failNotFound('No se ha encontrado registro con el id: ' . $id);

            //actualizar
            $grado = $this->request->getJSON(); //obtenemos el cuerpo de la peticion

            if ($this->model->update($id, $grado)) : //metodo devuelve un bool cuando se ejecute
                $grado->id = $id;
                return $this->respondUpdated($grado);
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

            //Datos de secuencia
            if ($id == null)
                return $this->failValidationError('No se ha ingresado un ID valido');

            //verifica si existe
            $gradoVerificado = $this->model->find($id);
            if ($gradoVerificado == null)
                return $this->failNotFound('No se ha encontrado registro con el id: ' . $id);

            //actualizar

            if ($this->model->delete($id)) : //metodo devuelve un bool cuando se ejecute
                return $this->respondDeleted($gradoVerificado);
            else :
                return $this->failServerError('No se ha podido eliminar el registro');
            endif;
        } catch (\Exception $e) {
            return $this->failServerError('Ha ocurriodo un error en el servidor');
        }
    }
}
