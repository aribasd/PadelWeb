<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GeocodingController extends Controller
{
    public function search(Request $request)
    {
        $q = trim((string) $request->query('q', ''));
        if (mb_strlen($q) < 3) {
            return response()->json([]);
        }

        $resp = Http::withHeaders([
            // Nominatim requereix identificació; adapta-ho si vols.
            'User-Agent' => 'PadelWeb/1.0 (local dev)',
            'Accept' => 'application/json',
        ])->get('https://nominatim.openstreetmap.org/search', [
            'q' => $q,
            'format' => 'json',
            'addressdetails' => 1,
            'limit' => 6,
        ]);

        if (! $resp->successful()) {
            return response()->json([]);
        }

        $data = collect($resp->json() ?? [])
            ->map(function ($item) {
                return [
                    'display_name' => $item['display_name'] ?? null,
                    'lat' => isset($item['lat']) ? (float) $item['lat'] : null,
                    'lng' => isset($item['lon']) ? (float) $item['lon'] : null,
                ];
            })
            ->filter(fn ($x) => $x['display_name'] && $x['lat'] && $x['lng'])
            ->values()
            ->all();

        return response()->json($data);
    }
}

