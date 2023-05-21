<?php

namespace App\Http\Controllers;
use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function __construct()
    {
        
    }

    public function __invoke(){

    }
    
    public function index(){
        $data=Producto::all();
        $response=array(
            'status'=>200,
            'message'=>'Consulta completada satisfactoriamente',
            'data'=>$data
        );
        return response()->json($response,200);
    }

       public function show($id)
    {
        $producto = Producto::find($id);
        if($producto) {
            $response = array(
                'status' => 200,
                'message' => 'Producto encontrado',
                'data' => $producto
            );
        } else {
            $response = array(
                'status' => 404,
                'message' => 'Producto no encontrado'
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
            'nombre' => 'required|regex:/^[a-zA-Z\s]+$/u|unique:producto,nombre',
            'stock'=> 'required|numeric',
            'foto' => 'nullable|image',
            'proveedor' => 'required|exists:proveedor,idProveedor',
            'categoria'  => 'required|exists:categoria,idCategoria',
            'detalleOrden'  => 'nullable|exists:detalleOrden,idDetalleOrden'
        ];

        $validate = \validator($data, $rules);

        if (!($validate->fails())) {
            // ...
        $producto = new Producto();
        $producto->nombre = $data['nombre'];
        $producto->stock = $data['stock'];
        $producto->foto = empty($data['foto']) ? null : $data['foto'];
        $producto->proveedor = $data['proveedor'];
        $producto->categoria = $data['categoria'];
        $producto->detalleOrden = empty($data['detalleOrden']) ? null : $data['detalleOrden'];
        $producto->save();

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
                'nombre' => 'required|regex:/^[a-zA-Z\s]+$/u|unique:producto,nombre,'.$id.',idProducto',
                'stock'=> 'required|numeric',
                'foto' => 'nullable|image',
                'proveedor' => 'required|exists:proveedor,idProveedor',
                'categoria'  => 'required|exists:categoria,idCategoria',
                'detalleOrden'  => 'nullable|exists:detalleOrden,idDetalleOrden',
            ];
    
            $validate = \validator($data, $rules);
    
            if (!($validate->fails())) {
                    $producto = Producto::find($id);
                if ($producto) {
                    $producto->nombre = $data['nombre'];
                    $producto->stock = $data['stock'];
                    $producto->foto = empty($data['foto']) ? null : $data['foto'];
                    $producto->proveedor = $data['proveedor'];
                    $producto->categoria = $data['categoria'];
                    $producto->detalleOrden = empty($data['detalleOrden']) ? null : $data['detalleOrden'];
                    $producto->save();

                    $response = [
                        'status' => 200,
                        'message' => 'Datos actualizados correctamente',
                    ];
                } else {
                    $response = [
                        'status' => 404,
                        'message' => 'El producto no existe',
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
        $producto = Producto::find($id);
        if ($producto) {
            $producto->delete();
            $response = array(
                'status' => 200,
                'message' => 'Producto eliminado correctamente'
            );
        } else {
            $response = array(
                'status' => 404,
                'message' => 'Producto no encontrado'
            );
        }
        return response()->json($response, $response['status']);
    }
}
