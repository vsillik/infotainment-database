<?php

declare(strict_types=1);

namespace App\View\Components\ActionButtons;

use Illuminate\View\Component;

abstract class BaseActionButton extends Component
{
    public readonly string $targetUrl;

    public readonly string $label;

    public function __construct(
        string $targetUrl,
        string $label,
    ) {
        $this->targetUrl = $targetUrl;
        $this->label = $label;
    }
}
