<?php

namespace App\Helpers;
use Firebase\JWT\Key;
use App\Models\Usuario;
use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;

class JwtAuth{
    private $key;
    function __construct(){
        $this->key ="Clave secreta abc123";
    }
    public function getToken($nombreUsuario,$password){
        $user = Usuario::where(['nombreUsuario'=>$nombreUsuario,'password'=>hash('sha256',$password)])->first();
        if(is_object($user)){
            $token = array(
                'iss'=>$user->idUsuario,
                'nombreUsuario'=>$user->nombreUsuario,
                'tipoUsuario'=>$user->tipoUsuario,
                'cliente' =>$user->cliente,
                'empleado'=>$user->empleado,
                'iat'=>time(),
                'exp'=>time()+(2000)
            );
            $data = JWT::encode($token,$this->key,'HS256');
        }else{
            $data = array(
                'status' =>401,
                'message'=>"Datos de Autenticación incorrectos"
            );
        }
        return $data;
    }
    public function checkToken($jwt,$getId=false){
        $auth =false;
        if(isset($jwt)){
            try{
                $decoded = JWT::decode($jwt,new Key($this->key,'HS256'));
            }catch(\DomainException $ex){
                $auth = false;
            }catch(\UnexpectedValueException $ex){
                $auth = false;
            }catch(ExpiredException $ex){
                $auth = false;
            }
            if(!empty($decoded)&& is_object($decoded)&& isset($decoded->iss)){
                $auth = true;
            }
            if($getId && $auth){
                return $decoded;
            }
        }
        return $auth;
    }
}
