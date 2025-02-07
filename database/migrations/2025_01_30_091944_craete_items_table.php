<?php

use App\Models\ShoppingList;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->decimal('quantity');
            $table->enum('unit', ['l', 'ml', 'g', 'kg', 'pieces']);
            $table->foreignIdFor(ShoppingList::class, 'shopping_list_id')->constrained('shopping_lists')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
