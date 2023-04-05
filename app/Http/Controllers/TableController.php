<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FavoriteCategory;
use App\Http\Controllers\Controller;
use App\Http\Resources\FavoriteCategoryCollection;
use Carbon\Carbon;

class TableController extends Controller
{
    public function __invoke(Request $request)
    {
        // actually need to implement this in repo & service
        $models = FavoriteCategory::query()
            ->when(isset($request['category']), fn($q) => 
                $q->where('category', 'like', "{$request['category']}")
            )
            ->when(isset($request['email']), fn($q) => 
                $q->where('email', 'like', "{$request['email']}")
            )
            ->when(isset($request['gender']), fn($q) => 
                $q->where('gender', 'like', "{$request['gender']}")
            )
            ->when(isset($request['age']), fn($q) => 
                $q->where('birthdate', '>=', now()->subYears($request['age']))
            )
            ->when(isset($request['age_range']), function ($q) use ($request) { 
                $range = explode(',', $request['age_range']);

                $q->whereBetween('birthdate', $range[0], $range[1]);
            })
            ->paginate();

        return response()->json(new FavoriteCategoryCollection($models));
    }
}