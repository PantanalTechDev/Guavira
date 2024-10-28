<?php

namespace App\Http\Controllers;

use App\Models\Guavira;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class GuaviraController extends Controller
{
    /**
     * Show the form for creating a new Guavira.
     */
    public function create()
    {
        $guaviras = Guavira::with('user')
                    ->orderBy('created_at', 'desc')
                    ->get();

        return view('guavira.create', ['guaviras' => $guaviras, 'mapKey' => config('services.google.maps_api_key')]);
    }

    /**
     * Store a newly created Guavira in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        Log::info("Store method invoked");

        try {
            Log::info("Input Data: ", $request->all());

            // Validation rules
            $validationRules = [
                'descricao' => ['required', 'string', 'max:150'],
                'imagem' => ['nullable', 'image', 'mimes:jpg,png,jpeg,gif', 'max:2048'],
                'registration_type' => ['required', 'in:simples,comerciante'], // Validate registration type
                'latitude' => ['nullable', 'numeric', 'between:-90,90'],
                'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            ];

            // CNPJ validation only for 'comerciante' type
            if ($request->input('registration_type') === 'comerciante') {
                $validationRules['cnpj'] = [
                    'required',
                    'digits:14',
                    'regex:/^\d{14}$/',
                ];
            }

            if ($request->input('location_type') == 'endereco') {
                $validationRules['cidade'] = ['required', 'string', 'max:100'];
                $validationRules['rua'] = ['required', 'string', 'max:150'];
                $validationRules['numero'] = ['required', 'string', 'max:10'];
            }

            // Validate request
            $validatedData = $request->validate($validationRules);
            Log::info('Validation passed:', ['data' => $validatedData]);

            // Initialize data for the Guavira model
            $data = [
                'descricao' => $validatedData['descricao'],
                'imagem' => null,
                'latitude' => null,
                'longitude' => null,
                'cnpj' => $request->input('registration_type') === 'comerciante'
                    ? preg_replace('/\D/', '', $validatedData['cnpj'])
                    : null
            ];

            Log::info('Data before processing image and geocoding:', ['data' => $data]);

            // Handle image upload if present
            if ($request->hasFile('imagem')) {
                $path = $request->file('imagem')->store('images', 'public');
                $data['imagem'] = $path;
                Log::info('Image uploaded:', ['path' => $path]);
            }

            // Process geocoding or use manual coordinates
            if ($request->input('location_type') === 'manual') {
                $data['latitude'] = $validatedData['latitude'];
                $data['longitude'] = $validatedData['longitude'];
                Log::info('Manual coordinates set:', ['latitude' => $data['latitude'], 'longitude' => $data['longitude']]);
            }
            elseif ($request->input('location_type') === 'endereco'){
                $fullAddress = "{$validatedData['cidade']}, {$validatedData['rua']}, {$validatedData['numero']}";
                Log::info('Attempting geocode with address:', ['address' => $fullAddress]);
                $geoResult = $this->geocode($fullAddress);

                if ($geoResult['success']) {
                    $data['latitude'] = $geoResult['latitude'];
                    $data['longitude'] = $geoResult['longitude'];
                    Log::info('Geocoding successful:', ['latitude' => $data['latitude'], 'longitude' => $data['longitude']]);
                } else {
                    Log::error('Geocoding failed for address:', ['address' => $fullAddress]);
                    return back()->withErrors(['address' => 'Could not geocode address. Please check the details.']);
                }
            }

            // Save the Guavira model with the collected data
            $guavira = new Guavira($data);
            $guavira->user_id = Auth::id();
            $guavira->save();

            Log::info('Data successfully saved to database:', ['data' => $data]);

            return redirect()->route('guavira.create')->with('success', 'Guavira registered successfully!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation exception:', ['errors' => $e->errors()]);
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('General exception occurred:', ['message' => $e->getMessage()]);
            return back()->withErrors(['error' => 'An error occurred while processing your request. Please try again later.'])->withInput();
        }
    }

    public function home()
    {
        return view('home'); 
    }

    public function map(Request $request)
    {
        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');
        $radius = $request->input('radius', 10);

        try {
            if (!is_null($latitude) && !is_null($longitude)) {
                $latitude = (float) $latitude;
                $longitude = (float) $longitude;

                $guaviras = DB::table(DB::raw("(SELECT *, 
                    (6371 * acos(cos(radians($latitude)) * cos(radians(latitude)) * 
                    cos(radians(longitude) - radians($longitude)) + 
                    sin(radians($latitude)) * sin(radians(latitude)))) AS distance
                FROM guaviras) AS sub"))
                    ->where('distance', '<', $radius)
                    ->orderBy('distance')
                    ->get();

                if ($request->expectsJson()) {
                    return response()->json($guaviras);
                }
            } else {
                // If no location data is provided, fetch all Guavira records
                $guaviras = Guavira::with('user')
                    ->orderBy('created_at', 'desc')
                    ->get();

                return view('map', ['guaviras' => $guaviras, 'mapKey' => config('services.google.maps_api_key')]);
            }

            return view('map', ['guaviras' => $guaviras, 'mapKey' => config('services.google.maps_api_key')]);

        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'An error occurred while fetching data.'], 500);
            }

            return view('map')->with('error', 'An error occurred while loading the map.');
        }
    }

    /**
     * Geocode the given address to fetch latitude and longitude.
     *
     * @param string $address
     * @return array
     */
    private function geocode($address)
    {
        // Request to the Google Maps Geocoding API
        $apiKey = config('services.google.maps_api_key');

        Log::info("got here");

        $response = Http::get("https://maps.googleapis.com/maps/api/geocode/json", [
            'address' => $address,
            'key' => $apiKey,
        ]);
        
        Log::info('Google Maps API response:', ['response' => $response->json()]);

        // Check if the request was successful and results are available
        if ($response->successful() && isset($response->json()['results'][0])) {
            $location = $response->json()['results'][0]['geometry']['location'];
            return [
                'success' => true,
                'latitude' => $location['lat'],
                'longitude' => $location['lng'],
            ];
        }

        // Return failure if geocoding did not succeed
        return ['success' => false];
    }
}
