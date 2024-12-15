<?php

namespace App\Http\Controllers;

use App\ColorBitDepth;
use App\DisplayInterface;
use App\Http\Requests\InfotainmentProfileRequest;
use App\Models\Infotainment;
use App\Models\InfotainmentProfile;
use App\Models\InfotainmentProfileTimingBlock;

class InfotainmentProfileController extends Controller
{

    /**
     * Show the form for creating a new resource.
     */
    public function create(Infotainment $infotainment)
    {
       return view('infotainment_profiles.create-or-edit', [
           'colorBitDepths' => ColorBitDepth::labels(),
           'interfaces' => DisplayInterface::labels(),
           'infotainment' => $infotainment,
           'infotainmentProfile' => new InfotainmentProfile,
           'timing' => new InfotainmentProfileTimingBlock
       ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(InfotainmentProfileRequest $request, Infotainment $infotainment)
    {
        $validated = $request->validated();

        $infotainmentProfile = new InfotainmentProfile;

        $infotainmentProfile->infotainment()->associate($infotainment);

        $infotainmentProfile->is_approved = false;

        $this->setInfotainmentProfileValues($infotainmentProfile, $request, $validated);

        $timingBlock = new InfotainmentProfileTimingBlock;

        $this->setTimingBlockValues($timingBlock, $request, $validated);

        $timingBlock->save();

        $infotainmentProfile->timing()->associate($timingBlock);
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
        return view('infotainment_profiles.create-or-edit', [
            'colorBitDepths' => ColorBitDepth::labels(),
            'interfaces' => DisplayInterface::labels(),
            'infotainment' => $infotainment,
            'infotainmentProfile' => $profile,
            'timing' => $profile->timing
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(InfotainmentProfileRequest $request, Infotainment $infotainment, InfotainmentProfile $profile)
    {
        $validated = $request->validated();

        $this->setInfotainmentProfileValues($profile, $request, $validated);
        $profile->save();

        $timingBlock = $profile->timing;
        $this->setTimingBlockValues($timingBlock, $request, $validated);
        $timingBlock->save();

        return redirect()
            ->route('infotainments.show', ['infotainment' => $infotainment->id])
            ->with('success', 'Infotainment profile updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Infotainment $infotainment, InfotainmentProfile $profile)
    {
        $profile->delete();
        $profile->timing->delete();

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

    private function setTimingBlockValues(InfotainmentProfileTimingBlock $timingBlock, InfotainmentProfileRequest $request, mixed $validated): void
    {
        $timingBlock->pixel_clock = $validated['pixel_clock'];
        $timingBlock->horizontal_pixels = $validated['horizontal_pixels'];
        $timingBlock->vertical_lines = $validated['vertical_lines'];
        $timingBlock->horizontal_blank = $validated['horizontal_blank'];
        $timingBlock->horizontal_front_porch = $validated['horizontal_front_porch'];
        $timingBlock->horizontal_sync_width = $validated['horizontal_sync_width'];
        $timingBlock->horizontal_image_size = $validated['horizontal_image_size'];
        $timingBlock->horizontal_border = $validated['horizontal_border'];
        $timingBlock->vertical_blank = $validated['vertical_blank'];
        $timingBlock->vertical_front_porch = $validated['vertical_front_porch'];
        $timingBlock->vertical_sync_width = $validated['vertical_sync_width'];
        $timingBlock->vertical_image_size = $validated['vertical_image_size'];
        $timingBlock->vertical_border = $validated['vertical_border'];
        $timingBlock->signal_horizontal_sync_positive = $request->has('signal_horizontal_sync_positive');
        $timingBlock->signal_vertical_sync_positive = $request->has('signal_vertical_sync_positive');
    }
}
