<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ShortenText extends Component
{
    public readonly int $maxLength;

    public function __construct(
        public readonly string $text,
        ?int $maxLength = null,
    ) {
        $this->maxLength = $maxLength ?? 25;
    }

    public function render(): View|Closure|string
    {
        return view('components.shorten-text');
    }
}
