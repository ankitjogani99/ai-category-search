<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SemanticSearchService;

class SearchController extends Controller {

    /**
     * Show the search form
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index() {
        return view('search');
    }

    /**
     * Handle the semantic search request
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Services\SemanticSearchService $semanticSearch
     * @return \Illuminate\Contracts\View\View
     */
    public function search(Request $request, SemanticSearchService $semanticSearch) {
        $query = $request->input('query');
        $results = $query ? $semanticSearch->search($query) : [];

        return view('search', compact('query', 'results'));
    }
}
