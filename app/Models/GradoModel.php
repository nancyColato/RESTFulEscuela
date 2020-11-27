<?php

namespace App\Models;

use CodeIgniter\Model;

class GradoModel extends Model
{

    protected $table            = 'grado'; //nombre de la tabla
    protected $primaryKey       = 'id'; //identificador de la tabla PK

    protected $returnType       = 'array'; //tratarse como array
    protected $allowedFields    = ['grado', 'seccion', 'profesor_id']; //campos de las tablas

    //fechas de cambios
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';


    //reglas
    protected $validationRules  = [
        'grado'        => 'required|alpha_space|min_length[3]|max_length[60]',
        'seccion'      => 'required|alpha|min_length[1]|max_length[2]',
        'profesor_id'  => 'required|integer|is_valid_profesor',
    ];

    //validaciones
    protected $validationMessages = [
        'profesor_id'        => [
            'is_valid_profesor' => 'El Id del profesor es invalido!',
            'required' => 'El campo {field} es requerido!',
            'integer' => 'El campo {field} solo acepta numeros',
        ]
    ];

    protected $skipValidation = false;

    //funcion para endpoint
    function consulta_grado($id) 
    { 
            return $this->asArray()
            -> select('g.grado, g.seccion')
            ->from('grado g')
            ->where(['g.id'=>$id])
            ->first();
    }
}
?>