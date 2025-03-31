<?php

namespace App\Http\Controllers;

use App\Models\Direccion;
use App\Models\TipoVialidad;
use App\Models\Asentamiento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DireccionController extends Controller
{
    /**
     * Display a listing of all direcciones.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $direcciones = Direccion::with(['tipoVialidad', 'asentamiento'])->get();
        
        return response()->json([
            'success' => true,
            'data' => $direcciones
        ]);
    }

    /**
     * Store a newly created direccion in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:100',
            'latitud' => 'required|numeric|between:-90,90',
            'longitud' => 'required|numeric|between:-180,180',
            'id_tipo_vialidad' => 'required|exists:tipo_vialidades,id',
            'id_asentamiento' => 'required|exists:asentamientos,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $direccion = Direccion::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Dirección creada con éxito',
            'data' => $direccion
        ], 201);
    }

    /**
     * Display the specified direccion.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $direccion = Direccion::with(['tipoVialidad', 'asentamiento'])->findOrFail($id);
        
        return response()->json([
            'success' => true,
            'data' => $direccion
        ]);
    }

    /**
     * Update the specified direccion in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $direccion = Direccion::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'nombre' => 'string|max:100',
            'latitud' => 'numeric|between:-90,90',
            'longitud' => 'numeric|between:-180,180',
            'id_tipo_vialidad' => 'exists:tipo_vialidades,id',
            'id_asentamiento' => 'exists:asentamientos,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $direccion->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Dirección actualizada con éxito',
            'data' => $direccion
        ]);
    }

    /**
     * Remove the specified direccion from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $direccion = Direccion::findOrFail($id);
        $direccion->delete();

        return response()->json([
            'success' => true,
            'message' => 'Dirección eliminada con éxito'
        ]);
    }

    /**
     * Get all direcciones belonging to hospedajes for a specific destino.
     *
     * @param  int  $destinoId
     * @return \Illuminate\Http\Response
     */
    public function getDireccionesByDestino($destinoId)
    {
        $direcciones = Direccion::whereHas('hospedaje', function($query) use ($destinoId) {
            $query->where('destino_id', $destinoId);
        })->get();

        return response()->json([
            'success' => true,
            'data' => $direcciones
        ]);
    }

    /**
     * Get the direccion for a specific hospedaje.
     *
     * @param  int  $hospedajeId
     * @return \Illuminate\Http\Response
     */
    public function getDireccionByHospedaje($hospedajeId)
    {
        $direccion = Direccion::whereHas('hospedaje', function($query) use ($hospedajeId) {
            $query->where('id', $hospedajeId);
        })->first();

        if (!$direccion) {
            return response()->json([
                'success' => false,
                'message' => 'No se encontró dirección para este hospedaje'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $direccion
        ]);
    }

    /**
     * Update coordinates for a specific direccion.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateCoordinates(Request $request, $id)
    {
        $direccion = Direccion::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'latitud' => 'required|numeric|between:-90,90',
            'longitud' => 'required|numeric|between:-180,180',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $direccion->latitud = $request->latitud;
        $direccion->longitud = $request->longitud;
        $direccion->save();

        return response()->json([
            'success' => true,
            'message' => 'Coordenadas actualizadas con éxito',
            'data' => $direccion
        ]);
    }
}