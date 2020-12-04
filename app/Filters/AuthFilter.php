<?php

namespace App\Filters;

use App\Models\RolModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Config\Services;
use Firebase\JWT\JWT;
use \Firebase\JWT\ExpiredException;

class AuthFilter implements FilterInterface
{
    use ResponseTrait;

    public function before(RequestInterface $request, $arguments = null)
    {
        try {
            $key = Services::getSecretKey();
            $authHeader = $request->getServer('HTTP_AUTHORIZATION');

            if ($authHeader == null)
                return Services::response()->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED, 'No se ha enviado el JWT Requerido!');

            $arr = explode(' ', $authHeader); //para separar el tipo de la cadena codificad
            $jwt = $arr[1]; //asociacion en arrar de la cadena codificad

            $jwt = JWT::decode($jwt, $key, ['HS256']); //decodifica el jwt

            $rolModel = new RolModel();

            $rol = $rolModel->find($jwt->data->rol);

            if ($rol == null)
                return Services::response()->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED, 'El Rol es invalido, Acceso denegado!!');

            return true;
        } catch (ExpiredException $ee) {
            return Services::response()->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED, 'SU TOKEN JWT ha expirado!');
        } catch (\Exception $e) {
            return Services::response()->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR, 'Ocurrio un error en el servidor al validar el TOKEN!');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
