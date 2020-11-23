<?php namespace App\Controllers\API;

use App\Models\ProfesorModel;
use CodeIgniter\RESTful\ResourceController;//clase de codeIgneter

class Profesores extends ResourceController
{
    //constructor de seteo del modelo
	public function __construct(){
		$this->model = $this->setModel(new ProfesorModel());
	}

    //Vista principal
	 public function index()
	 {
		 $profesores = $this->model->findAll();
	 	return $this->respond($profesores);
	 }
     
     //Crear un nuevo profesor
     public function create()
     {
         try {
             
            $profesor = $this->request->getJSON();
            if($this->model->insert($profesor)): //metodo devuelve un bool cuando se ejecute
                $profesor->id = $this->model->insertID();
                return $this->respondCreated($profesor);
            else:
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
             if($id == null)
                 return $this->failValidationError('No se ha ingresado un ID valido');

                $profesor = $this->model->find($id);
                if($profesor == null)
                    return $this->failNotFound('No se ha encontrado un cliente con el id: '.$id);
            
             return $this->respond($profesor);

         } catch (\Exception $e) {
             return $this->failServerError('Ha ocurriodo un error en el servidor');
         }
    }
    //actualizacion
     public function update($id = null)
	{
        try {
             if($id == null)
                 return $this->failValidationError('No se ha ingresado un ID valido');

            //verifica si existe
            $profesorVerificado = $this->model->find($id);
            if($profesorVerificado == null)
                return $this->failNotFound('No se ha encontrado registro con el id: '.$id);
            
            //actualizar
            $profesor =$this->request->getJSON();//obtenemos el cuerpo de la peticion
            
            if($this->model->update($id,$profesor)): //metodo devuelve un bool cuando se ejecute
                $profesor -> id = $id;
                return $this->respondUpdated($profesor);
            else:
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
            if($id == null)
                return $this->failValidationError('No se ha ingresado un ID valido');

           //verifica si existe
           $profesorVerificado = $this->model->find($id);
           if($profesorVerificado == null)
               return $this->failNotFound('No se ha encontrado registro con el id: '.$id);
           
           //actualizar
           
           if($this->model->delete($id)): //metodo devuelve un bool cuando se ejecute
               return $this->respondDeleted($profesorVerificado);
           else:
            return $this->failServerError('No se ha podido eliminar el registro');
           endif;


        } catch (\Exception $e) {
            return $this->failServerError('Ha ocurriodo un error en el servidor');
        }
    }
     
	
}
