<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    //
    public function __construct(){

    }

    public function __invoke(){

    }

    public function index(){
        $data=Categoria::all();
        $response=array(
            'status'=>200,
            'message'=>'Consulta completada satisfactoriamente',
            'data'=>$data
        );
        return response()->json($response,200);
    }

    public function show($id){
        $categoria = Categoria::find($id);
        if($categoria){
            $response = array(
                'status' =>200,
                'message'=> 'Categoria encontrada',
                'data' =>$categoria
            );
        }else{
            $response =array(
                'status' => 404,
                'message' =>'Categoria no registrada'
            );
        }
        return response()->json($response,$response['status']);
    }
    public function store(Request $request){
        $data_input = $request->input('data', null);

        if (is_array($data_input)) {
            $data = $data_input;
        } else {
            $data = json_decode($data_input, true);
        }
        if(!empty($data)){
            $data = array_map('trim', $data);

            $rules =[
                'nombre'  => 'required|regex:/^[a-zA-Z0-9\s.,]+$/u|unique:categoria,nombre',
                'descripcion' =>'required|regex:/^[a-zA-Z0-9\s.,]+$/u'
            ];
            $validate =\validator($data,$rules);
            if(!($validate->fails())){
                $categoria = new Categoria();
                $categoria->nombre = $data['nombre'];
                $categoria->descripcion = $data['descripcion'];
                $categoria->save();
                $response = [
                    'status' => 201,
                    'message' => 'Datos guardados correctamente',
                ];
            }else{
                $response = [
                    'status' => 406,
                    'message' => 'Error de validación, datos incorrectos',
                    'errors' => $validate->errors(),
                ];
            }
            
        }else {
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
                'nombre' => 'required|regex:/^[a-zA-Z0-9\s.,]+$/u|unique:categoria,nombre,'.$id.',idCategoria',
                'descripcion' => 'required|regex:/^[a-zA-Z0-9\s.,]+$/u'
            ];
            $validate = \validator($data, $rules);
            
            if (!($validate->fails())) {
                $categoria = Categoria::find($id);
                if ($categoria) {
                    $categoria->nombre = $data['nombre'];
                    $categoria->descripcion = $data['descripcion'];
                    $categoria->save();

                    $response = [
                        'status' => 200,
                        'message' => 'Datos actualizados correctamente',
                    ];
                } else {
                    $response = [
                        'status' => 404,
                        'message' => 'La categoria no existe',
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
        $categoria = Categoria::find($id);
        if ($categoria) {
            $categoria->delete();
            $response = array(
                'status' => 200,
                'message' => 'Categoria eliminada correctamente'
            );
        } else {
            $response = array(
                'status' => 404,
                'message' => 'Categoria no encontrada'
            );
        }
        return response()->json($response, $response['status']);
    }
}
