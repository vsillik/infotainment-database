<?php

namespace App\View\Components\ActionButtons;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Delete extends BaseActionButton
{

    public function __construct(
        string $targetUrl,
        ?string $label = null,
    )
    {
        parent::__construct($targetUrl, $label ?? 'Delete');
    }

    public function render(): View|Closure|string
    {
        return view('components.action-buttons.delete');
    }
}
