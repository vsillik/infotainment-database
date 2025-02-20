<?php

namespace App\View\Components\Forms;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Radio extends Component
{
    public readonly string $name;

    public readonly string $label;

    public readonly string $value;

    public readonly bool $isCheckedByDefault;

    public function __construct(
        string $name,
        string $label,
        string $value,
        bool $isCheckedByDefault = false
    ) {
        $this->name = $name;
        $this->label = $label;
        $this->value = $value;
        $this->isCheckedByDefault = $isCheckedByDefault;
    }

    public function render(): View
    {
        return view('components.forms.radio');
    }
}
