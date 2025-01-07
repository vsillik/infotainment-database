<?php

namespace App\View\Components\Forms;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Checkbox extends Component
{
    public readonly string $name;

    public readonly string $label;

    public readonly bool $isCheckedByDefault;

    public readonly string $value;

    public readonly bool $required;

    public readonly ?string $extraText;

    public function __construct(
        string $name,
        string $label,
        ?bool $isCheckedByDefault = null,
        ?string $value = null,
        ?bool $required = null,
        ?string $extraText = null,
    )
    {
        $this->name = $name;
        $this->label = $label;
        $this->isCheckedByDefault = $isCheckedByDefault ?? false;
        $this->value = $value ?? '1';
        $this->required = $required ?? false;
        $this->extraText = $extraText;
    }

    public function render(): View|Closure|string
    {
        return view('components.forms.checkbox');
    }
}
