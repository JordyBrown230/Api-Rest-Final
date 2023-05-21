<?php

namespace App\Http\Controllers;
use App\Models\Envio;
use Illuminate\Http\Request;

class EnvioController extends Controller
{
    public function __construct()
    {
        
    }

    public function __invoke(){

    }
    
    public function index(){
        $data=Envio::all();
        $response=array(
            'status'=>200,
            'message'=>'Consulta completada satisfactoriamente',
            'data'=>$data
        );
        return response()->json($response,200);
    }

       public function show($id)
    {
        $envio = Envio::find($id);
        if($envio) {
            $response = array(
                'status' => 200,
                'message' => 'envio encontrado',
                'data' => $envio
            );
        } else {
            $response = array(
                'status' => 404,
                'message' => 'envio no encontrado'
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
            'chofer'  => 'required|exists:empleado,idEmpleado',
            'vehiculo'  => 'required|exists:vehiculo,numUnidad'
        ];

        $validate = \validator($data, $rules);

        if (!($validate->fails())) {
            $envio = new Envio();
            $envio->direccion = $data['direccion'];
            $envio->chofer = $data['chofer'];
            $envio->vehiculo= $data['vehiculo'];
            $envio->save();

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
            'chofer'  => 'required|exists:empleado,idEmpleado',
            'vehiculo'  => 'required|exists:vehiculo,numUnidad'
            ];
    
            $validate = \validator($data, $rules);
    
            if (!($validate->fails())) {
                $envio = Envio::find($id);
                if ($envio) {
                    $envio->direccion = $data['direccion'];
                    $envio->chofer = $data['chofer'];
                    $envio->vehiculo= $data['vehiculo'];
                    $envio->save();

                    $response = [
                        'status' => 200,
                        'message' => 'Datos actualizados correctamente',
                    ];
                } else {
                    $response = [
                        'status' => 404,
                        'message' => 'El envio no existe',
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
        $envio = Envio::find($id);
        if ($envio) {
            $envio->delete();
            $response = array(
                'status' => 200,
                'message' => 'Envio eliminado correctamente'
            );
        } else {
            $response = array(
                'status' => 404,
                'message' => 'envio no encontrado'
            );
        }
        return response()->json($response, $response['status']);
    }
}
