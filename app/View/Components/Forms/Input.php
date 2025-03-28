<?php

namespace App\View\Components\Forms;

use Closure;
use Illuminate\Contracts\View\View;

class Input extends StandaloneInput
{
    public readonly string $label;

    public readonly bool $required;

    public readonly ?string $extraText;

    public function __construct(
        string $name,
        string $label,
        ?string $defaultValue = null,
        ?bool $required = null,
        ?string $type = null,
        ?string $suffixText = null,
        ?string $extraText = null,
        ?bool $isDisabled = false
    ) {
        parent::__construct($name, $defaultValue, $type, $suffixText, $isDisabled);
        $this->label = $label;
        $this->required = $required ?? false;
        $this->extraText = $extraText;
    }

    public function render(): View|Closure|string
    {
        return view('components.forms.input');
    }
}
