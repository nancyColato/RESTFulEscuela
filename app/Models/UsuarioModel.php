<?php namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model 
{
    protected $table            =   'usuario';
    protected $primaryKey       =   'id';
    
    protected $allowedFields    =  ['nombre', 'username', 'password', 'rol_id'];

    protected $useTimestamps    = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules  = [
        'nombre'                => 'required|alpha_numeric_space|min_length[3]|max_length[65]',
        'username'              => 'required|alpha_numeric_space|min_length[3]|max_length[10]',
        'password'              => 'required|alpha_numeric_space|min_length[5]|max_length[10]',
        'carnet'                => 'required|iscarnet_regex',
        'rol_id'                => 'required|is_valid_rol',
    ];
    protected $validationMessages = [
        'rol_id'  => ['is_valid_rol' => 'El rol que intenta ingresar no existe.'],
        'username'    => ['iscarnet_regex' => 'El Carnet que intenta ingresar es invalido']
    ];

    protected $skipValidation = false;
}