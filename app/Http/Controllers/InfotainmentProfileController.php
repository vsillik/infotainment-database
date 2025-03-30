<?php

namespace App\Http\Controllers;

use App\Enums\ColorBitDepth;
use App\Enums\DisplayInterface;
use App\Http\Requests\InfotainmentProfileRequest;
use App\Models\Infotainment;
use App\Models\InfotainmentProfile;
use App\Models\InfotainmentProfileTimingBlock;
use App\Services\Edid\EdidBuilder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * @phpstan-type InfotainmentProfileValidatedValues array{
 *     color_bit_depth: string,
 *     interface: string,
 *     horizontal_size: int,
 *     vertical_size: int,
 *     hw_version: string,
 *     sw_version: string,
 *     vendor_block_1?: array<string>,
 *     vendor_block_2?: array<string>,
 *     vendor_block_3?: array<string>,
 *     pixel_clock: float,
 *     horizontal_pixels: int,
 *     horizontal_blank: int,
 *     horizontal_front_porch?: ?int,
 *     horizontal_sync_width?: ?int,
 *     horizontal_image_size?: ?int,
 *     horizontal_border?: ?int,
 *     vertical_lines: int,
 *     vertical_blank: int,
 *     vertical_front_porch?: ?int,
 *     vertical_sync_width?: ?int,
 *     vertical_image_size?: ?int,
 *     vertical_border?: ?int,
 *     extra_pixel_clock?: ?float,
 *     extra_horizontal_pixels?: ?int,
 *     extra_horizontal_blank?: ?int,
 *     extra_horizontal_front_porch?: ?int,
 *     extra_horizontal_sync_width?: ?int,
 *     extra_horizontal_image_size?: ?int,
 *     extra_horizontal_border?: ?int,
 *     extra_vertical_lines?: ?int,
 *     extra_vertical_blank?: ?int,
 *     extra_vertical_front_porch?: ?int,
 *     extra_vertical_sync_width?: ?int,
 *     extra_vertical_image_size?: ?int,
 *     extra_vertical_border?: ?int,
 * }
 */
