<?php
namespace App\Filament\Resources\ElementResource\Api\Handlers;

use Illuminate\Http\Request;
use Rupadana\ApiService\Http\Handlers;
use App\Filament\Resources\ElementResource;
use App\Filament\Resources\ElementResource\Api\Requests\CreateElementRequest;

class CreateHandler extends Handlers {
    public static string | null $uri = '/';
    public static string | null $resource = ElementResource::class;

    public static function getMethod()
    {
        return Handlers::POST;
    }

    public static function getModel() {
        return static::$resource::getModel();
    }

    /**
     * Create Element
     *
     * @param CreateElementRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function handler(CreateElementRequest $request)
    {
        $model = new (static::getModel());

        $model->fill($request->all());

        $model->save();

        return static::sendSuccessResponse($model, "Successfully Create Resource");
    }
}