<?php

namespace App\Filament\Resources\ElementResource\Api\Handlers;

use App\Filament\Resources\SettingResource;
use App\Filament\Resources\ElementResource;
use Rupadana\ApiService\Http\Handlers;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Http\Request;
use App\Filament\Resources\ElementResource\Api\Transformers\ElementTransformer;

class DetailHandler extends Handlers
{
    public static string | null $uri = '/{id}';
    public static string | null $resource = ElementResource::class;


    /**
     * Show Element
     *
     * @param Request $request
     * @return ElementTransformer
     */
    public function handler(Request $request)
    {
        $id = $request->route('id');
        
        $query = static::getEloquentQuery();

        $query = QueryBuilder::for(
            $query->where(static::getKeyName(), $id)
        )
            ->first();

        if (!$query) return static::sendNotFoundResponse();

        return new ElementTransformer($query);
    }
}
