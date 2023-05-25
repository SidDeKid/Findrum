<?php

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
        // Schema::create('components', function (Blueprint $table) {
        //     $table->id();
        //     $table->foreignId('brand_id')
        //         ->constrained()
        //         ->onUpdate('cascade')
        //         ->onDelete('cascade');
        //     $table->string("name", 100);
        //     $table->float("diameter", 4, 1); // In inches.
        //     $table->timestamps();
        // });
        Schema::create('components', function (Blueprint $table) {
            $table->id();
            $table->foreignId('brand_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('drummer_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string("name", 100);
            $table->float("diameter", 4, 1); // In inches.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('components');
    }
};
