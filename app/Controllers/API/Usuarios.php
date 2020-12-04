<?php namespace App\Controllers\API;

use App\Models\UsuarioModel;
use CodeIgniter\RESTful\ResourceController;

class Usuarios extends ResourceController
{
    public function __construct(){
        $this->model = $this->setModel(new UsuarioModel());
    }
	public function index()
	{
		$Usuarios = $this->model->findAll();

		return $this->respond($Usuarios);
	}
	public function create()
	{
		try {
			$Usuario= $this->request->getJSON();
			if($this->model->insert($Usuario)):
				$Usuario->id = $this->model->insertID();
				return $this->respondCreated($Usuario);
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
			$Usuario = $this->model->find($id);

			if($Usuario==null)
				return $this->failNotFound('No se ha encontrado un Usuario con id: ' .$id);
			
			return $this->respond($Usuario);

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
			$verificarUsuario = $this->model->find($id);

			if($verificarUsuario==null)
				return $this->failNotFound('No se ha encontrado un Usuario con id: ' .$id);
			
			$Usuario = $this->request->getJSON();
			if($this->model->update($id,$Usuario)):
				$Usuario->id= $id;
				return $this->respondUpdated($Usuario);
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
			$verificarUsuario = $this->model->find($id);

			if($verificarUsuario==null)
				return $this->failNotFound('No se ha encontrado un Usuario con id: ' .$id);
			
			if($this->model->delete($id)):
				return $this->respondDeleted($verificarUsuario);
			else:
				return $this->failServerError('No se ha Podido borrar el Registro');
			endif;

		} catch (\Exception $e) {
			//throw $th;
			return $this->failServerError('Ha ocurrido un error en el servidor');
		}
	}
}