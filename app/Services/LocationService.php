<?php

namespace App\Services;

use App\Interfaces\LocationServiceInterface;
use App\Models\Location;
use Illuminate\Support\Facades\Http;
use Exception;

class LocationService implements LocationServiceInterface
{
    public function getAll()
    {
        return Location::all();
    }

    public function create(array $data)
    {
        $placeId = $data['place_id'];

        // Se evita duplicados
        if (Location::where('place_id', $placeId)->exists()) {
            throw new Exception("La location con ese place_id ya existe", 409);
        }

        // Llamada a Google Places API
        $apiKey = config('services.google.maps_key');
        $response = Http::get("https://maps.googleapis.com/maps/api/place/details/json", [
            'place_id' => $placeId,
            'key'      => $apiKey,
            'language' => 'es',
        ]);

        if ($response->failed()) {
            throw new Exception("Error al conectar con Google Places API");
        }

        $result = $response->json('result');

        if (!$result) {
            throw new Exception("No se encontró información para el place_id proporcionado");
        }

        // Extracción de datos
        $address   = $result['formatted_address'] ?? null;
        $latitude  = $result['geometry']['location']['lat'] ?? null;
        $longitude = $result['geometry']['location']['lng'] ?? null;

        if (!$address || !$latitude || !$longitude) {
            throw new Exception("Información incompleta en respuesta de Google Places");
        }

        return Location::create([
            'place_id' => $placeId,
            'address'  => $address,
            'latitude' => $latitude,
            'longitude'=> $longitude,
        ]);
    }

    public function find(string $id)
    {
        return Location::find($id);
    }

    public function update(string $id, array $data)
    {
        $location = Location::find($id);
        if (!$location) return null;

        $location->update($data);
        return $location;
    }

    public function delete(string $id)
    {
        $location = Location::find($id);
        if (!$location) return false;

        $location->delete();
        return true;
    }
}
