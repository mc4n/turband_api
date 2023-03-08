<?php

namespace App\Http\Controllers;

use App\Http\Requests\DefinitionStoreRequest;
use App\Models\Definition;
use App\Models\Word;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class DefinitionController extends Controller
{
    public function index()
    {
        return QueryBuilder::for(Definition::class)
            ->allowedFilters([AllowedFilter::partial('word', 'word.word')])
            ->allowedIncludes(['word'])->simplePaginate(10);
    }

    public function store(DefinitionStoreRequest $request)
    {
        $vals = $request->validated();

        $vals['user_id'] = auth()->user()->id;

        $word = Word::firstOrCreate(['word' => $vals['word'], 'user_id' => $vals['user_id']]);

        $def = new Definition(['definition' => $vals['definition'], 'user_id' => $vals['user_id']]);

        if (key_exists('example', $vals)) $def->example = $vals['example'];

        $def->word()->associate($word);

        if ($def->save()) {
            return $this->sendResponse(
                $def,
                __(
                    'messages.store.success',
                    ['model' => __('messages.model.definition')]
                )
            );
        } else
            return $this->sendError(__(
                'messages.store.fail',
                ['model' => __('messages.model.definition')]
            ));
    }
}
