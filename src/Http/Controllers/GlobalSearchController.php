<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GlobalSearchController extends Controller
{


    public function search(Request $request):JsonResponse
    {
        $path = app_path() . "/Models";

        $search = $request->input('search');

        if ($search === null || !isset($search['term'])) {
            abort(400);
        }

        $term           = $search['term'];
        $searchableData = [];

        foreach ($this->getModels($path) as $model)
        {
            $modelClass = '\App\Models\\' . class_basename($model);
            $query      = $modelClass::query();

            $fields = $modelClass::$searchable;

            foreach ($fields as $field)
            {
                $query->orWhere($field, 'LIKE', '%' . $term . '%');
            }

            $results = $query->take(10)
                ->get();

            foreach ($results as $result)
            {
                $parsedData           = $result->only($fields);
                $parsedData['model']  = class_basename($model);
                $parsedData['fields'] = $fields;
                $formattedFields      = [];
                foreach ($fields as $field) {
                    $formattedFields[$field] = Str::title(str_replace('_', ' ', $field));
                }
                $parsedData['fields_formated'] = $formattedFields;

                $parsedData['url'] = url(Str::plural(lcfirst(class_basename($model))) .'?button_id="editBtn"');

                $searchableData[] = $parsedData;
            }
        }

        return response()->json(['results' => $searchableData]);
    }

    public function getModels($path)
    {

        $out = [];
        $results = scandir($path);
        foreach ($results as $result) {
            if ($result === '.' or $result === '..' or $result === 'Scopes') continue;
            $filename = $path . '/' . $result;
            if (is_dir($filename)) {
                $out = array_merge($out, $this->getModels($filename));
            }else{
                $out[] = substr($filename,0,-4);
            }
        }
        return $out;
        //<a href="{{ route('my_route') }}?button_id=my-button" onclick="triggerButton('my-button'); return false;">Click me to trigger the button</a>

    }
}
