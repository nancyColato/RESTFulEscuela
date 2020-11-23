<?php namespace App\Models;

use CodeIgniter\Model;

class EstudianteModel extends Model{

    protected $table            = 'estudiante';//nombre de la tabla
    protected $primaryKey       = 'id'; //identificador de la tabla PK
    
    protected $returnType       = 'array';//tratarse como array
    protected $allowedFields    = ['nombre', 'apellido', 'dui', 'genero', 'carnet', 'grado_id' ];//campos de las tablas

    //fechas de cambios
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    //reglas
    protected $validationRules  = [
        'nombre'        => 'required|alpha_space|min_length[3]|max_length[75]',
        'apellido'      => 'required|alpha_space|min_length[3]|max_length[75]',
        'dui'           => 'permit_empty|alpha_space|min_length[10]|max_length[10]',
        'genero'        => 'required|alfa|max_length[1]',
        'grado_id'        => 'required|alpha_dash|min_length[3]|max_length[11]',
        'carnet'      => 'required|regex_match[/^[Uu]20[0-2]{1}[\d{1}]\d{4}$/]|min_length[8]',
    ];

    protected $validationMessages = [
        'carnet'        =>[
            'regex_match'=>'El carent debe tener el formato U20150000'
        ]
    ];

    protected $skipValidation = false;
}

?>