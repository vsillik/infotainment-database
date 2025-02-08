<?php

namespace App\View\Components\ActionButtons;

use Closure;
use Illuminate\Contracts\View\View;

class Delete extends BaseActionButton
{
    public readonly string $confirmSubject;

    public function __construct(
        string $targetUrl,
        string $confirmSubject,
        ?string $label = null,
    ) {
        parent::__construct($targetUrl, $label ?? 'Delete');

        $this->confirmSubject = $confirmSubject;
    }

    public function render(): View|Closure|string
    {
        return view('components.action-buttons.delete');
    }
}
