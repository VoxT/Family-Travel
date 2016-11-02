<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;

use App\Skyscanner\Transport\Flights;

class SearchResultController extends Controller
{
    public function searchResult()
    {
        return view('pages.searchResult')->with('request', json_encode(Input::get()));
    }
}
