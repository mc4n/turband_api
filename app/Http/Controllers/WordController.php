<?php

namespace App\Http\Controllers;

use App\Models\Word;
use Spatie\QueryBuilder\QueryBuilder;

class WordController extends Controller
{
    public function index()
    {
        return QueryBuilder::for(Word::class)->get();
    }
}
