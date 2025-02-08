<?php

namespace App\View\Components\Forms;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class StandaloneCheckbox extends Component
{
    public readonly string $name;

    public readonly bool $isCheckedByDefault;

    public readonly string $value;

    public function __construct(
        string $name,
        ?bool $isCheckedByDefault = null,
        ?string $value = null,
    ) {
        $this->name = $name;
        $this->isCheckedByDefault = $isCheckedByDefault ?? false;
        $this->value = $value ?? '1';
    }

    public function render(): View
    {
        return view('components.forms.standalone-checkbox');
    }
}
