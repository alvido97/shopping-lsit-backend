<?php

namespace App\Actions;

use App\Models\Item;
use App\Models\ShoppingList;

class StoreShoppingListItemsAction
{
    public function execute(
        array $items,
        ShoppingList $shoppingList,
    ): void
    {
        $shoppingList->items()->delete();

        foreach ($items as $singleItem){
            $item = new Item();
            $item->forceFill([
                'title' => $singleItem['title'],
                'quantity' => $singleItem['quantity'],
                'unit' => $singleItem['unit'],
                'shopping_list_id' => $shoppingList->id,
            ]);

            $item->save();
        }

    }
}
