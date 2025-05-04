<?php
namespace App\Filament\Resources\ElementResource\Api;

use Rupadana\ApiService\ApiService;
use App\Filament\Resources\ElementResource;
use Illuminate\Routing\Router;


class ElementApiService extends ApiService
{
    protected static string | null $resource = ElementResource::class;

    public static function handlers() : array
    {
        return [
            Handlers\CreateHandler::class,
            Handlers\UpdateHandler::class,
            Handlers\DeleteHandler::class,
            Handlers\PaginationHandler::class,
            Handlers\DetailHandler::class
        ];

    }
}
