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
        Schema::create('infotainment_profile_timing_blocks', function (Blueprint $table) {
            $table->id();
            $table->decimal('pixel_clock', 10, 2);
            $table->integer('horizontal_pixels');
            $table->integer('vertical_lines');

            $table->integer('horizontal_blank');
            $table->integer('horizontal_front_porch')->nullable();
            $table->integer('horizontal_sync_width')->nullable();
            $table->integer('horizontal_image_size')->nullable();
            $table->integer('horizontal_border')->nullable();

            $table->integer('vertical_blank');
            $table->integer('vertical_front_porch')->nullable();
            $table->integer('vertical_sync_width')->nullable();
            $table->integer('vertical_image_size')->nullable();
            $table->integer('vertical_border')->nullable();

            $table->boolean('signal_horizontal_sync_positive')->default(false);
            $table->boolean('signal_vertical_sync_positive')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('infotainment_profile_timing_blocks');
    }
};
