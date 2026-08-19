<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EventoController extends Controller
{
    /**
     * Mostrar una lista del recurso.
     */
    public function index()
    {
        // Recuperar todos los recursos
        $eventos = Evento::all();

        // Retornar los recursos recuperados
        $respuesta = [
            'eventos' => $eventos,
            'status' => 200,
        ];

        return response()->json($respuesta);
    }

    /**
     * Almacenar un recurso recién creado en el almacenamiento.
     */
    public function store(Request $request)
    {
        // Validar que la petición contenga todos los datos necesarios
        $validator = Validator::make($request->all(), [
            'titulo' => 'required',
            'descripcion' => 'required',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date',
            'ubicacion' => 'required',
        ]);

        // Si la petición no contiene todos los datos necesarios
        if ($validator->fails()) {
            $respuesta = [
                'message' => 'Datos faltantes',
                'status' => 400,
            ];

            return response()->json($respuesta, 400);
        }

        // Crear un nuevo recurso con los datos de la petición
        $evento = Evento::create([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
            'ubicacion' => $request->ubicacion,
        ]);

        // Si el recurso no se pudo crear
        if (!$evento) {
            $respuesta = [
                'message' => 'Error al crear el evento',
                'status' => 500,
            ];

            return response()->json($respuesta, 500);
        }

        // Retornar el recurso creado
        $respuesta = [
            'evento' => $evento,
            'status' => 201,
        ];

        return response()->json($respuesta, 201);
    }

    /**
     * Mostrar el recurso especificado.
     */
    public function show($id)
    {
        $evento = Evento::find($id);

        if (!$evento) {
            $respuesta = [
                'message' => 'Evento no encontrado',
                'status' => 404,
            ];

            return response()->json($respuesta, 404);
        }

        $respuesta = [
            'evento' => $evento,
            'status' => 200,
        ];

        return response()->json($respuesta);
    }

    /**
     * Actualizar el recurso especificado en el almacenamiento.
     */
    public function update(Request $request, $id)
    {
        $evento = Evento::find($id);

        if (!$evento) {
            $respuesta = [
                'message' => 'Evento no encontrado',
                'status' => 404,
            ];

            return response()->json($respuesta, 404);
        }

        $validator = Validator::make($request->all(), [
            'titulo' => 'required',
            'descripcion' => 'required',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date',
            'ubicacion' => 'required',
        ]);

        if ($validator->fails()) {
            $respuesta = [
                'message' => 'Datos faltantes',
                'status' => 400,
            ];

            return response()->json($respuesta, 400);
        }

        $evento->titulo = $request->titulo;
        $evento->descripcion = $request->descripcion;
        $evento->fecha_inicio = $request->fecha_inicio;
        $evento->fecha_fin = $request->fecha_fin;
        $evento->ubicacion = $request->ubicacion;

        $evento->save();

        $respuesta = [
            'evento' => $evento,
            'status' => 200,
        ];

        return response()->json($respuesta);
    }

    /**
     * Eliminar el recurso especificado del almacenamiento.
     */
    public function destroy($id)
    {
        $evento = Evento::find($id);

        if (!$evento) {
            $respuesta = [
                'message' => 'Evento no encontrado',
                'status' => 404,
            ];

            return response()->json($respuesta, 404);
        }

        $evento->delete();

        $respuesta = [
            'message' => 'Evento eliminado',
            'status' => 200,
        ];

        return response()->json($respuesta);
    }
}