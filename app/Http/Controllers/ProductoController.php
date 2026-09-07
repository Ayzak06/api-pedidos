<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index()
    {
        $productos = Producto::with('pedido')->get();

        return response()->json($productos, 200);
    }

    public function store(Request $request)
    {
        $datos = $request->validate([
            'pedido_id' => 'required|exists:pedidos,id',
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        $producto = Producto::create($datos);

        return response()->json(
            $producto->load('pedido'),
            201
        );
    }

    public function show(string $id)
    {
        $producto = Producto::with('pedido')->find($id);

        if (!$producto) {
            return response()->json([
                'mensaje' => 'Producto no encontrado'
            ], 404);
        }

        return response()->json($producto, 200);
    }

    public function update(Request $request, string $id)
    {
        $producto = Producto::find($id);

        if (!$producto) {
            return response()->json([
                'mensaje' => 'Producto no encontrado'
            ], 404);
        }

        $datos = $request->validate([
            'pedido_id' => 'sometimes|required|exists:pedidos,id',
            'nombre' => 'sometimes|required|string|max:255',
            'precio' => 'sometimes|required|numeric|min:0',
            'stock' => 'sometimes|required|integer|min:0',
        ]);

        $producto->update($datos);

        return response()->json(
            $producto->load('pedido'),
            200
        );
    }

    public function destroy(string $id)
    {
        $producto = Producto::find($id);

        if (!$producto) {
            return response()->json([
                'mensaje' => 'Producto no encontrado'
            ], 404);
        }

        $producto->delete();

        return response()->json([
            'mensaje' => 'Producto eliminado correctamente'
        ], 200);
    }
}