<?php namespace App\Controllers\API;

use App\Models\UsuarioModel;
use CodeIgniter\RESTful\ResourceController;

class Usuarios extends ResourceController
{
    public function __construct(){
		$this->model = $this->setModel(new UsuarioModel());
		helper('secure_password');
    }
	public function index()
	{
		$Usuarios = $this->model->findAll();

		return $this->respond($Usuarios);
	}
	public function create()
	{
		try {
			$usuario= $this->request->getJSON();
			//encrita contraseña
			$usuario->password = hashPassword($usuario->password);
			if($this->model->insert($usuario)):
				$usuario->id = $this->model->insertID();
				return $this->respondCreated($usuario);
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
			$usuario = $this->model->find($id);

			if($usuario==null)
				return $this->failNotFound('No se ha encontrado un usuario con id: ' .$id);
			
			return $this->respond($usuario);

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
				return $this->failNotFound('No se ha encontrado un usuario con id: ' .$id);
			
			$usuario = $this->request->getJSON();
			
			//encripcaion de password
			$usuario->password = hashPassword($usuario->password);
			if($this->model->update($id,$usuario)):
				$usuario->id= $id;
				return $this->respondUpdated($usuario);
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