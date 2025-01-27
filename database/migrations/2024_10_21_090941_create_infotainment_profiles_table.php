<?php

use App\DisplayInterface;
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
        Schema::create('infotainment_profiles', function (Blueprint $table) {
            $table->id();

            $table->foreignId('infotainment_id')
                ->constrained('infotainments')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('timing_block_id')
                ->constrained('infotainment_profile_timing_blocks')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('extra_timing_block_id')
                ->nullable()
                ->constrained('infotainment_profile_timing_blocks')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->boolean('is_approved')->default(false);

            $table->tinyInteger('color_bit_depth')->unsigned();

            $table->enum('interface', array_map(
                fn (DisplayInterface $displayInterface) => $displayInterface->value,
                DisplayInterface::cases())
            );

            $table->tinyInteger('horizontal_size')->unsigned();

            $table->tinyInteger('vertical_size')->unsigned();

            $table->boolean('is_ycrcb_4_4_4');

            $table->boolean('is_ycrcb_4_2_2');

            $table->boolean('is_srgb');

            $table->boolean('is_continuous_frequency');

            $table->char('hw_version', 3);

            $table->char('sw_version', 4);

            $table->binary('vendor_block_1', 28)->nullable();

            $table->binary('vendor_block_2', 28)->nullable();

            $table->binary('vendor_block_3', 28)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('infotainment_profiles');
    }
};
