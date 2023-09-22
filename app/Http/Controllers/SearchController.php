<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resource; // Replace with the appropriate model

class SearchController extends Controller
{
    // Perform a search based on certain criteria
    public function search(Request $request)
    {
        // Get the search query from the request
        $query = $request->input('query');

        // Perform the search on the Resource model (replace with your model)
        $results = Resource::where('name', 'LIKE', "%$query%")->get();

        return response()->json(['results' => $results]);
    }
}

