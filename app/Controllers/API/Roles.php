<?php namespace App\Controllers\API;

use App\Models\RolModel;
use CodeIgniter\RESTful\ResourceController;

class Rol extends ResourceController
{
    public function __construct(){
		$this->model = $this->setModel(new RolModel());
		helper('access_rol');
    }
	public function index()
	{
		$Rol = $this->model->findAll();

		return $this->respond($Rol);
	}
	public function create()
	{
		try {
			$rol= $this->request->getJSON();
			if($this->model->insert($rol)):
				$rol->id = $this->model->insertID();
				return $this->respondCreated($rol);
			else:
				return $this->failValidationError($this->model->validation->listErrors());
			endif;

		} catch (\Exception $e) {
			//throw $th;
			return $this->failServerError('Ha ocurrido un error en el servidor');
		}
	}
	public function edit($id = null)
	{
		try {
			if($id==null)
				return $this->failValidationError('No se ha pasado ID Valido');
			$rol = $this->model->find($id);

			if($rol==null)
				return $this->failNotFound('No se ha encontrado un Rol con id: ' .$id);
			
			return $this->respond($rol);

		} catch (\Exception $e) {
			//throw $th;
			return $this->failServerError('Ha ocurrido un error en el servidor');
		}
	}
	public function update($id = null)
	{
		try {
			if($id==null)
				return $this->failValidationError('No se ha pasado ID Valido');
			$verificarRol = $this->model->find($id);

			if($verificarRol==null)
				return $this->failNotFound('No se ha encontrado un Rol con id: ' .$id);
			
			$rol = $this->request->getJSON();
			if($this->model->update($id,$rol)):
				$rol->id= $id;
				return $this->respondUpdated($rol);
			else:
				return $this->failValidationError($this->model->validation->listErrors());
			endif;

		} catch (\Exception $e) {
			//throw $th;
			return $this->failServerError('Ha ocurrido un error en el servidor');
		}
	}
	public function delete($id = null)
	{
		try {
			if($id==null)
				return $this->failValidationError('No se ha pasado ID Valido');
			$verificarRol = $this->model->find($id);

			if($verificarRol==null)
				return $this->failNotFound('No se ha encontrado un Rol con id: ' .$id);
			
			if($this->model->delete($id)):
				return $this->respondDeleted($verificarRol);
			else:
				return $this->failServerError('No se ha Podido borrar el Registro');
			endif;

		} catch (\Exception $e) {
			//throw $th;
			return $this->failServerError('Ha ocurrido un error en el servidor');
		}
	}
}