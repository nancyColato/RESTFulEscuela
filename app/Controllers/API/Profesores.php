<?php namespace App\Controllers\API;

use App\Models\ProfesorModel;
use CodeIgniter\RESTful\ResourceController;//clase de codeIgneter

class Profesores extends ResourceController
{
    //constructor de seteo del modelo
	public function __construct(){
        $this->model = $this->setModel(new ProfesorModel());
        helper('access_rol');
	}

    //Vista principal
	 public function index()
	 {
        try {
            //validacion
            if (!validateAccess(array('admin', 'teacher'), $this->request->getServer('HTTP_AUTHORIZATION')))
                return  $this->failServerError('El rol no posee acceso al recurso!!');

         $profesores = $this->model->findAll();
         
         if($profesores == null)
            return $this->failNotFound("No se han encontrado registros!!");

	 	return $this->respond($profesores);
	         }catch (\Throwable $th) {
        //throw $th;
            }
    }
     
     //Crear un nuevo profesor
     public function create()
     {
         try {
              //validacion
                if (!validateAccess(array('admin'), $this->request->getServer('HTTP_AUTHORIZATION')))
                    return  $this->failServerError('El rol no posee acceso al recurso!!');
             
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
            //validacion
            if (!validateAccess(array('admin'), $this->request->getServer('HTTP_AUTHORIZATION')))
                return  $this->failServerError('El rol no posee acceso al recurso!!');

             if($id == null)
                 return $this->failValidationError('No se ha ingresado un ID valido');

                $profesor = $this->model->find($id);
                if($profesor == null)
                    return $this->failNotFound('No se ha encontrado registro con el id: '.$id);
            
             return $this->respond($profesor);

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
            //validacion
            if (!validateAccess(array('admin'), $this->request->getServer('HTTP_AUTHORIZATION')))
                return  $this->failServerError('El rol no posee acceso al recurso!!');

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
