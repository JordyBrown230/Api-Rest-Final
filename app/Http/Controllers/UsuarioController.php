<?php

namespace App\Http\Controllers;
use App\Helpers\JwtAuth;
use App\Models\Usuario;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    //
    public function __invoke(){

    } 
    public function __construct(){


    }
    public function index(){
        $data = Usuario::all();
        $response =array(
            'status'=>200,
            'message'=>"Consulta generada exitosamente!",
            "data"=>$data
        );
        return response()->json($response,200);
    }
    public function show($id){
        $user = Usuario::find($id);
        if($user) {
            $response = array(
                'status' => 200,
                'message' => 'Usuario encontrado',
                'data' => $user
            );
        } else {
            $response = array(
                'status' => 404,
                'message' => 'Usuario no encontrado'
            );
        }
        return response()->json($response, $response['status']);
    }

    public function store(Request $request){
        $dataInput = $request->input('data',null);
        $data = json_decode($dataInput,true);
        $data =array_map('trim',$data);
        $rules = [
            'nombreUsuario' => 'required|alpha_num|unique:usuario,nombreUsuario',
            'password' => 'required|alpha_num|min:8|max:12',
            'tipoUsuario' =>  'required',
            'cliente' => 'nullable|exists:cliente,cedula|unique:usuario,cliente',
            'empleado' => 'nullable|exists:empleado,idEmpleado|unique:usuario,empleado'
        ];
        $valid = \validator($data,$rules);
        if(!($valid->fails())){
            $user = new Usuario();
            $user->nombreUsuario = $data['nombreUsuario'];
            $user->password = hash('sha256',$data['password']);   
            $user->tipoUsuario = $data['tipoUsuario'];
            $user->cliente =  empty($data['cliente']) ? null : $data['cliente'];
            $user->empleado = empty($data['empleado']) ? null : $data['empleado'];
            $user->save();
            $response = array(
                'status' =>200,
                'message' => 'Guardado exitosamente!',
            );
        }else{
            $response = array(
                'status' =>406,
                'message' => 'Faltan parametros',
                'error' => $valid->errors(),
            );
        }
        return response()->json($response, $response['status']);
    } 
    

    public function update(Request $request, $id){
        $dataInput = $request->input('data',null);
        $data = json_decode($dataInput,true);
        if(!empty($data)){
            $data =array_map('trim',$data);
            $rules = [
                'nombreUsuario' => 'required|alpha_num|unique:usuario,nombreUsuario,'.$id.',idUsuario',
                'password' => 'required|alpha_num|min:8|max:12',
                'tipoUsuario' =>  'required',
                'cliente' => 'nullable|exists:cliente,cedula|unique:usuario,cliente,'.$id.',idUsuario',
                'empleado' => 'nullable|exists:empleado,idEmpleado|unique:usuario,empleado,'.$id.',idUsuario'
            ];
            $valid = \validator($data,$rules);
                if(!($valid->fails())){
                    $user= Usuario::find($id);
                    if ($user) {
                        $user->nombreUsuario = $data['nombreUsuario'];
                        $user->password = hash('sha256',$data['password']);   
                        $user->tipoUsuario = $data['tipoUsuario'];
                        $user->cliente = empty($data['cliente']) ? null : $data['cliente'];
                        $user->empleado = empty($data['empleado']) ? null : $data['empleado'];
                        $user->save();
                        $response = [
                            'status' => 200,
                            'message' => 'Datos actualizados correctamente',
                        ];
                    } else {
                        $response = [
                            'status' => 404,
                            'message' => 'El usuario no existe',
                        ];
                    }
                }else{
                    $response = [
                        'status' => 406,
                        'message' => 'Error de validación, datos incorrectos',
                        'errors' => $valid->errors(),
                    ];
                }
        }else{
            $response = [
                'status' => 400,
                'message' => 'Faltan parametros',
            ];
        }
        return response()->json($response, $response['status']);
    }
    public function destroy($id){
        $user = Usuario::find($id);
        if ($user) {
            $user->delete();
            $response = array(
                'status' => 200,
                'message' => 'Usuario eliminado correctamente'
            );
        } else {
            $response = array(
                'status' => 404,
                'message' => 'Usuario no encontrado'
            );
        }
        return response()->json($response, $response['status']);
    }

    public function login(Request $request){
        $jwtAuth = new JwtAuth();
        $dataInput = $request->input('data',null);
        $data = json_decode($dataInput,true);
        $data = array_map('trim',$data);
        $rules = ['nombreUsuario' => 'required','password'=>'required'];
        $valid = \validator($data,$rules);
        if(!$valid->fails()){
            $response = $jwtAuth->getToken($data['nombreUsuario'],$data['password']);
            $usuario = Usuario::where('nombreUsuario', $data['nombreUsuario'])->first();
            $token = $response;
            $usuario->remember_token = $token;
            $usuario->save();
            return response()->json($response);
        }else{
            $response = array(
                'status' =>406,
                'message' => 'Error en la validacion de los datos',
                'error' => $valid->errors()
            );
        }
        return response()->json($response,406);
    }

    public function getIdentity(Request $request){
        $jwtAuth = new JwtAuth();
        $token = $request->header('beartoken');
        if(isset($token)){
            $response = $jwtAuth->checkToken($token,true);
        }else{
            $response = array(
                'status' =>406,
                'message' => 'Token no encontrado',
            );
        }
        return response()->json($response);
    }

    public function checkToken(Request $request)
    {
        $token = $request->header('beartoken'); // Obtener el token del encabezado de la solicitud
        
        if ($token === null) {
            $response = array(
                'status' => 400,
                'message' => 'Error, token no proporcionado en el encabezado'
            );
            return response()->json($response);
        }
        
        $user = Usuario::where('remember_token', $token)->first();
        
        if ($user) {
            $response = array(
                'status' => 200,
                'message' => 'Token coincide'
            );
        } else {
            $response = array(
                'status' => 400,
                'message' => 'Error, token no coincide con el elemento en la base de datos'
            );
        }
        
        return response()->json($response);
    }
}
