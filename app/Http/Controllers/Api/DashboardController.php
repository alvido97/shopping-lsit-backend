<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ShoppingList;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
    public function dashboard(): JsonResponse
    {
        return response()->json([
            'shoppingListCount' => ShoppingList::query()->count(),
        ]);
    }
}
