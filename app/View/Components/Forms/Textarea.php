<?php

namespace App\View\Components\Forms;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Textarea extends Component
{
    public readonly string $name;

    public readonly string $label;

    public readonly string $defaultValue;

    public readonly bool $required;

    public readonly ?string $extraText;

    public readonly bool $isDisabled;

    public function __construct(
        string $name,
        string $label,
        ?string $defaultValue = null,
        ?bool $required = null,
        ?string $extraText = null,
        ?bool $isDisabled = false
    ) {
        $this->name = $name;
        $this->label = $label;
        $this->defaultValue = $defaultValue ?? '';
        $this->required = $required ?? false;
        $this->extraText = $extraText;
        $this->isDisabled = $isDisabled ?? false;
    }

    public function render(): View|Closure|string
    {
        return view('components.forms.textarea');
    }
}