class InfotainmentProfileController extends Controller
{
    /**
     * Show form for creating new infotainment profile
     */
    public function create(Infotainment $infotainment): View
    {
        Gate::authorize('create', InfotainmentProfile::class);

        return view('infotainment_profiles.create-or-edit', [
            'breadcrumbs' => [
                route('index') => 'Home',
                route('infotainments.index') => 'Infotainments',
                route('infotainments.show', $infotainment->id) => 'ID: '.$infotainment->id,
                'current' => 'Create profile',
            ],
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
     * Store new infotainment profile
     */
    public function store(InfotainmentProfileRequest $request, Infotainment $infotainment): RedirectResponse
    {
        Gate::authorize('create', InfotainmentProfile::class);

        /** @var InfotainmentProfileValidatedValues $validated */
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
            ->route('infotainments.profiles.edit', [
                'infotainment' => $infotainment->id,
                'profile' => $infotainmentProfile->id,
            ])
            ->with('success', sprintf('Infotainment profile number %d created', $infotainmentProfile->profile_number));
    }

    /**
     * Show specific infotainment profile
     */
    public function show(Infotainment $infotainment, InfotainmentProfile $profile): View
    {
        Gate::authorize('view', $profile);

        return view('infotainment_profiles.create-or-edit', [
            'breadcrumbs' => [
                route('index') => 'Home',
                route('infotainments.index') => 'Infotainments',
                route('infotainments.show', $infotainment->id) => 'ID: '.$infotainment->id,
                'current' => 'Profile number '.$profile->profile_number,
            ],
            'colorBitDepths' => ColorBitDepth::labels(),
            'interfaces' => DisplayInterface::labels(),
            'infotainment' => $infotainment,
            'infotainmentProfile' => $profile,
            'timing' => $profile->timing,
            'extraTiming' => $profile->extraTiming ?? new InfotainmentProfileTimingBlock,
            'mode' => 'show',
        ]);
    }

    /**
     * Show form for editing of the infotainment profile
     */
    public function edit(Infotainment $infotainment, InfotainmentProfile $profile): RedirectResponse|View
    {
        Gate::authorize('update', $profile);

        if ($profile->is_approved) {
            return redirect()
                ->route('infotainments.show', ['infotainment' => $infotainment->id])
                ->with('error', 'Cannot edit approved profile');
        }

        return view('infotainment_profiles.create-or-edit', [
            'breadcrumbs' => [
                route('index') => 'Home',
                route('infotainments.index') => 'Infotainments',
                route('infotainments.show', $infotainment->id) => 'ID: '.$infotainment->id,
                'current' => 'Edit profile number '.$profile->profile_number,
            ],
            'colorBitDepths' => ColorBitDepth::labels(),
            'interfaces' => DisplayInterface::labels(),
            'infotainment' => $infotainment,
            'infotainmentProfile' => $profile,
            'timing' => $profile->timing,
            'extraTiming' => $profile->extraTiming ?? new InfotainmentProfileTimingBlock,
            'mode' => 'edit',
        ]);
    }

    /**
     * Show form for approving infotainment profile
     */
    public function approve(Infotainment $infotainment, InfotainmentProfile $profile): RedirectResponse|View
    {
        Gate::authorize('approve', $profile);

        if ($profile->is_approved) {
            return redirect()
                ->route('infotainments.show', ['infotainment' => $infotainment->id])
                ->with('error', sprintf('Infotainment profile number %d is already approved', $profile->profile_number));
        }

        return view('infotainment_profiles.create-or-edit', [
            'breadcrumbs' => [
                route('index') => 'Home',
                route('infotainments.index') => 'Infotainments',
                route('infotainments.show', $infotainment->id) => 'ID: '.$infotainment->id,
                'current' => 'Approve profile number '.$profile->profile_number,
            ],
            'colorBitDepths' => ColorBitDepth::labels(),
            'interfaces' => DisplayInterface::labels(),
            'infotainment' => $infotainment,
            'infotainmentProfile' => $profile,
            'timing' => $profile->timing,
            'extraTiming' => $profile->extraTiming ?? new InfotainmentProfileTimingBlock,
            'mode' => 'approve',
        ]);
    }

    /**
     * Show form for copying infotainment profile
     */
    public function copy(Infotainment $infotainment, InfotainmentProfile $profile): View
    {
        Gate::authorize('create', $profile);

        return view('infotainment_profiles.create-or-edit', [
            'breadcrumbs' => [
                route('index') => 'Home',
                route('infotainments.index') => 'Infotainments',
                route('infotainments.show', $infotainment->id) => 'ID: '.$infotainment->id,
                'current' => 'Copy profile number '.$profile->profile_number,
            ],
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
     * Update/copy/approve infotainment profile
     */
    public function update(InfotainmentProfileRequest $request, Infotainment $infotainment, InfotainmentProfile $profile): RedirectResponse
    {
        if ($request->has('approving_infotainment_profile')) {
            Gate::authorize('approve', $profile);
        } else {
            Gate::authorize('update', $profile);
        }

        /** @var InfotainmentProfileValidatedValues $validated */
        $validated = $request->validated();

        if ($request->has('approving_infotainment_profile')) {
            if ($profile->is_approved) {
                return redirect()
                    ->route('infotainments.show', ['infotainment' => $infotainment->id])
                    ->with('error', sprintf('Infotainment profile number %d is already approved', $profile->profile_number));
            } else {
                $profile->is_approved = true;
            }
        } elseif ($profile->is_approved) {
            return redirect()
                ->route('infotainments.show', ['infotainment' => $infotainment->id])
                ->with('error', sprintf('Cannot edit approved profile number %d', $profile->profile_number));
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
            $extraTimingBlock = $profile->extraTiming;

            if ($extraTimingBlock !== null) {
                $profile->extraTiming()->dissociate();
                $profile->save(); // extra save for disassociate

                $extraTimingBlock->delete();
            }
        }

        $profile->save();

        if ($request->has('approving_infotainment_profile')) {
            return redirect()
                ->route('infotainments.show', ['infotainment' => $infotainment->id])
                ->with('success', sprintf('Infotainment profile number %d approved', $profile->profile_number));
        }

        return redirect()
            ->route('infotainments.profiles.edit', [
                'infotainment' => $infotainment->id,
                'profile' => $profile->id,
            ])
            ->with('success', sprintf('Infotainment profile number %d updated', $profile->profile_number));
    }

    /**
     * Remove infotainment profile
     */
    public function destroy(Infotainment $infotainment, InfotainmentProfile $profile): RedirectResponse
    {
        Gate::authorize('delete', $profile);

        $profile->delete();
        $profile->timing->delete();
        $profile->extraTiming?->delete();

        return redirect()
            ->route('infotainments.show', $infotainment)
            ->with('success', sprintf('Infotainment profile number %d deleted', $profile->profile_number));
    }

    public function downloadEdid(Infotainment $infotainment, InfotainmentProfile $profile): RedirectResponse|StreamedResponse
    {
        try {
            $bytes = EdidBuilder::build($infotainment, $profile);
        } catch (\InvalidArgumentException $e) {
            return redirect()
                ->route('infotainments.show', $infotainment)
                ->with('error', sprintf('Could not generate EDID file, the infotainment profile %d is invalid: %s.', $profile->profile_number, $e->getMessage()));
        }

        // <manufacturer name>_<part_number>_<width pixels>x<height pixels>_<created date>_<created time>.bin
        $filename = sprintf('%s_%s_%dx%d_%s.bin',
            str_replace(' ', '-', $infotainment->infotainmentManufacturer->name),
            $infotainment->part_number,
            $profile->timing->horizontal_image_size,
            $profile->timing->vertical_image_size,
            $profile->created_at?->format('Ymd_Hi') ?? '00000000_0000',
        );
        $binary = pack('C*', ...$bytes);

        return response()->streamDownload(function () use ($binary) {
            echo $binary;
        }, $filename);
    }

    /**
     * @param  InfotainmentProfileValidatedValues  $validated
     */
    private function setInfotainmentProfileValues(InfotainmentProfile $infotainmentProfile, InfotainmentProfileRequest $request, array $validated): void
    {
        $infotainmentProfile->color_bit_depth = ColorBitDepth::tryFrom($validated['color_bit_depth']) ?? ColorBitDepth::BIT_8;
        $infotainmentProfile->interface = DisplayInterface::tryFrom($validated['interface']) ?? DisplayInterface::HDMI_A;
        $infotainmentProfile->horizontal_size = $validated['horizontal_size'];
        $infotainmentProfile->vertical_size = $validated['vertical_size'];
        $infotainmentProfile->is_ycrcb_4_4_4 = $request->has('is_ycrcb_4_4_4');
        $infotainmentProfile->is_ycrcb_4_2_2 = $request->has('is_ycrcb_4_2_2');
        $infotainmentProfile->is_srgb = $request->has('is_srgb');
        $infotainmentProfile->is_continuous_frequency = $request->has('is_continuous_frequency');
        $infotainmentProfile->hw_version = str_pad($validated['hw_version'], 3, '0', STR_PAD_LEFT);
        $infotainmentProfile->sw_version = str_pad($validated['sw_version'], 4, '0', STR_PAD_LEFT);
        $infotainmentProfile->vendor_block_1 = $this->processVendorBlockInput($validated, 'vendor_block_1');
        $infotainmentProfile->vendor_block_2 = $this->processVendorBlockInput($validated, 'vendor_block_2');
        $infotainmentProfile->vendor_block_3 = $this->processVendorBlockInput($validated, 'vendor_block_3');
    }

    /**
     * @param  InfotainmentProfileValidatedValues  $validated
     * @return array<string>
     */
    private function processVendorBlockInput(array $validated, string $inputName): array
    {
        if (! array_key_exists($inputName, $validated) || ! is_array($validated[$inputName])) {
            return [];
        }

        return array_map(fn (string $value): string => str_pad($value, 2, '0', STR_PAD_LEFT), $validated[$inputName]);
    }

    /**
     * @param  InfotainmentProfileValidatedValues  $validated
     */
    private function setTimingBlockValues(InfotainmentProfileTimingBlock $timingBlock, InfotainmentProfileRequest $request, array $validated, bool $isExtra): void
    {
        $prefix = $isExtra ? 'extra_' : '';

        $timingBlock->pixel_clock = $validated[$prefix.'pixel_clock'] ?? 0;

        $timingBlock->horizontal_pixels = $validated[$prefix.'horizontal_pixels'] ?? 0;
        $timingBlock->horizontal_blank = $validated[$prefix.'horizontal_blank'] ?? 0;
        $timingBlock->horizontal_front_porch = $validated[$prefix.'horizontal_front_porch'] ?? null;
        $timingBlock->horizontal_sync_width = $validated[$prefix.'horizontal_sync_width'] ?? null;
        $timingBlock->horizontal_image_size = $validated[$prefix.'horizontal_image_size'] ?? null;
        $timingBlock->horizontal_border = $validated[$prefix.'horizontal_border'] ?? null;

        $timingBlock->vertical_lines = $validated[$prefix.'vertical_lines'] ?? 0;
        $timingBlock->vertical_blank = $validated[$prefix.'vertical_blank'] ?? 0;
        $timingBlock->vertical_front_porch = $validated[$prefix.'vertical_front_porch'] ?? null;
        $timingBlock->vertical_sync_width = $validated[$prefix.'vertical_sync_width'] ?? null;
        $timingBlock->vertical_image_size = $validated[$prefix.'vertical_image_size'] ?? null;
        $timingBlock->vertical_border = $validated[$prefix.'vertical_border'] ?? null;

        $timingBlock->signal_horizontal_sync_positive = $request->has($prefix.'signal_horizontal_sync_positive');
        $timingBlock->signal_vertical_sync_positive = $request->has($prefix.'signal_vertical_sync_positive');
    }
}
