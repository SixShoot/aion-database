<?php

namespace App\Http\Controllers;

use App\ClientItems;
use App\Http\Requests\SearchRequest;

class SearchController extends Controller
{
	/**
     * POST /{lang}/items/search
     */
    public function search($lang, SearchRequest $request)
    {		
		if(empty($request->input('search_value')))
			return;
		
        $searchValue = $request->input('search_value');

        $results = ClientItems::where('desc', 'not like', '%test%')
						->where('desc_fr', 'like', '%'.$searchValue.'%')
						->orderByRaw("FIELD(quality, 'epic', 'unique', 'legend', 'rare', 'common', 'junk') ASC")
						->orderBy('level', 'desc')
						->orderBy('id', 'asc')
						->paginate(100);

        $results->appends(['search_value' => $searchValue]);

        return view('data.table', [
			'lang'	=> $lang,
			'type'	=> 'R&eacute;sultats de la recherche pour &quot;' . $searchValue . '&quot;',
			'search'=> $searchValue,
            'items' => $results
        ]);

    }
	
}