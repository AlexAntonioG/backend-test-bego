<?php

namespace App\Http\Controllers;

use App\Interfaces\TruckServiceInterface;
use Illuminate\Http\Request;
use Exception;
use Log;

class TruckController extends Controller
{
    private $truckService;

    public function __construct(TruckServiceInterface $truckService)
    {
        $this->truckService = $truckService;
    }

      public function index()
    {
        try {

            return response()->json($this->truckService->getAll(), 200);

        } catch (Exception $e) {

            Log::error("Error al obtener trucks: " . $e->getMessage());
            return response()->json(['Error al obtener trucks'], 500);

        }
    }

    public function store(Request $request)
    {
        try {

            $data = $request->only(['user','year','color','plates']);
            $truck = $this->truckService->create($data);
            return response()->json($truck, 201);

        } catch (Exception $e) {

            Log::error('Error creando truck: ' . $e->getMessage());
            return response()->json(['Error creando truck'], 500);

        }
    }

    public function show(string $id)
    {
        try {

            $truck = $this->truckService->find($id);

            if (!$truck) {
                return response()->json(['Error' => 'Truck no encontrado'], 404);
            }

            return response()->json($truck, 200);

        } catch (Exception $e) {

            Log::error('Error buscando truck: ' . $e->getMessage());
            return response()->json(['Error buscando truck'], 500);

        }
    }

    public function update(Request $request, string $id)
    {
        try {

            $data = $request->only(['user','year','color','plates']);
            $truck = $this->truckService->update($id, $data);

            if (!$truck) {
                return response()->json(['Error' => 'Truck no encontrado'], 404);
            }

            return response()->json($truck);

        } catch (Exception $e) {

            Log::error('Error actualizando truck: ' . $e->getMessage());
            return response()->json(['Error actualizando truck'], 500);

        }
    }

    public function destroy(string $id)
    {
        try {

            if ($this->truckService->delete($id)) {
                return response()->json(['message' => 'Truck eliminado']);
            }

            return response()->json(['Error' => 'Truck no encontrado'], 404);

        } catch (Exception $e) {

            Log::error('Error eliminando truck: ' . $e->getMessage());
            return response()->json(['Error eliminando truck'], 500);

        }
    }


}
