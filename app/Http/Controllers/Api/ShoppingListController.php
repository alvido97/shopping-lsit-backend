<?php

namespace App\Http\Controllers\Api;

use App\Actions\ListShoppingListsAction;
use App\Actions\StoreShoppingListAction;
use App\Actions\StoreShoppingListItemsAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\ShoppingListRequest;
use App\Models\ShoppingList;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class ShoppingListController extends Controller
{
    public function index(
        ListShoppingListsAction $listShoppingListsAction
    )
    {
        return response()->json([
            'status' => true,
            'message' => 'Successfully fetch the shopping lists',
            'shoppingLists' => $listShoppingListsAction->execute()
        ]);
    }
    public function store(
        ShoppingListRequest $shoppingListRequest,
        StoreShoppingListAction $storeShoppingListAction,
        StoreShoppingListItemsAction $storeShoppingListItemsAction
    ): JsonResponse
    {
        try {
            DB::beginTransaction();

            $shoppingList = $storeShoppingListAction->execute($shoppingListRequest->title);

            $storeShoppingListItemsAction->execute($shoppingListRequest->items, $shoppingList);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Successfully saved the shopping list'
            ]);

        }  catch (Throwable $e) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => $e
            ]);
        }
    }

    public function update(
        ShoppingListRequest $shoppingListRequest,
        StoreShoppingListAction $storeShoppingListAction,
        StoreShoppingListItemsAction $storeShoppingListItemsAction
    ): JsonResponse
    {
        try {
            DB::beginTransaction();

            $shoppingList = $storeShoppingListAction->execute($shoppingListRequest->title, ShoppingList::where('id', $shoppingListRequest->id)->first());

            $storeShoppingListItemsAction->execute($shoppingListRequest->items, $shoppingList);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Successfully saved the shopping list'
            ]);

        }  catch (Throwable $e) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => $e
            ]);
        }
    }

    public function destroy(
        Request $request
    ): JsonResponse
    {
        $shoppingList = ShoppingList::query()->where('id', $request->shoppingListId)->first();
        $shoppingList->delete();

        return response()->json([
            'status' => true,
            'message' => 'Successfully deleted the shopping list'
        ]);
    }

    public function show(
        Request $request
    ): JsonResponse
    {
        $shoppingList = ShoppingList::query()->where('id', $request->shoppingList)->first();

        return response()->json([
            'status' => true,
            'message' => 'Successfully fetch the shopping list',
            'shoppingList' => [
                'id' => $shoppingList->id,
                'title' => $shoppingList->title,
                'items' =>  $shoppingList->items->map(function ($item){
                    return [
                        'title' => $item->title,
                        'quantity' => $item->quantity,
                        'unit' => $item->unit,
                    ];
                }),
            ],
        ]);
    }
}
