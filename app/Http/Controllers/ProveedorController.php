<?php

namespace App\Http\Controllers;
use App\Models\Proveedor;
use Illuminate\Http\Request;

class ProveedorController extends Controller
{
    public function __construct()
    {
        
    }

    public function __invoke(){

    }

    public function index(){
        $data=Proveedor::all();
        $response=array(
            'status'=>200,
            'message'=>'Consulta completada satisfactoriamente',
            'data'=>$data
        );
        return response()->json($response,200);
    }

       public function show($id)
    {
        $proveedor = Proveedor::find($id);
        if($proveedor) {
            $response = array(
                'status' => 200,
                'message' => 'Proveedor encontrado',
                'data' => $proveedor
            );
        } else {
            $response = array(
                'status' => 404,
                'message' => 'Proveedor no encontrado'
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
            'nombreCompania' => 'required|regex:/^[a-zA-Z0-9\s.,]+$/u|unique:proveedor,nombreCompania',
            'numTelefono' => 'required|regex:/^(?:\+?\d{1,3}\s?)?(?:\d{2,4}\s?)?\d{1,14}$/|unique:proveedor,numTelefono',
            'email' => 'required|email|unique:proveedor,email',    
        ];

        $validate = \validator($data, $rules);

        if (!($validate->fails())) {
            $proveedor = new Proveedor();
            $proveedor->nombreCompania = $data['nombreCompania'];
            $proveedor->numTelefono = $data['numTelefono'];
            $proveedor->email = $data['email'];
            $proveedor->save();

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
                'nombreCompania' => 'required|regex:/^[a-zA-Z0-9\s.,]+$/u|unique:proveedor,nombreCompania,'.$id.',idProveedor',
                'numTelefono' => 'required|regex:/^(?:\+?\d{1,3}\s?)?(?:\d{2,4}\s?)?\d{1,14}$/|unique:proveedor,numTelefono,'.$id.',idProveedor',
                'email' => 'required|email|unique:proveedor,email,'.$id.',idProveedor',
            ];
    
            $validate = \validator($data, $rules);
    
            if (!($validate->fails())) {
                    $proveedor = Proveedor::find($id);
                if ($proveedor) {
                    $proveedor->nombreCompania = $data['nombreCompania'];
                    $proveedor->numTelefono = $data['numTelefono'];
                    $proveedor->email = $data['email'];
                    $proveedor->save();
    
                    $response = [
                        'status' => 200,
                        'message' => 'Datos actualizados correctamente',
                    ];
                } else {
                    $response = [
                        'status' => 404,
                        'message' => 'El proveedor no existe',
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
        $proveedor = Proveedor::find($id);
        if ($proveedor) {
            $proveedor->delete();
            $response = array(
                'status' => 200,
                'message' => 'Proveedor eliminado correctamente'
            );
        } else {
            $response = array(
                'status' => 404,
                'message' => 'Proveedor no encontrado'
            );
        }
        return response()->json($response, $response['status']);
    }
}
