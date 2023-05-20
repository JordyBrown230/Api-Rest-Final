<?php

namespace App\Http\Controllers;
use App\Models\DetalleOrden;
use Illuminate\Http\Request;

class DetalleOrdenController extends Controller
{
    public function __construct()
    {
        
    }

    public function __invoke(){

    }
    
    public function index(){
        $data=DetalleOrden::all();
        $response=array(
            'status'=>200,
            'message'=>'Consulta completada satisfactoriamente',
            'data'=>$data
        );
        return response()->json($response,200);
    }

       public function show($id)
    {
        $detalleOrden = DetalleOrden::find($id);
        if($detalleOrden) {
            $response = array(
                'status' => 200,
                'message' => 'Detalle orden encontrado',
                'data' => $detalleOrden
            );
        } else {
            $response = array(
                'status' => 404,
                'message' => 'Detalle orden no encontrado'
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
            'cantidad' => 'required|numeric',
            'precioUnitario' => 'required|numeric',
            'ivaUnitario'=> 'required|numeric',
            'orden' => 'required|exists:orden,idOrden',
        ];

        $validate = \validator($data, $rules);

        if (!($validate->fails())) {
            $detalleOrden = new DetalleOrden();
            $detalleOrden->cantidad = $data['cantidad'];
            $detalleOrden->precioUnitario = $data['precioUnitario'];
            $detalleOrden->ivaUnitario = $data['ivaUnitario'];
            $detalleOrden->orden = $data['orden'];
            $detalleOrden->save();

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
                'cantidad' => 'required|numeric',
                'precioUnitario' => 'required|numeric',
                'ivaUnitario'=> 'required|numeric',
                'orden' => 'required|exists:orden,idOrden',
            ];
    
            $validate = \validator($data, $rules);
    
            if (!($validate->fails())) {
                    $detalleOrden = DetalleOrden::find($id);
                if ($detalleOrden) {
                    $detalleOrden->cantidad = $data['cantidad'];
                    $detalleOrden->precioUnitario = $data['precioUnitario'];
                    $detalleOrden->ivaUnitario = $data['ivaUnitario'];
                    $detalleOrden->orden = $data['orden'];

                    $detalleOrden->save();

                    $response = [
                        'status' => 200,
                        'message' => 'Datos actualizados correctamente',
                    ];
                } else {
                    $response = [
                        'status' => 404,
                        'message' => 'El detalleOrden no existe',
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
        $detalleOrden = DetalleOrden::find($id);
        if ($detalleOrden) {
            $detalleOrden->delete();
            $response = array(
                'status' => 200,
                'message' => 'DetalleOrden eliminado correctamente'
            );
        } else {
            $response = array(
                'status' => 404,
                'message' => 'DetalleOrden no encontrado'
            );
        }
        return response()->json($response, $response['status']);
    }
}
