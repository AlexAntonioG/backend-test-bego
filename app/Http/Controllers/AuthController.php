<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;
use MongoDB\Driver\Exception\BulkWriteException;
use Exception;
use Log;

class AuthController extends Controller
{
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function register(Request $request)
    {
        try{

            $data = $request->only(['name', 'email', 'password']);
            $response = $this->userService->register($data);

            return response()->json($response, 201);


        } catch (BulkWriteException $e){

            return response()->json(['Error' => 'Email ya registrado'], 400);

        } catch (Exception $e){

            Log::error('Error creando usuario: ' . $e->getMessage());
            return response()->json(['Error creando usuario'], 500);

        }
    }

    public function login(Request $request)
    {
        try {

            $credentialsData = $request->only(['email', 'password']);
            $token = $this->userService->login($credentialsData);

            if(!$token){
                return response()->json(['Error' => 'Credenciales invalidas'], 401);
            }

            return response()->json(compact('token'));

        } catch (Exception $e){

            Log::error('Error al iniciar sesión: ' . $e->getMessage());
            return response()->json(['Error al iniciar sesión'], 500);

        }

    }
}

