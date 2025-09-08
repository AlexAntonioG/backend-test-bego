<?php

namespace App\Http\Controllers;

use App\Interfaces\LocationServiceInterface;
use Illuminate\Http\Request;
use Exception;
use Log;

class LocationController extends Controller
{
    private $locationService;

    public function __construct(LocationServiceInterface $locationService)
    {
        $this->locationService = $locationService;
    }

    public function index()
    {
        try {

            return response()->json($this->locationService->getAll(), 200);

        } catch (Exception $e) {

            Log::error('Error al obtener locations: ' . $e->getMessage());
            return response()->json(['Error al obtener locations'], 500);

        }
    }

    public function store(Request $request)
    {
        try {

            $data = $request->only(['address','place_id','latitude','longitude']);
            $location = $this->locationService->create($data);
            return response()->json($location, 201);

        } catch (Exception $e) {

            Log::error('Error creando location: ' . $e->getMessage());
            return response()->json(['Error creando location: ' . $e->getMessage()], 500);

        }
    }

    public function show(string $id)
    {
        try {

            $location = $this->locationService->find($id);

            if (!$location) {
                return response()->json(['Error' => 'Location no encontrada'], 404);
            }

            return response()->json($location, 200);

        } catch (Exception $e) {

            Log::error('Error buscando location: ' . $e->getMessage());
            return response()->json(['Error buscando location'], 500);

        }
    }

    public function update(Request $request, string $id)
    {
        try {

            $data = $request->only(['address','place_id','latitude','longitude']);
            $location = $this->locationService->update($id, $data);

            if (!$location) {
                return response()->json(['Error' => 'Location no encontrada'], 404);
            }

            return response()->json($location);

        } catch (Exception $e) {

            Log::error('Error actualizando location: ' . $e->getMessage());
            return response()->json(['Error actualizando location'], 500);

        }
    }

    public function destroy(string $id)
    {
        try {

            if ($this->locationService->delete($id)) {
                return response()->json(['message' => 'Location eliminada']);
            }

            return response()->json(['Error' => 'Location no encontrada'], 404);

        } catch (Exception $e) {

            Log::error('Error eliminando location: ' . $e->getMessage());
            return response()->json(['Error eliminando location'], 500);

        }
    }
}
