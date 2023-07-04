<?php

namespace App\Http\Controllers;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class ProductoController extends Controller
{
    public function __construct()
    {
    $this->middleware('api.auth',['except'=>['index','show','getImage','store','update','destroy']]);
    }

    public function __invoke(){

    }
    
    public function index(){
        $data = Producto::with('categoria','proveedor')->get();
        $response =array(
            'status'=>200,
            'message'=>"Consulta generada exitosamente!",
            "data"=>$data
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

    $data = json_decode($data_input, true);

    if (!empty($data)) {
        $data = array_map('trim', $data);

        $rules = [
            'nombre' => 'required|unique:producto,nombre',
            'stock'=> 'required',
            'image' => 'required',
            'proveedor' => 'required',
            'categoria'  => 'required',
            'precioUnitario' => 'required',
        ];

        $validate = \validator($data, $rules);

        if (!($validate->fails())) {
            // ...
        $producto = new Producto();
        $producto->nombre = $data['nombre'];
        $producto->stock = $data['stock'];
        $producto->image = $data['image'];
        $producto->proveedor = $data['proveedor'];
        $producto->categoria = $data['categoria'];
        $producto->precioUnitario = $data['precioUnitario'];

        $producto->save();

            $response = [
                'status' => 200,
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
                'nombre' => 'required|unique:producto,nombre,'.$id.',idProducto',
                'stock'=> 'required',
                'image' => 'required',
                'proveedor' => 'required',
                'categoria'  => 'required',
                'precioUnitario' => 'required',
            ];
    
            $validate = \validator($data, $rules);
    
            if (!($validate->fails())) {
                    $producto = Producto::find($id);
                if ($producto) {
                    $producto->nombre = $data['nombre'];
                    $producto->stock = $data['stock'];
                    $producto->image = $data['image'];
                    $producto->proveedor = $data['proveedor'];
                    $producto->categoria = $data['categoria'];
                    $producto->precioUnitario = $data['precioUnitario'];
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

    public function uploadImage(Request $request){        
        $valid=Validator::make($request->all(),['file0'=>'required|image|mimes:jpg,png']);
        if(!$valid->fails()){
            $image=$request->file('file0');
            $filename=time().$image->getClientOriginalName();
            Storage::disk('products')->put($filename,File::get($image));
            $response=array(
                'status'=>200,
                'message'=>'Imagen guardada exitosamente',
                'image_name'=>$filename
            );

        }else{
            $response=array(
                'status'=>406,
                'message'=>'Error al subir el archivo',
                'errors'=>$valid->errors(),
            );
        }
        return response()->json($response,$response['status']);
    }
    public function getImage($filename){
        if(isset($filename)){
            $exist=Storage::disk('products')->exists($filename);
            if($exist){
                $file=Storage::disk('products')->get($filename);
                return new Response($file,200);
            }else{
                $response=array(
                    'status'=>404,
                    'message'=>'Imagen no encontrada',
                );
            }
        }else{
            $response=array(
                'status'=>404,
                'message'=>'No se definió correctamente el nombre de la imagen',
            );
        }
        return response()->json($response,404);
    }
}
