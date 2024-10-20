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
        Schema::create('infotainments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('infotainment_manufacturer_id')
                ->constrained('infotainment_manufacturers')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->char('serializer_manufacturer_id', 3);
            $table->foreign('serializer_manufacturer_id')
                ->references('id')
                ->on('serializer_manufacturers')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->char('product_id', 4);

            $table->integer('model_year');

            $table->string('part_number', 13);

            $table->string('compatible_platforms')->nullable();

            $table->string('internal_code', 150)->nullable();

            $table->string('internal_notes')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('infotainments');
    }
};