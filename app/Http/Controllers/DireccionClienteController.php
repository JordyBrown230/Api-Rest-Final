<?php

namespace App\Http\Controllers;
use App\Models\DireccionCliente;
use Illuminate\Http\Request;

class DireccionClienteController extends Controller
{
    public function __construct()
    {
        
    }

    public function __invoke(){

    }

    public function index(){
        $data=DireccionCliente::all();
        $response=array(
            'status'=>200,
            'message'=>'Consulta completada satisfactoriamente',
            'data'=>$data
        );
        return response()->json($response,200);
    }

       public function show($id)
    {
        $direccionCliente = DireccionCliente::find($id);
        if($direccionCliente) {
            $response = array(
                'status' => 200,
                'message' => 'Direccionencontrado',
                'data' => $direccionCliente
            );
        } else {
            $response = array(
                'status' => 404,
                'message' => 'Direccion no encontrado'
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
                'direccion' => 'required|regex:/^[a-zA-Z0-9\s.,]+$/u',
                'cliente' => 'required|exists:cliente,cedula',
            ];
    
            $validate = \validator($data, $rules);
    
            if (!($validate->fails())) {
                $direccionCliente = new DireccionCliente();
                $direccionCliente->direccion= $data['direccion'];
                $direccionCliente->cliente = $data['cliente'];
                $direccionCliente->save();
    
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
                'direccion' => 'required|regex:/^[a-zA-Z0-9\s.,]+$/u',
                'cliente' => 'required|exists:cliente,cedula',
            ];
            $validate = \validator($data, $rules);
            if (!($validate->fails())) {
                $direccionCliente = DireccionCliente::find($id);
                if ($direccionCliente) {
                    $direccionCliente->direccion= $data['direccion'];
                    $direccionCliente->cliente = $data['cliente'];
                    $direccionCliente->save();

                    $response = array(
                        'status' => 200,
                        'message' => 'Datos actualizados correctamente'
                    );
                } else {
                    $response = array(
                        'status' => 404,
                        'message' => 'Direccion no encontrada'
                    );
                }
            } else {
                $response = array(
                    'status' => 406,
                    'message' => 'Error de validación, datos incorrectos',
                    'errors' => $validate->errors()
                );
            }
        } else {
            $response = array(
                'status' => 400,
                'message' => 'Faltan parametros'
            );
        }
        return response()->json($response, $response['status']);
    }
    
    
    public function destroy($id){
        $direccionCliente = DireccionCliente::find($id);
        if ($direccionCliente) {
            $direccionCliente->delete();
            $response = array(
                'status' => 200,
                'message' => 'Direccion eliminado correctamente'
            );
        } else {
            $response = array(
                'status' => 404,
                'message' => 'Direccion no encontrada'
            );
        }
        return response()->json($response, $response['status']);
    }
}
