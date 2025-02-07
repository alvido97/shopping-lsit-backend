<?php

namespace App\Actions;

use App\Models\ShoppingList;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class ListShoppingListsAction
{
    public function execute(
    ): LengthAwarePaginator
    {
        return ShoppingList::query()
            ->where('created_by', Auth::user()->id)
            ->latest('created_at')
            ->paginate( 10)
            ->withQueryString()
            ->through(function ($shoppingList) {
                return [
                    'id' => $shoppingList->id,
                    'slug' => $shoppingList->slug,
                    'title' => $shoppingList->title,
                    'createdAt' => Carbon::parse($shoppingList->created_at)->format('Y-m-d H:i:s')
                ];
            });
    }

}
