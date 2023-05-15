<?php

namespace App\Http\Controllers;
use App\Models\Empleado;
use Illuminate\Http\Request;


class EmpleadoController extends Controller
{
    //
    public function __construct()
    {
        
    }

    public function __invoke(){

    }

    public function index(){
        $data=Empleado::all();
        $response=array(
            'status'=>200,
            'message'=>'Consulta completada satisfactoriamente',
            'data'=>$data
        );
        return response()->json($response,200);
    }

       public function show($id)
    {
        $empleado = Empleado::find($id);
        if($empleado) {
            $response = array(
                'status' => 200,
                'message' => 'Empleado encontrado',
                'data' => $empleado
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
            'cedula' => 'required|alpha_num',
            'nombre' => 'required|regex:/^[a-zA-Z\s]+$/u',
            'fechaNac' => 'required|date',
            'fechaIngreso' => 'required|date',
            'email' => 'required|email|unique:empleado,email',
            'puesto' => 'required|exists:puesto,idPuesto',
        ];

        $validate = \validator($data, $rules);

        if (!($validate->fails())) {
            $empleado = new Empleado();
            $empleado->cedula = $data['cedula'];
            $empleado->nombre = $data['nombre'];
            $empleado->fechaNac = $data['fechaNac'];
            $empleado->fechaIngreso = $data['fechaIngreso'];
            $empleado->email = $data['email'];
            $empleado->puesto = $data['puesto'];
            $empleado->save();

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
                'idEmpleado' => 'required|numeric|exists:empleado,idEmpleado',
                'cedula' => 'required|alpha_num',
                'nombre' => 'required|regex:/^[a-zA-Z\s]+$/u',
                'fechaNac' => 'required|date',
                'fechaIngreso' => 'required|date',
                'email' => 'required|email',
                'puesto' => 'required|exists:puesto,idPuesto',
            ];
    
            $validate = \validator($data, $rules);
    
            if (!($validate->fails())) {
                    $empleado = Empleado::find($data['idEmpleado']);
                if ($empleado) {
                    $empleado->idEmpleado = $data['idEmpleado'];
                    $empleado->cedula = $data['cedula'];
                    $empleado->nombre = $data['nombre'];
                    $empleado->fechaNac = $data['fechaNac'];
                    $empleado->fechaIngreso = $data['fechaIngreso'];
                    $empleado->email = $data['email'];
                    $empleado->puesto = $data['puesto'];
                    $empleado->save();
    
                    $response = [
                        'status' => 200,
                        'message' => 'Datos actualizados correctamente',
                    ];
                } else {
                    $response = [
                        'status' => 404,
                        'message' => 'El empleado no existe',
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
        $empleado = Empleado::find($id);
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
