<?php

namespace App\Http\Controllers;

use App\Models\Puesto;
use Illuminate\Http\Request;

class PuestoController extends Controller
{
    //
    public function __construct()
    {
        
    }

    public function __invoke(){

    }

    public function index(){
        $data=Puesto::all();
        $response=array(
            'status'=>200,
            'message'=>'Consulta completada satisfactoriamente',
            'data'=>$data
        );
        return response()->json($response,200);
    }

       public function show($id)
    {
        $puesto = Puesto::find($id);
        if($puesto) {
            $response = array(
                'status' => 200,
                'message' => 'Empleado encontrado',
                'data' => $puesto
            );
        } else {
            $response = array(
                'status' => 404,
                'message' => 'Empleado no encontrado'
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
                'nombre' => 'required|alpha',
                'salario' => 'required|numeric',
            ];
    
            $validate = \validator($data, $rules);
    
            if (!$validate->fails()) {
                $puesto = new Puesto();
                $puesto->nombre = $data['nombre'];
                $puesto->salario = $data['salario'];
                $puesto->save();
    
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
                'nombre' => 'required|alpha',
                'salario' => 'required|numeric',
            ];
            $validate = \validator($data, $rules);
            if (!$validate->fails()) {
                $puesto = Puesto::find($id);
                if ($puesto) {
                    $puesto->nombre = $data['nombre'];
                    $puesto->salario = $data['salario'];
                    $puesto->save();
                    $response = array(
                        'status' => 200,
                        'message' => 'Datos actualizados correctamente'
                    );
                } else {
                    $response = array(
                        'status' => 404,
                        'message' => 'Puesto no encontrado'
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
    
    
    public function delete($id){
        $empleado = Puesto::find($id);
        if ($empleado) {
            $empleado->delete();
            $response = array(
                'status' => 200,
                'message' => 'Empleado eliminado correctamente'
            );
        } else {
            $response = array(
                'status' => 404,
                'message' => 'Empleado no encontrado'
            );
        }
        return response()->json($response, $response['status']);
    }
}
