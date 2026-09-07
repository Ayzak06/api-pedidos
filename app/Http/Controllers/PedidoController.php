<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    public function index()
    {
        $pedidos = Pedido::with(['usuario', 'productos'])->get();

        return response()->json($pedidos, 200);
    }

    public function store(Request $request)
    {
        $datos = $request->validate([
            'usuario_id' => 'required|exists:usuarios,id',
            'fecha' => 'required|date',
            'total' => 'required|numeric|min:0',
        ]);

        $pedido = Pedido::create($datos);

        return response()->json(
            $pedido->load(['usuario', 'productos']),
            201
        );
    }

    public function show(string $id)
    {
        $pedido = Pedido::with(['usuario', 'productos'])->find($id);

        if (!$pedido) {
            return response()->json([
                'mensaje' => 'Pedido no encontrado'
            ], 404);
        }

        return response()->json($pedido, 200);
    }

    public function update(Request $request, string $id)
    {
        $pedido = Pedido::find($id);

        if (!$pedido) {
            return response()->json([
                'mensaje' => 'Pedido no encontrado'
            ], 404);
        }

        $datos = $request->validate([
            'usuario_id' => 'sometimes|required|exists:usuarios,id',
            'fecha' => 'sometimes|required|date',
            'total' => 'sometimes|required|numeric|min:0',
        ]);

        $pedido->update($datos);

        return response()->json(
            $pedido->load(['usuario', 'productos']),
            200
        );
    }

    public function destroy(string $id)
    {
        $pedido = Pedido::find($id);

        if (!$pedido) {
            return response()->json([
                'mensaje' => 'Pedido no encontrado'
            ], 404);
        }

        $pedido->delete();

        return response()->json([
            'mensaje' => 'Pedido eliminado correctamente'
        ], 200);
    }
}