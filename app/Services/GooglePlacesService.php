<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GooglePlacesService
{
    protected string $apiKey;
    protected string $baseUrl = 'https://maps.googleapis.com/maps/api/place';

    public function __construct()
    {
        $this->apiKey = config('services.google.places_api_key', env('GOOGLE_PLACES_API_KEY'));
    }

    /**
     * Search for places near Kairouan, Tunisia.
     *
     * @param string $query Search query (e.g., "doctor", "plumber")
     * @param array $options Additional search options
     * @return array
     */
    public function searchPlaces(string $query, array $options = []): array
    {
        if (empty($this->apiKey)) {
            throw new \Exception('Google Places API key is not configured.');
        }

        $location = $options['location'] ?? '35.6812,10.1000'; // Kairouan coordinates
        $radius = $options['radius'] ?? 10000; // 10km radius
        $type = $options['type'] ?? null;
        $language = $options['language'] ?? 'ar'; // Arabic for Tunisia

        try {
            $response = Http::get("{$this->baseUrl}/textsearch/json", [
                'query' => $query . ' Kairouan Tunisia',
                'key' => $this->apiKey,
                'location' => $location,
                'radius' => $radius,
                'type' => $type,
                'language' => $language,
            ]);

            if ($response->failed()) {
                Log::error('Google Places API error', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
                throw new \Exception('Failed to fetch places from Google Places API.');
            }

            $data = $response->json();

            if ($data['status'] !== 'OK' && $data['status'] !== 'ZERO_RESULTS') {
                Log::error('Google Places API error', [
                    'status' => $data['status'],
                    'error_message' => $data['error_message'] ?? 'Unknown error',
                ]);
                throw new \Exception($data['error_message'] ?? 'Google Places API returned an error.');
            }

            return $this->formatResults($data['results'] ?? []);
        } catch (\Exception $e) {
            Log::error('Google Places Service Error', [
                'message' => $e->getMessage(),
                'query' => $query,
            ]);
            throw $e;
        }
    }

    /**
     * Get detailed information about a place.
     *
     * @param string $placeId Google Place ID
     * @return array|null
     */
    public function getPlaceDetails(string $placeId): ?array
    {
        if (empty($this->apiKey)) {
            throw new \Exception('Google Places API key is not configured.');
        }

        try {
            $response = Http::get("{$this->baseUrl}/details/json", [
                'place_id' => $placeId,
                'key' => $this->apiKey,
                'fields' => 'name,formatted_address,formatted_phone_number,international_phone_number,website,rating,user_ratings_total,opening_hours,geometry,types,photos',
                'language' => 'ar',
            ]);

            if ($response->failed()) {
                Log::error('Google Places Details API error', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
                return null;
            }

            $data = $response->json();

            if ($data['status'] !== 'OK') {
                Log::error('Google Places Details API error', [
                    'status' => $data['status'],
                    'error_message' => $data['error_message'] ?? 'Unknown error',
                ]);
                return null;
            }

            return $this->formatPlaceDetails($data['result']);
        } catch (\Exception $e) {
            Log::error('Google Places Details Service Error', [
                'message' => $e->getMessage(),
                'place_id' => $placeId,
            ]);
            return null;
        }
    }

    /**
     * Format search results for easier use.
     */
    protected function formatResults(array $results): array
    {
        return array_map(function ($result) {
            return [
                'place_id' => $result['place_id'] ?? null,
                'name' => $result['name'] ?? '',
                'address' => $result['formatted_address'] ?? '',
                'rating' => $result['rating'] ?? null,
                'user_ratings_total' => $result['user_ratings_total'] ?? 0,
                'types' => $result['types'] ?? [],
                'geometry' => $result['geometry'] ?? null,
                'photos' => isset($result['photos']) ? [
                    'photo_reference' => $result['photos'][0]['photo_reference'] ?? null,
                ] : null,
            ];
        }, $results);
    }

    /**
     * Format place details.
     */
    protected function formatPlaceDetails(array $result): array
    {
        return [
            'place_id' => $result['place_id'] ?? null,
            'name' => $result['name'] ?? '',
            'address' => $result['formatted_address'] ?? '',
            'phone' => $result['formatted_phone_number'] ?? $result['international_phone_number'] ?? null,
            'website' => $result['website'] ?? null,
            'rating' => $result['rating'] ?? null,
            'user_ratings_total' => $result['user_ratings_total'] ?? 0,
            'types' => $result['types'] ?? [],
            'geometry' => $result['geometry'] ?? null,
            'opening_hours' => $result['opening_hours'] ?? null,
            'photos' => $result['photos'] ?? [],
        ];
    }
}
