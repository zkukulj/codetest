<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TvShowController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->query('q');
        //$query = "deadwood";

        // TVMaze API request .. search for TV shows
        $response = Http::get('http://api.tvmaze.com/search/shows', ['q' => $query]);

        // If TVMaze request was successful
        if ($response->successful()) {
            $results = $response->json();
            $validResults = [];

            // Filter results, match exactly the search query only non-case sensitive
            foreach ($results as $result) {
                if (strcasecmp($result['show']['name'], $query) === 0) {
                    $validResults[] = $result;
                }
            }

            return response()->json(['data' => $validResults]);
        } else {
            // If TVMaze request throws erorr
            return response()->json(['error' => 'Very sorry, unable to retrive TV shows from TVMaze'], 500);
        }
    }
}
