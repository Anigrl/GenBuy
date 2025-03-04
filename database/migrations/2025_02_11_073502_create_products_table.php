<?php

use App\Models\Category;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Category::class)->constrained() ->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('name');
            $table->decimal('price', 10, 2); // Original Price
            $table->decimal('sale_price', 10, 2)->nullable(); // Discounted Price
            $table->string('image')->nullable(); // Image Path
            $table->integer('stock')->default(0); // Stock Quantity
            $table->text('description')->nullable(); // Description
            
            $table->timestamps();
        });

 
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
