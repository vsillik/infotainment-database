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
            $table->decimal('pixel_clock', 5, 2);

            $table->smallInteger('horizontal_pixels')->unsigned();
            $table->smallInteger('horizontal_blank')->unsigned();
            $table->smallInteger('horizontal_front_porch')->unsigned();
            $table->smallInteger('horizontal_sync_width')->unsigned();
            $table->smallInteger('horizontal_image_size')->unsigned();
            $table->tinyInteger('horizontal_border')->unsigned()->nullable();

            $table->smallInteger('vertical_lines')->unsigned();
            $table->smallInteger('vertical_blank')->unsigned();
            $table->tinyInteger('vertical_front_porch')->unsigned();
            $table->tinyInteger('vertical_sync_width')->unsigned();
            $table->smallInteger('vertical_image_size')->unsigned();
            $table->tinyInteger('vertical_border')->unsigned()->nullable();

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
