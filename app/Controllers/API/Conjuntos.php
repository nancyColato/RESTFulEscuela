<?php

namespace App\Controllers\API;

use App\Models\EstudianteModel;
use App\Models\GradoModel;
use App\Models\ProfesorModel;
use CodeIgniter\RESTful\ResourceController; //clase de codeIgneter

class Conjuntos extends ResourceController
{

    //Vista principal
    public function show($id = null)
    {
             $modelG=new GradoModel();
             $modelP=new ProfesorModel();
             $modelE =new EstudianteModel();
            
             $idP= $modelG->select('profesor_id')->where(['id' => $id])->first();
             
             $data['grado'] = $modelG->consulta_grado($id);
             $data['profesor']= $modelP->consulta_profesor($idP);
             $data['alumnos']= $modelE->consulta_estudiante($id);

             

            if($data == null)
             return $this->failNotFound('No se ha encontrado registro con el id: '.$id);
            if($data!="id_prof")
             return $this->respond($data);
         

   
    }
}
