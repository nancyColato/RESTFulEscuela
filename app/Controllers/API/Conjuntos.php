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
        if ($id == null)
            return $this->failValidationError('No se ha ingresado un ID valido');

        $modelG = new GradoModel();
        $modelP = new ProfesorModel();
        $modelE = new EstudianteModel();

        //consulta ID de profesor
        $idP = $modelG->select('profesor_id')->where(['id' => $id])->first();

        $data['Grado'] = $modelG->consulta_grado($id);
        $data['Profesor'] = $modelP->consulta_profesor($idP);
        $data['Alumnos'] = $modelE->consulta_estudiante($id);

        //valida si esta acio
        if ($data == null)
            return $this->failNotFound('No se ha encontrado registro con el id: ' . $id);

        //valida que no se imprima el id que se extrae
        if ($data != "id_prof")
            return $this->respond($data);
    }
}
