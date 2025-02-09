<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('distributions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('entity_id');
            $table->string('code')->unique()->index();
            $table->date('date')->default(now());
            $table->text('comments')->nullable();
            $table->timestamps();
        });

        Schema::create('distribution_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('distribution_id');
            $table->foreignId('item_id');
            $table->bigInteger('quantity')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('distributions');
        Schema::dropIfExists('distribution_items');
    }
};
