<?php namespace App\Models;

use CodeIgniter\Model;

class ProfesorModel extends Model{

    protected $table            = 'profesor';//nombre de la tabla
    protected $primaryKey       = 'id'; //identificador de la tabla PK
    
    protected $returnType       = 'array';//tratarse como array
    protected $allowedFields    = ['nombre', 'apellido', 'profesion','telefono', 'dui'];//campos de las tablas

    //fechas de cambios
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    //reglas
    protected $validationRules  = [
        'nombre'        => 'required|alpha_space|min_length[3]|max_length[75]',
        'apellido'      => 'required|alpha_space|min_length[3]|max_length[75]',
        'dui'           => 'permit_empty|regex_match[/^\d{8}-\d{1}$/]|min_length[10]|max_length[10]',
        'profesion'        => 'required|alpha|min_length[3]max_length[3]',
        'telefono'        => 'required|alpha_dash|min_length[9]|max_length[9]',
    ];


    protected $skipValidation = false;
}

?>