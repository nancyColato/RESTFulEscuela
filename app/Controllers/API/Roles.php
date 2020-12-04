<?php

namespace App\Controllers\API;

use App\Models\RolModel;
use CodeIgniter\RESTful\ResourceController;

class Roles extends ResourceController
{
  //constructor
  public function __construct()
  {
    $this->model = $this->setModel(new RolModel());
    helper('access_rol');
  }

  public function index()
  {
    try {
      //validacion
      if (!validateAccess(array('admin'), $this->request->getServer('HTTP_AUTHORIZATION')))
        return  $this->failServerError('El rol no posee acceso al recurso!!');

      //Datos de secuencia
      $roles = $this->model->findAll();

      if ($roles == null)
        return $this->failNotFound("No se han encontrdao Registros!");

      return $this->respond($roles);
    } catch (\Exception $e) {
      return $this->failServerError('Ha ocurriodo un error en el servidor!!!');
    }
  }

  public function create()
  {
    try {
      //validacion
      if (!validateAccess(array('admin'), $this->request->getServer('HTTP_AUTHORIZATION')))
        return  $this->failServerError('El rol no posee acceso al recurso!!');

      //Datos de secuencia
      $rol = $this->request->getJSON();

      if ($this->model->insert($rol)) :
        $rol->id = $this->model->insertID();
        return $this->respondCreated($rol);
      else :
        return $this->failValidationError($this->model->validation->listErrors());
      endif;
    } catch (\Exception $e) {
      return $this->failServerError('Ha ocurriodo un error en el servidor!!!');
    }
  }

  public function edit($id = null)
  {
    try {
      //validacion
      if (!validateAccess(array('admin'), $this->request->getServer('HTTP_AUTHORIZATION')))
        return  $this->failServerError('El rol no posee acceso al recurso!!');

      //Datos de secuencia
      if ($id == null)
        return $this->failValidationError('No se ha ingresado un ID valido');

      $rol = $this->model->find($id);
      if ($rol == null)
        return $this->failNotFound('No se ha encontrado registro con el id: ' . $id);

      return $this->respond($rol);
    } catch (\Exception $e) {
      return $this->failServerError('Ha ocurriodo un error en el servidor!!!');
    }
  }

  public function update($id = null)
  {
    try {
      //validacion
      if (!validateAccess(array('admin'), $this->request->getServer('HTTP_AUTHORIZATION')))
        return  $this->failServerError('El rol no posee acceso al recurso!!');

      //Datos de secuencia
      if ($id == null)
        return $this->failValidationError('No se ha ingresado un ID valido');

      $rolVerificado = $this->model->find($id);
      if ($rolVerificado == null)
        return $this->failNotFound('No se ha encontrado registro con el id: ' . $id);

      //actualizar  
      $rol = $this->request->getJSON();

      if ($this->model->update($id, $rol)) :
        $rol->id = $id;
        return $this->respondUpdated($rol);
      else :
        return $this->failValidationError($this->model->validation->listErrors());
      endif;
    } catch (\Exception $e) {
      return $this->failServerError('Ha ocurriodo un error en el servidor!!!');
    }
  }

  public function delete($id = null)
  {
    try {
      //validacion
      if (!validateAccess(array('admin'), $this->request->getServer('HTTP_AUTHORIZATION')))
        return  $this->failServerError('El rol no posee acceso al recurso!!');

      //Datos de secuencia
      if ($id == null)
        return $this->failValidationError('No se ha ingresado un ID valido');

      $rolVerificado = $this->model->find($id);
      if ($rolVerificado == null)
        return $this->failNotFound('No se ha encontrado registro con el id: ' . $id);

      //eliminar  
      if ($this->model->delete($id)) :
        return $this->respondDeleted($rolVerificado);
      else :
        return $this->failServerError("No se ha podido eliminar el registro!!!");
      endif;
    } catch (\Exception $e) {
      return $this->failServerError('Ha ocurriodo un error en el servidor!!!');
    }
  }
}
