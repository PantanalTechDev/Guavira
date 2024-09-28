<?php

namespace App\Http\Controllers;

use App\Models\Guavira;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;  
 // For conditional validation rules

class GuaviraController extends Controller
{
    /**
     * Show the form for creating a new Guavira.
     */
    public function create()
    {
        return view('guavira.create');
    }

    /**
     * Store a newly created Guavira in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Conditional validation based on user input
        $validationRules = [
            'imagem' => ['nullable', 'image', 'mimes:jpg,png,jpeg,gif', 'max:2048'],
            'descricao' => ['required', 'string'],
        ];

        if ($request->has('latitude') && $request->has('longitude')) {
            // Validate coordinates if provided
            $validationRules = array_merge($validationRules, [
                'latitude' => ['required', 'numeric', 'between:-90,90'],
                'longitude' => ['required', 'numeric', 'between:-180,180'],
            ]);
        } else {
            // Validate address if provided as an alternative
            $validationRules['endereco'] = ['required', 'string'];
        }

        // Validate the request data
        $request->validate($validationRules);

        // Prepare data
        $data = $request->only(['latitude', 'longitude', 'endereco', 'descricao']);

        // Handle file upload
        if ($request->hasFile('imagem')) {
            $path = $request->file('imagem')->store('images', 'public');
            $data['imagem'] = $path;
        }

        try {
            // Create and save the Guavira
            $guavira = new Guavira($data);
            $guavira->user_id = Auth::id(); // Associate with logged-in user

            // If address is provided, use geocoding to get coordinates
            if (isset($data['endereco']) && !empty($data['endereco'])) {
                // Replace 'YOUR_API_KEY' with your actual geocoding API key
                $geocodeUrl = "https://maps.googleapis.com/maps/api/geocode/json?address=" . urlencode($data['endereco']) . "&key=AIzaSyA7WqvFFtkFCYHsncBNNOf4R4R6NpQOmco";
                $geocodeResponse = json_decode(file_get_contents($geocodeUrl), true);

                if (isset($geocodeResponse['results'][0]['geometry']['location'])) {
                    $guavira->latitude = $geocodeResponse['results'][0]['geometry']['location']['lat'];
                    $guavira->longitude = $geocodeResponse['results'][0]['geometry']['location']['lng'];
                }
            }

            $guavira->save();

            // Handle success response based on request type
            if ($request->expectsJson()) {
                return response()->json(['success' => 'Guavira registered successfully!'], 201);
            }

            return redirect()->route('guavira.map')->with('success', 'Guavira registered successfully!');

        } catch (\Exception $e) {
            \Log::error('Error saving Guavira:', ['exception' => $e->getMessage()]);

            // Handle error response based on request type
            if ($request->expectsJson()) {
                return response()->json(['error' => 'An error occurred while saving the Guavira.'], 500);
            }

            return redirect()->back()->with('error', 'An error occurred while saving the Guavira.');
        }
    }

    /**
     * Fetch Guavira trees or show the map view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function map(Request $request)
    {
        // Get latitude, longitude, and radius from the request
        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');
        $radius = $request->input('radius', 10); // Default radius of 10 km

        try {
            // If latitude and longitude are provided, calculate distances and filter Guaviras
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

                // If the request expects JSON, return the data as JSON
                if ($request->expectsJson()) {
                    return response()->json($guaviras);
                }
            }

            // Otherwise, show the map view
            return $this->showMapView();

        } catch (\Exception $e) {
            \Log::error('Error fetching Guavira data:', ['exception' => $e->getMessage()]);

            if ($request->expectsJson()) {
                return response()->json(['error' => 'An error occurred while fetching data.'], 500);
            }

            return view('map')->with('error', 'An error occurred while loading the map.');
        }
    }

    /**
     * Show the map view with all Guavira data.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    protected function showMapView()
    {
        // Fetch all Guavira data
        $guaviras = Guavira::orderBy('created_at', 'desc')->get();

        // If no Guavira objects are found, pass null to the view
        if ($guaviras->isEmpty()) {
            $guaviras = null;
        }

        // Render the map view with Guavira data or null
        return view('map', ['guaviras' => $guaviras]);
    }
}
