<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Worker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class WorkersController extends Controller{
    public function __construct(Worker $worker){
        $this->worker = $worker;
    }

    /* Listar a los trabajadores */
    public function index(){
        //
    }

    /* Guardar un trabajador */
    public function store(Request $request){
        // Tomar los datos recibidos
        $json = $request->input('json', null);
        $params_array = json_decode($json, true);

        // Limpiar los datos
        $params_array = array_map('trim', $params_array);

        // Verificar que no estén vacíos los parametros
        if(!empty($params_array)){
            // Validar los datos
            $validate = Validator::make($params_array, [
                'name' => 'required',
                'user' => 'required|unique:workers',
                'password' => 'required',
                'role' => 'required'
            ]);

            if($validate->fails()){
                $data = array(
                    'status' => 'Error',
                    'code' => 400,
                    'message' => 'El usuario NO se ha creado',
                    'errors' => $validate->errors()
                );

            }else{
                // Cifrar la contraseña
                $pass = password_hash($params_array['password'], PASSWORD_BCRYPT, ['cost' => 4]);

                // Guardar el usuario en la BD
                $worker = new Worker();
                $worker->name = $params_array['name'];
                $worker->user = $params_array['user'];
                $worker->password = $pass;
                $worker->role = $params_array['role'];
                $worker->save();

                $data = array(
                    'status' => 'Succes',
                    'code' => 200,
                    'message' => 'El usuario se ha creado correctamente',
                    'worker' => $worker
                );
            }
        }else{
            $data = array(
                'status' => 'Error',
                'code' => 400,
                'message' => 'Los datos enviados no son correctos'
            );
        }

        return response()->json($data, $data['code']);
    }

    /* Mostrar un trabajador */
    public function show(Worker $worker){
        //
    }

    /* Actualizar un trabajador */
    public function update(Request $request, Worker $worker){
        //
    }

    /* Eliminar un trabajador */
    public function destroy(Worker $worker){
        //
    }
}
