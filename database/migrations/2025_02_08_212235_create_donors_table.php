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
        Schema::create('donors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('donor_id')->index();
            $table->string('code')->unique()->index();
            $table->date('date');
            $table->text('comments')->nullable();
            $table->timestamps();
        });

        Schema::create('donation_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('donation_id');
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
        Schema::dropIfExists('donors');
        Schema::dropIfExists('donations');
        Schema::dropIfExists('donation_items');
    }
};
