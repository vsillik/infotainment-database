<?php

namespace App\View\Components\ActionButtons;

use Closure;
use Illuminate\Contracts\View\View;

class Approve extends BaseActionButton
{
    public function __construct(
        string $targetUrl,
        ?string $label = null
    ) {
        parent::__construct($targetUrl, $label ?? 'Approve');
    }

    public function render(): View|Closure|string
    {
        return view('components.action-buttons.approve');
    }
}
