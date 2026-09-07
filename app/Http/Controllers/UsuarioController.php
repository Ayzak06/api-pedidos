<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    /**
     * Mostrar todos los usuarios.
     */
    public function index()
    {
        $usuarios = Usuario::all();

        return response()->json($usuarios, 200);
    }

    /**
     * Crear un nuevo usuario.
     */
    public function store(Request $request)
    {
        $datos = $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ]);

        $usuario = Usuario::create($datos);

        return response()->json($usuario, 201);
    }

    /**
     * Mostrar un usuario específico.
     */
    public function show(string $id)
    {
        $usuario = Usuario::with('pedidos')->find($id);

        if (!$usuario) {
            return response()->json([
                'mensaje' => 'Usuario no encontrado'
            ], 404);
        }

        return response()->json($usuario, 200);
    }

    /**
     * Actualizar un usuario.
     */
    public function update(Request $request, string $id)
    {
        $usuario = Usuario::find($id);

        if (!$usuario) {
            return response()->json([
                'mensaje' => 'Usuario no encontrado'
            ], 404);
        }

        $datos = $request->validate([
            'nombre' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|max:255',
        ]);

        $usuario->update($datos);

        return response()->json($usuario, 200);
    }

    /**
     * Eliminar un usuario.
     */
    public function destroy(string $id)
    {
        $usuario = Usuario::find($id);

        if (!$usuario) {
            return response()->json([
                'mensaje' => 'Usuario no encontrado'
            ], 404);
        }

        $usuario->delete();

        return response()->json([
            'mensaje' => 'Usuario eliminado correctamente'
        ], 200);
    }
}
