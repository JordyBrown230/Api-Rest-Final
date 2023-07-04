<?php

namespace App\Http\Controllers;
use App\Models\Orden;
use Illuminate\Http\Request;
use App\Models\Envio;
use App\Models\DetalleOrden;

class OrdenController extends Controller
{
    public function __construct()
    {
        
    }

    public function __invoke(){

    }
    
    public function index(){
        //$data=Orden::all();
        $data = Orden::with('detalleOrden')->get();
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
            'tipoRetiro' => 'required|regex:/^[a-zA-Z\s]+$/u',
            //'fechaOrden' => 'required|date',
            'total'=> 'required|numeric',
            'ivaTotal' => 'required|numeric',
            'cliente'  => 'required|exists:cliente,cedula',
            'empleado'  => 'nullable|exists:empleado,idEmpleado',
            'envio'  => 'nullable|exists:envio,idEnvio',
        ];

        $validate = \validator($data, $rules);

        if (!($validate->fails())) {
            $orden = new Orden();
            $orden->tipoRetiro = $data['tipoRetiro'];
            $orden->fechaOrden = now();
            $orden->total = $data['total'];
            $orden->ivaTotal = $data['ivaTotal'];
            $orden->cliente = $data['cliente'];
            $orden->empleado= empty($data['empleado']) ? null : $data['empleado'];
            $orden->envio = empty($data['envio']) ? null : $data['envio'];
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
                'tipoRetiro' => 'required|regex:/^[a-zA-Z\s]+$/u',
                'fechaOrden' => 'required|date',
                'total'=> 'required|numeric',
                'ivaTotal' => 'required|numeric',
                'cliente'  => 'required|exists:cliente,cedula',
                'empleado'  => 'required|exists:empleado,idEmpleado',
                'envio'  => 'nullable|exists:envio,idEnvio',
            ];
    
            $validate = \validator($data, $rules);
    
            if (!($validate->fails())) {
                    $orden = Orden::find($id);
                if ($orden) {
                    $orden->tipoRetiro = $data['tipoRetiro'];
                    $orden->fechaOrden = $data['fechaOrden'];
                    $orden->total = $data['total'];
                    $orden->ivaTotal = $data['ivaTotal'];
                    $orden->cliente = $data['cliente'];
                    $orden->empleado= $data['empleado'];
                    $orden->envio = empty($data['envio']) ? null : $data['envio'];
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

    public function getByClient($cliente_id){

        $orden = Orden::porCliente($cliente_id)->get();

        if($orden->count() > 0) {
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

    public function generarOrden(Request $request){

        $tipoRetiro = $request->input('tipoRetiro');
        $direccionEnvio = $request->input('direccionEnvio');
        $total = $request->input('total');
        $ivaTotal = $request->input('ivaTotal');
        $cliente = $request->input('cliente');
        $detallesOrden = $request->input('detalles');

        $envio = new Envio();
        $envio->direccion = $direccionEnvio;
        // Crear una nueva orden
        $orden = new Orden();
        $orden->tipoRetiro = $tipoRetiro;
        $orden->fechaOrden = now();
        $orden->total = $total;
        $orden->ivaTotal = $ivaTotal;
        $orden->cliente = $cliente;

        if ($tipoRetiro === 'Envio') {
            $envio->save(); // en caso que sea envio se debe generar ese envio
            $orden->envio = $envio->idEnvio; // Asociar el envío a la orden
        }

        // Guardar la orden
        $orden->save();
        foreach ($detallesOrden as $detalle) {
            $detalleOrden = new DetalleOrden();
            $detalleOrden->orden = $orden->idOrden;
            $detalleOrden->cantidad = $detalle['cantidad'];
            $detalleOrden->precioUnitario = $detalle['precioUnitario'];
            $detalleOrden->ivaUnitario = $detalle['ivaUnitario'];
            $detalleOrden->producto = $detalle['producto'];
            $detalleOrden->save();
        }

        return response()->json([
            'status' => 200,
            'message' => 'Orden generada exitosamente',
            'orden' => $orden,
            'envio' => $envio,
            'detalles' => $detallesOrden
        ]);
    }

}
