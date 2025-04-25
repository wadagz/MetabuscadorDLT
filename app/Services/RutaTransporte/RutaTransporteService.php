<?php

namespace App\Services\RutaTransporte;

use Illuminate\Support\Facades\Http;

class RutaTransporteService
{
    public function obtenerKCaminosMasCortos(int $origin_id, int $target_id, int $K = 3)
    {
        $response = Http::get('http://127.0.0.1:5000/api/kshortestpaths', [
            'origin_id' => $origin_id,
            'target_id' => $target_id,
            'K' => $K,
        ]);

        if ($response->successful()) {
            return $response->json();
        }

        logger()->error("External API error", [
            'status' => $response->status(),
            'body' => $response->body(),
        ]);

        throw new \Exception("External API failed");
    }
}
