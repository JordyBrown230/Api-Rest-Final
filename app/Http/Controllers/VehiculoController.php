<?php

namespace App\Http\Controllers;
use App\Models\Vehiculo;
use Illuminate\Http\Request;

class VehiculoController extends Controller
{
    public function __construct()
    {
        
    }

    public function __invoke(){

    }

    public function index(){
        $data=Vehiculo::all();
        $response=array(
            'status'=>200,
            'message'=>'Consulta completada satisfactoriamente',
            'data'=>$data
        );
        return response()->json($response,200);
    }

       public function show($id)
    {
        $vehiculo = Vehiculo::find($id);
        if($vehiculo) {
            $response = array(
                'status' => 200,
                'message' => 'Vehiculo encontrado',
                'data' => $vehiculo
            );
        } else {
            $response = array(
                'status' => 404,
                'message' => 'Vehiculo no encontrado'
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
            'numUnidad' => 'required|numerIc',
            'placa' => 'required|alpha_num',
            'color' => 'required|alpha_num',
            'tipo' => 'required|alpha_num',
            'modelo' => 'required|alpha_num',
            
        ];

        $validate = \validator($data, $rules);

        if (!$validate->fails()) {
            $vehiculo = new Vehiculo();
            $vehiculo->numUnidad = $data['numUnidad'];
            $vehiculo->placa = $data['placa'];
            $vehiculo->color = $data['color'];
            $vehiculo->tipo = $data['tipo'];
            $vehiculo->modelo = $data['modelo'];
            $vehiculo->save();

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

    public function update(Request $request){
        $data_input = $request->input('data', null);

        if (is_array($data_input)) {
            $data = $data_input;
        } else {
            $data = json_decode($data_input, true);
        }
    
        if (!empty($data)) {
            $data = array_map('trim', $data);
    
            $rules = [
                'numUnidad' => 'required|numeric',
                'placa' => 'required|alpha_num',
                'color' => 'required|alpha_num',
                'tipo' => 'required|alpha_num',
                'modelo' => 'required|alpha_num',
            ];
    
            $validate = \validator($data, $rules);
    
            if (!$validate->fails()) {
                    $vehiculo = Vehiculo::find($data['idvehiculo']);
                if ($vehiculo) {
                    $vehiculo->numUnidad = $data['numUnidad'];
                    $vehiculo->placa = $data['placa'];
                    $vehiculo->color = $data['color'];
                    $vehiculo->tipo = $data['tipo'];
                    $vehiculo->modelo = $data['modelo'];
                    $vehiculo->save();
    
                    $response = [
                        'status' => 200,
                        'message' => 'Datos actualizados correctamente',
                    ];
                } else {
                    $response = [
                        'status' => 404,
                        'message' => 'El vehiculo no existe',
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
        $vehiculo = Vehiculo::find($id);
        if ($vehiculo) {
            $vehiculo->delete();
            $response = array(
                'status' => 200,
                'message' => 'Vehiculo eliminado correctamente'
            );
        } else {
            $response = array(
                'status' => 404,
                'message' => 'Vehiculo no encontrado'
            );
        }
        return response()->json($response, $response['status']);
    }
}
