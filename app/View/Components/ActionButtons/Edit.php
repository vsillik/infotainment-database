<?php

namespace App\View\Components\ActionButtons;

use Closure;
use Illuminate\Contracts\View\View;

class Edit extends BaseActionButton
{
    public function __construct(
        string $targetUrl,
        ?string $label = null,
    ) {
        parent::__construct($targetUrl, $label ?? 'Edit');
    }

    public function render(): View|Closure|string
    {
        return view('components.action-buttons.edit');
    }
}
