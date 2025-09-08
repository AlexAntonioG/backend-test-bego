<?php

namespace App\Http\Controllers;

use App\Interfaces\UserServiceInterface;
use Illuminate\Http\Request;
use Exception;
use Log;

class UserController extends Controller
{
    private $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        try{

            return response()->json($this->userService->getAll(), 200);

        } catch (Exception $e){

            Log::error("Error al obtener usuarios: " . $e->getMessage());
            return response()->json(['Error al obtener usuarios'], 500);

        }
    }

    public function store(Request $request)
    {
        try {

            $data = $request->only(['name','email','password']);
            $user = $this->userService->create($data);
            return response()->json($user, 201);

        } catch (Exception $e) {

            Log::error('Error creando usuario: ' . $e->getMessage());
            return response()->json(['No se pudo crear el usuario'], 500);

        }
    }

    public function show(string $id)
    {
        try{

            $user = $this->userService->find($id);

            if(!$user){
                return response()->json(['Error' => 'Usuario no encontrado'], 404);
            }

            return response()->json($user, 200);

        } catch(Exception $e){

            Log::error('Error buscando usuario: ' . $e->getMessage());
            return response()->json(['Error buscando usuario'], 500);

        }
    }

    public function update(Request $request, string $id)
    {
        try {

            $data = $request->only(['name','email','password']);
            $user = $this->userService->update($id, $data);

            if (!$user) {
                return response()->json(['Error' => 'Usuario no encontrado'], 404);
            }

            return response()->json($user);

        } catch(Exception $e){

            Log::error('Error actualizando usuario: ' . $e->getMessage());
            return response()->json(['Error actualizando usuario'], 500);

        }
    }

    public function destroy(string $id)
    {
        try{

            if ($this->userService->delete($id)) {
                return response()->json(['message' => 'Usuario eliminado']);
            }

            return response()->json(['error' => 'Usuario no encontrado'], 404);

        } catch(Exception $e){

            Log::error('Error eliminando usuario: ' . $e->getMessage());
            return response()->json(['Error eliminando usuario'], 500);

        }
    }
}
