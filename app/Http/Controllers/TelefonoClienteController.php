<?php

namespace App\Http\Controllers;
use App\Models\TelefonoCliente;
use Illuminate\Http\Request;

class TelefonoClienteController extends Controller
{
    public function __construct()
    {
        
    }

    public function __invoke(){

    }

    public function index(){
        $data=TelefonoCliente::all();
        $response=array(
            'status'=>200,
            'message'=>'Consulta completada satisfactoriamente',
            'data'=>$data
        );
        return response()->json($response,200);
    }

       public function show($id)
    {
        $telefonoCliente = TelefonoCliente::find($id);
        if($telefonoCliente) {
            $response = array(
                'status' => 200,
                'message' => 'Telefono encontrado',
                'data' => $telefonoCliente
            );
        } else {
            $response = array(
                'status' => 404,
                'message' => 'Telefono no encontrado'
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
                'numTelefono' => 'required|alpha_numeric',
                'cliente' => 'required|exists:cliente,cedula',
            ];
    
            $validate = \validator($data, $rules);
    
            if (!$validate->fails()) {
                $telefonoCliente = new TelefonoCliente();
                $telefonoCliente->numTelefono= $data['numTelefono'];
                $telefonoCliente->cliente = $data['cliente'];
                $telefonoCliente->save();
    
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
                'numTelefono' => 'required|alpha_numeric',
                'cliente' => 'required|exists:cliente,cedula',
            ];
            $validate = \validator($data, $rules);
            if (!$validate->fails()) {
                $telefonoCliente = TelefonoCliente::find($id);
                if ($telefonoCliente) {
                    $telefonoCliente->numTelefono= $data['numTelefono'];
                    $telefonoCliente->cliente = $data['cliente'];
                    $telefonoCliente->save();

                    $response = array(
                        'status' => 200,
                        'message' => 'Datos actualizados correctamente'
                    );
                } else {
                    $response = array(
                        'status' => 404,
                        'message' => 'telefonoCliente no encontrado'
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
        $Telefono = TelefonoCliente::find($id);
        if ($Telefono) {
            $Telefono->delete();
            $response = array(
                'status' => 200,
                'message' => 'Telefono eliminado correctamente'
            );
        } else {
            $response = array(
                'status' => 404,
                'message' => 'Telefono no encontrado'
            );
        }
        return response()->json($response, $response['status']);
    }
}
