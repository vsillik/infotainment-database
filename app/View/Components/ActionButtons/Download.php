<?php

namespace App\View\Components\ActionButtons;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Download extends BaseActionButton
{
    public function __construct(
        string $targetUrl,
        ?string $label = null,
    ) {
        parent::__construct($targetUrl, $label ?? 'Download');
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.action-buttons.download');
    }
}
