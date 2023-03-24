<?php

namespace App\Http\Controllers;


use Illuminate\Support\Str;
use ReflectionClass;

class DashboardBaseController extends Controller
{
    /**
     * get the scope defined in model.
     */

    public function getModelScopes($model_name)
    {
        $model="\\App\\Models\\".$model_name;
        $reflection = new ReflectionClass($model);

        return collect($reflection->getMethods())->filter(function ($method) {
            return Str::startsWith($method->name, 'scope');
        })->whereNotIn('name', ['scopeWithTranslations', 'scopeWithTranslation', 'scopeWhereTranslation'])->transform(function ($method) {
            return lcfirst(Str::replaceFirst('scope', '', $method->name));
        });
    }
}
