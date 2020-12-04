<?php
    //funcion para encriptar la contrasenia
    function hashPassword($plainText){
        return password_hash($plainText, PASSWORD_BCRYPT);
    }

    //funcion para verificar si son iguales las contrasenias
    function verifyPassword($plainText, $hash)
    {
        return password_verify($plainText, $hash);
    }
?>