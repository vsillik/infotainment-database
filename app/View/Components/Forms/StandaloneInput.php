<?php

namespace App\View\Components\Forms;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class StandaloneInput extends Component
{
    public readonly string $name;

    public readonly string $defaultValue;

    public readonly string $type;

    public readonly ?string $suffixText;

    public readonly bool $isDisabled;

    public function __construct(
        string $name,
        ?string $defaultValue = null,
        ?string $type = null,
        ?string $suffixText = null,
        ?bool $isDisabled = false
    ) {
        $this->name = $name;
        $this->defaultValue = $defaultValue ?? '';
        $this->type = $type ?? 'text';
        $this->suffixText = $suffixText;
        $this->isDisabled = $isDisabled ?? false;
    }

    public function render(): View|Closure|string
    {
        return view('components.forms.standalone-input');
    }
}
