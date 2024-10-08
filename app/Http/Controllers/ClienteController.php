<?php

namespace App\Http\Controllers;
use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function __construct()
    {
        
    }

    public function __invoke(){

    }

    public function index(){
        $data=Cliente::all();
        $response=array(
            'status'=>200,
            'message'=>'Consulta completada satisfactoriamente',
            'data'=>$data
        );
        return response()->json($response,200);
    }

       public function show($id)
    {
        $cliente = Cliente::find($id);
        if($cliente) {
            $response = array(
                'status' => 200,
                'message' => 'Cliente encontrado',
                'data' => $cliente
            );
        } else {
            $response = array(
                'status' => 404,
                'message' => 'Cliente no encontrado'
            );
        }
        return response()->json($response, $response['status']);
    }

    public function store(Request $request){
    $data_input = $request->input('data', null);

    if (is_array($data_input)) {
        $data = $data_input;
    } else {
        $data = json_decode($data_input, true);
    }

    if (!empty($data)) {
        $data = array_map('trim', $data);

        $rules = [
            'cedula' => 'required|alpha_num|min:8|unique:cliente,cedula',
            'nombre' => 'required|regex:/^[a-zA-Z0-9\s.,]+$/u',
            'fechaNac' => 'required|date',
            'email' => 'required|email|unique:cliente,email',

        ];

        $validate = \validator($data, $rules);

        if (!($validate->fails())) {
            $cliente = new Cliente();
            $cliente->cedula = $data['cedula'];
            $cliente->nombre = $data['nombre'];
            $cliente->fechaNac = $data['fechaNac'];
            $cliente->email = $data['email'];
            $cliente->save();

            $response = [
                'status' => 201,
                'message' => 'Datos guardados correctamente',
            ];
        } else {
            $response = [
                'status' => 406,
                'message' => 'Error de validación, datos incorrectos',
                'errors' => $validate->errors(),
            ];
        }
    } else {
        $response = [
            'status' => 400,
            'message' => 'Faltan parametros',
        ];
    }
    return response()->json($response, $response['status']);
    }

    public function update(Request $request, $id){
        $data_input = $request->input('data', null);

        if (is_array($data_input)) {
            $data = $data_input;
        } else {
            $data = json_decode($data_input, true);
        }
    
        if (!empty($data)) {
            $data = array_map('trim', $data);
    
            $rules = [
                'nombre' => 'required|regex:/^[a-zA-Z0-9\s.,]+$/u',
                'fechaNac' => 'required|date',
                'email' => 'required|email|unique:cliente,email,'.$id.',cedula',
            ];
    
            $validate = \validator($data, $rules);
    
            if (!($validate->fails())) {
                $cliente = Cliente::find($id);
                if ($cliente) {
                    $cliente->nombre = $data['nombre'];
                    $cliente->fechaNac = $data['fechaNac'];
                    $cliente->email = $data['email'];
                    $cliente->save();
    
                    $response = [
                        'status' => 200,
                        'message' => 'Datos actualizados correctamente',
                    ];
                } else {
                    $response = [
                        'status' => 404,
                        'message' => 'El cliente no existe',
                    ];
                }
            } else {
                $response = [
                    'status' => 406,
                    'message' => 'Error de validación, datos incorrectos',
                    'errors' => $validate->errors(),
                ];
            }
        } else {
            $response = [
                'status' => 400,
                'message' => 'Faltan parametros',
            ];
        }
        return response()->json($response, $response['status']);
    }
    

    public function destroy($id){
        $cliente = Cliente::find($id);
        if ($cliente) {
            $cliente->delete();
            $response = array(
                'status' => 200,
                'message' => 'Cliente eliminado correctamente'
            );
        } else {
            $response = array(
                'status' => 404,
                'message' => 'Cliente no encontrado'
            );
        }
        return response()->json($response, $response['status']);
    }

    public function getByName($nombre){

        $clientes = Cliente::porNombre($nombre)->get();

        if($clientes->count() > 0) {
            $response = array(
                'status' => 200,
                'message' => 'Cliente encontrado',
                'data' => $clientes
            );
        } else {
            $response = array(
                'status' => 404,
                'message' => 'Cliente no encontrado'
            );
        }
        return response()->json($response, $response['status']);

    }

    public function getNumsByClient($id)
    {
        $cliente = new Cliente();
        $numerosTelefonicos = $cliente->getTelefonoCliente($id);

        if ($numerosTelefonicos->count() > 0) {
            $response = array(
                'status' => 200,
                'message' => 'Numeros encontrados',
                'data' => $numerosTelefonicos
            );
        } else {
            $response = array(
                'status' => 404,
                'message' => 'Numeros no encontrados'
            );
        }

        return response()->json($response, $response['status']);
    }
    
    public function getDirByClient($id)
    {
        $cliente = new Cliente();
        $direcciones = $cliente->getDireccionCliente($id);

        if ($direcciones->count() > 0) {
            $response = array(
                'status' => 200,
                'message' => 'Direcciones encontradas',
                'data' => $direcciones
            );
        } else {
            $response = array(
                'status' => 404,
                'message' => 'Direcciones no encontradas'
            );
        }

        return response()->json($response, $response['status']);
    }

}
