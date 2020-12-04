<?php

namespace App\Controllers;

use App\Models\UsuarioModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Config\Services;
use Firebase\JWT\JWT;

class Auth extends BaseController
{
    use ResponseTrait;
    
    public function __construct()
    {
       helper('secure_password');
    }

    public function login()
    {
        try {
            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');

            $usuarioModel = new UsuarioModel();

            
            $validateUsuario = $usuarioModel->where('username', $username)->first();
            
            if ($validateUsuario == null)
                return $this->failNotFound("Usuario invalido, no encontrado!");

            if(verifyPassword($password, $validateUsuario["password"])):
                $jwt = $this->generateJWT($validateUsuario);
                
                return $this->respond(['Token' => $jwt], 201);
            else:
                return $this->failValidationError("Contraseña invalida!!".hashPassword($password));
            endif;
            //$where = ['username' => $username, 'password' => $password];
            //$validateUsuario = $usuarioModel->where($where)->find();
            
        } catch (\Exception $e) {
            return $this->failServerError('Ha ocurriodo un error en el servidor');
        }
    }

    protected function generateJWT($usuario)
    {
        $key = Services::getSecretKey();
        $time = time();

        $payload = [
            'aud' => base_url(),
            'iat' => $time,
            'exp' => $time + 1200,
            'data' => [
                'usuario' => $usuario["username"],
                'rol' => $usuario["rol_id"],
            ]
        ];

        $jwt = JWT::encode($payload, $key);
        return $jwt;
    }
}
