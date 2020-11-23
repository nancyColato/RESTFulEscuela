<?php namespace App\Controllers\API;

use App\Models\EstudianteModel;
use CodeIgniter\RESTful\ResourceController;//clase de codeIgneter

class Estudiantes extends ResourceController
{
	public function __construct(){
		$this->model = $this->setModel(new EstudianteModel());
	}

	 public function index()
	 {
		 $estudiantes = $this->model->findAll();
	 	return $this->respond($estudiantes);
	 }

	
}
