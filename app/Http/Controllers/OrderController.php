<?php

namespace App\Http\Controllers;

use App\Interfaces\OrderServiceInterface;
use Illuminate\Http\Request;
use Exception;
use Log;

class OrderController extends Controller
{
    private $orderService;

    public function __construct(OrderServiceInterface $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index()
    {
        try {

            return response()->json($this->orderService->getAll(), 200);

        } catch (Exception $e) {

            Log::error('Error al obtener órdenes: ' . $e->getMessage());
            return response()->json(['Error al obtener órdenes'], 500);

        }
    }

    public function store(Request $request)
    {
        try {

            $data = $request->only(['user','truck','status','pickup','dropoff']);
            $order = $this->orderService->create($data);
            return response()->json($order, 201);

        } catch (Exception $e) {

            Log::error('Error creando orden: ' . $e->getMessage());
            return response()->json(['Error creando orden'], 500);

        }
    }

    public function show(string $id)
    {
        try {

            $order = $this->orderService->find($id);

            if (!$order) {
                return response()->json(['Error' => 'Orden no encontrada'], 404);
            }

            return response()->json($order, 200);

        } catch (Exception $e) {

            Log::error('Error buscando orden: ' . $e->getMessage());
            return response()->json(['Error buscando orden'], 500);

        }
    }

    public function update(Request $request, string $id)
    {
        try {

            $data = $request->only(['user','truck','status','pickup','dropoff']);
            $order = $this->orderService->update($id, $data);

            if (!$order) {
                return response()->json(['Error' => 'Orden no encontrada'], 404);
            }

            return response()->json($order);

        } catch (Exception $e) {

            Log::error('Error actualizando orden: ' . $e->getMessage());
            return response()->json(['Error actualizando orden'], 500);

        }
    }

    public function destroy(string $id)
    {
        try {

            if ($this->orderService->delete($id)) {
                return response()->json(['message' => 'Orden eliminada']);
            }

            return response()->json(['Error' => 'Orden no encontrada'], 404);

        } catch (Exception $e) {

            Log::error('Error eliminando orden: ' . $e->getMessage());
            return response()->json(['Error eliminando orden'], 500);

        }
    }

    public function updateStatus(Request $request, string $id)
    {
        try {

            $status = $request->input('status');
            $order = $this->orderService->updateStatus($id, $status);

            if (!$order) {
                return response()->json(['Error' => 'Orden no encontrada'], 404);
            }

            return response()->json($order);

        } catch (Exception $e) {

            Log::error('Error actualizando status de la orden: ' . $e->getMessage());
            return response()->json(['Error actualizando status'], 500);

        }
    }
}
