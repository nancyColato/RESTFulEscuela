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
        'nombre'                => 'required|alpha_space|min_length[3]|max_length[65]',
        'username'              => 'required|alpha_numeric_space|min_length[3]|max_length[10]',
        'password'              => 'required|regex_match[/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/]|min_length[8]|max_length[250]',
        'rol_id'                => 'required|is_valid_rol',
    ];
    protected $validationMessages = [
        'rol_id'  => ['is_valid_rol' => 'El rol que intenta ingresar no existe.'],
        'password'      => [
            'regex_match' => 'El formato de contraseña es invalido! debe contener numeros, letras en  minusculas y mayusculas',
        ]
    ];

    protected $skipValidation = false;
}