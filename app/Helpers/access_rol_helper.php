<?php

use App\Models\RolModel;
use CodeIgniter\Config\Services;
use Firebase\JWT\JWT;

function validateAccess($roles, $authHeader)
{
    //validacion de roles vacio
    if (!is_array($roles))
        return false;

    $key = Services::getSecretKey();
    $arr = explode(' ', $authHeader); //para separar el tipo de la cadena codificad
    $jwt = $arr[1];
    $jwt = JWT::decode($jwt, $key, ['HS256']); //decodifica el jwt

    //rol
    $rolModel = new RolModel();
    $rol = $rolModel->find($jwt->data->rol);
    if ($rol == null)
        return false;

    //validacion que exista el rol
    if (!in_array($rol["nombre"], $roles))
        return false;

    return true;
}
