<?php namespace App\Models\CustomRules;

use App\Models\ProfesorModel;
use App\Models\GradoModel;

class MyCustomRules
{
    //validacion de profesor para grado
    public function is_valid_profesor(int $id): bool
    {
        $model = new ProfesorModel();
        $profesor = $model->find($id);

        return $profesor == null ? false : true;
    }
    //validacion de grado para alumno
    public function is_valid_grado(int $id): bool
    {
        $model = new GradoModel();
        $grado = $model->find($id);

        return $grado == null ? false : true;
    }
}