<?php

namespace App\Http\Controllers;
use App\Models\Orden;
use Illuminate\Http\Request;

class OrdenController extends Controller
{
    public function __construct()
    {
        
    }

    public function __invoke(){

    }
    
    public function index(){
        $data=Orden::all();
        $response=array(
            'status'=>200,
            'message'=>'Consulta completada satisfactoriamente',
            'data'=>$data
        );
        return response()->json($response,200);
    }

       public function show($id)
    {
        $orden = Orden::find($id);
        if($orden) {
            $response = array(
                'status' => 200,
                'message' => 'Orden encontrado',
                'data' => $orden
            );
        } else {
            $response = array(
                'status' => 404,
                'message' => 'Orden no encontrado'
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
            'idOrden' => 'required|numeric',
            'tipoRetiro' => 'required|alpha',
            'fechaOrden' => 'required|date',
            'total'=> 'required|numeric',
            'ivaTotal' => 'required|numeric',
            'envio' => 'required|exists:envio,idEnvio',
            'cliente'  => 'required|exists:cliente,cedula',
            'empleado'  => 'required|exists:empleado,idEmpleado',
        ];

        $validate = \validator($data, $rules);

        if (!$validate->fails()) {
            $orden = new Orden();
            $orden->idOrden = $data['idOrden'];
            $orden->tipoRetiro = $data['tipoRetiro'];
            $orden->fechaOrden = $data['fechaOrden'];
            $orden->total = $data['total'];
            $orden->ivaTotal = $data['ivaTotal'];
            $orden->envio = $data['envio'];
            $orden->cliente = $data['cliente'];
            $orden->empleado= $data['empleado'];
            $orden->save();

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
                'idOrden' => 'required|numeric',
                'tipoRetiro' => 'required|alpha',
                'fechaOrden' => 'required|date',
                'total'=> 'required|numeric',
                'ivaTotal' => 'required|numeric',
                'envio' => 'required|exists:envio,idEnvio',
                'cliente'  => 'required|exists:cliente,cedula',
                'empleado'  => 'required|exists:empleado,idEmpleado',
            ];
    
            $validate = \validator($data, $rules);
    
            if (!$validate->fails()) {
                    $orden = Orden::find($data['idOrden']);
                if ($orden) {
                    $orden->idOrden = $data['idOrden'];
                    $orden->tipoRetiro = $data['tipoRetiro'];
                    $orden->fechaOrden = $data['fechaOrden'];
                    $orden->total = $data['total'];
                    $orden->ivaTotal = $data['ivaTotal'];
                    $orden->envio = $data['envio'];
                    $orden->cliente = $data['cliente'];
                    $orden->empleado= $data['empleado'];
                    $orden->save();

                    $response = [
                        'status' => 200,
                        'message' => 'Datos actualizados correctamente',
                    ];
                } else {
                    $response = [
                        'status' => 404,
                        'message' => 'El orden no existe',
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
        $orden = Orden::find($id);
        if ($orden) {
            $orden->delete();
            $response = array(
                'status' => 200,
                'message' => 'Orden eliminado correctamente'
            );
        } else {
            $response = array(
                'status' => 404,
                'message' => 'Orden no encontrado'
            );
        }
        return response()->json($response, $response['status']);
    }
}
