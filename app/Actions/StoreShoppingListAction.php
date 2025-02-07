<?php

namespace App\Actions;

use App\Models\ShoppingList;
use Illuminate\Support\Facades\Auth;

class StoreShoppingListAction
{
    public function execute(
        string $title,
        ShoppingList $shoppingList = new ShoppingList()
    ): ShoppingList
    {
        $shoppingList->forceFill([
            'title' => $title,
            'created_by' => Auth::user()->id,
            'slug' => $this->generateSlug($title),
        ]);

        $shoppingList->save();

        return $shoppingList;
    }

    function generateSlug($text): string
    {
        $text = preg_replace('/[^a-zA-Z0-9]/', ' ', $text);

        $text = preg_replace('/\s+/', ' ', $text);

        $text = strtolower($text);

        $text = trim($text);

        return str_replace(' ', '-', $text);
    }
}
