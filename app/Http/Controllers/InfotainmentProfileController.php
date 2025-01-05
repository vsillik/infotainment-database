<?php

namespace App\Http\Controllers;

use App\ColorBitDepth;
use App\DisplayInterface;
use App\Http\Requests\InfotainmentProfileRequest;
use App\Models\Infotainment;
use App\Models\InfotainmentProfile;
use App\Models\InfotainmentProfileTimingBlock;
use Illuminate\Support\Facades\Gate;

class InfotainmentProfileController extends Controller
{

    /**
     * Show the form for creating a new resource.
     */
    public function create(Infotainment $infotainment)
    {
        Gate::authorize('create', InfotainmentProfile::class);

        return view('infotainment_profiles.create-or-edit', [
            'colorBitDepths' => ColorBitDepth::labels(),
            'interfaces' => DisplayInterface::labels(),
            'infotainment' => $infotainment,
            'infotainmentProfile' => new InfotainmentProfile,
            'timing' => new InfotainmentProfileTimingBlock,
            'extraTiming' => new InfotainmentProfileTimingBlock,
            'mode' => 'create',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(InfotainmentProfileRequest $request, Infotainment $infotainment)
    {
        Gate::authorize('create', InfotainmentProfile::class);

        $validated = $request->validated();

        $infotainmentProfile = new InfotainmentProfile;

        $infotainmentProfile->infotainment()->associate($infotainment);

        $infotainmentProfile->is_approved = false;

        $this->setInfotainmentProfileValues($infotainmentProfile, $request, $validated);

        $timingBlock = new InfotainmentProfileTimingBlock;
        $this->setTimingBlockValues($timingBlock, $request, $validated, false);

        $timingBlock->save();
        $infotainmentProfile->timing()->associate($timingBlock);

        if ($request->has('extra_timing_block')) {
            $extraTimingBlock = new InfotainmentProfileTimingBlock;
            $this->setTimingBlockValues($extraTimingBlock, $request, $validated, true);

            $extraTimingBlock->save();
            $infotainmentProfile->extraTiming()->associate($extraTimingBlock);
        }

        $infotainmentProfile->save();

        return redirect()
            ->route('infotainments.show', ['infotainment' => $infotainment->id])
            ->with('success', 'Infotainment profile created');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Infotainment $infotainment, InfotainmentProfile $profile)
    {
        Gate::authorize('update', $profile);

        if ($profile->is_approved) {
            return redirect()
                ->route('infotainments.show', ['infotainment' => $infotainment->id])
                ->with('error', 'Cannot edit approved profile');
        }

        return view('infotainment_profiles.create-or-edit', [
            'colorBitDepths' => ColorBitDepth::labels(),
            'interfaces' => DisplayInterface::labels(),
            'infotainment' => $infotainment,
            'infotainmentProfile' => $profile,
            'timing' => $profile->timing,
            'extraTiming' => $profile->extraTiming ?? new InfotainmentProfileTimingBlock,
            'mode' => 'edit',
        ]);
    }

    public function approve(Infotainment $infotainment, InfotainmentProfile $profile)
    {
        Gate::authorize('approve', $profile);

        if ($profile->is_approved) {
            return redirect()
                ->route('infotainments.show', ['infotainment' => $infotainment->id])
                ->with('error', 'Infotainment profile is already approved');
        }

        return view('infotainment_profiles.create-or-edit', [
            'colorBitDepths' => ColorBitDepth::labels(),
            'interfaces' => DisplayInterface::labels(),
            'infotainment' => $infotainment,
            'infotainmentProfile' => $profile,
            'timing' => $profile->timing,
            'extraTiming' => $profile->extraTiming ?? new InfotainmentProfileTimingBlock,
            'mode' => 'approve',
        ]);
    }

    public function copy(Infotainment $infotainment, InfotainmentProfile $profile)
    {
        Gate::authorize('create', $profile);

        return view('infotainment_profiles.create-or-edit', [
            'colorBitDepths' => ColorBitDepth::labels(),
            'interfaces' => DisplayInterface::labels(),
            'infotainment' => $infotainment,
            'infotainmentProfile' => $profile,
            'timing' => $profile->timing,
            'extraTiming' => $profile->extraTiming ?? new InfotainmentProfileTimingBlock,
            'mode' => 'copy',
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(InfotainmentProfileRequest $request, Infotainment $infotainment, InfotainmentProfile $profile)
    {
        if ($request->has('approving_infotainment_profile')) {
            Gate::authorize('approve', $profile);
        } else {
            Gate::authorize('update', $profile);
        }

        $successMessage = 'Infotainment profile updated';
        $validated = $request->validated();

        if ($request->has('approving_infotainment_profile')) {
            if ($profile->is_approved) {
                return redirect()
                    ->route('infotainments.show', ['infotainment' => $infotainment->id])
                    ->with('error', 'Infotainment profile is already approved');
            } else {
                $profile->is_approved = true;
                $successMessage = 'Infotainment profile approved';
            }
        } else if ($profile->is_approved) {
            return redirect()
                ->route('infotainments.show', ['infotainment' => $infotainment->id])
                ->with('error', 'Cannot edit approved profile');
        }

        $this->setInfotainmentProfileValues($profile, $request, $validated);

        $timingBlock = $profile->timing;
        $this->setTimingBlockValues($timingBlock, $request, $validated, false);
        $timingBlock->save();

        if ($request->has('extra_timing_block')) {
            $extraTimingBlock = $profile->extraTiming ?? new InfotainmentProfileTimingBlock;
            $this->setTimingBlockValues($extraTimingBlock, $request, $validated, true);

            $extraTimingBlock->save();
            $profile->extraTiming()->associate($extraTimingBlock);
        } else {
            $profile->extraTiming()->dissociate();
            $profile->extraTiming?->delete();
        }

        $profile->save();

        return redirect()
            ->route('infotainments.show', ['infotainment' => $infotainment->id])
            ->with('success', $successMessage);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Infotainment $infotainment, InfotainmentProfile $profile)
    {
        Gate::authorize('delete', $profile);

        $profile->delete();
        $profile->timing->delete();
        $profile->extraTiming?->delete();

        return redirect()
            ->route('infotainments.show', $infotainment)
            ->with('success', 'Infotainment profile deleted');
    }

    private function setInfotainmentProfileValues(InfotainmentProfile $infotainmentProfile, InfotainmentProfileRequest $request, mixed $validated): void
    {
        $infotainmentProfile->color_bit_depth = $validated['color_bit_depth'];
        $infotainmentProfile->interface = $validated['interface'];
        $infotainmentProfile->horizontal_size = $validated['horizontal_size'];
        $infotainmentProfile->vertical_size = $validated['vertical_size'];
        $infotainmentProfile->is_ycrcb_4_4_4 = $request->has('is_ycrcb_4_4_4');
        $infotainmentProfile->is_ycrcb_4_2_2 = $request->has('is_ycrcb_4_2_2');
        $infotainmentProfile->is_srgb = $request->has('is_srgb');
        $infotainmentProfile->is_continuous_frequency = $request->has('is_continuous_frequency');
        $infotainmentProfile->hw_version = $validated['hw_version'];
        $infotainmentProfile->sw_version = $validated['sw_version'];
        $infotainmentProfile->vendor_block_1 = $validated['vendor_block_1'];
        $infotainmentProfile->vendor_block_2 = $validated['vendor_block_2'];
        $infotainmentProfile->vendor_block_3 = $validated['vendor_block_3'];
    }

    private function setTimingBlockValues(InfotainmentProfileTimingBlock $timingBlock, InfotainmentProfileRequest $request, mixed $validated, bool $isExtra): void
    {
        $prefix = $isExtra ? 'extra_' : '';

        $timingBlock->pixel_clock = $validated[$prefix.'pixel_clock'];
        $timingBlock->horizontal_pixels = $validated[$prefix.'horizontal_pixels'];
        $timingBlock->vertical_lines = $validated[$prefix.'vertical_lines'];
        $timingBlock->horizontal_blank = $validated[$prefix.'horizontal_blank'];
        $timingBlock->horizontal_front_porch = $validated[$prefix.'horizontal_front_porch'];
        $timingBlock->horizontal_sync_width = $validated[$prefix.'horizontal_sync_width'];
        $timingBlock->horizontal_image_size = $validated[$prefix.'horizontal_image_size'];
        $timingBlock->horizontal_border = $validated[$prefix.'horizontal_border'];
        $timingBlock->vertical_blank = $validated[$prefix.'vertical_blank'];
        $timingBlock->vertical_front_porch = $validated[$prefix.'vertical_front_porch'];
        $timingBlock->vertical_sync_width = $validated[$prefix.'vertical_sync_width'];
        $timingBlock->vertical_image_size = $validated[$prefix.'vertical_image_size'];
        $timingBlock->vertical_border = $validated[$prefix.'vertical_border'];
        $timingBlock->signal_horizontal_sync_positive = $request->has($prefix.'signal_horizontal_sync_positive');
        $timingBlock->signal_vertical_sync_positive = $request->has($prefix.'signal_vertical_sync_positive');
    }
}
