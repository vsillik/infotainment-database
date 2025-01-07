<?php

namespace App\View\Components\Forms;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Input extends Component
{

    public readonly string $name;

    public readonly string $label;

    public readonly string $defaultValue;

    public readonly bool $required;

    public readonly string $type;

    public readonly ?string $suffixText;

    public readonly ?string $extraText;

    public function __construct(
        string $name,
        string $label,
        ?string $defaultValue = null,
        ?bool $required = null,
        ?string $type = null,
        ?string $suffixText = null,
        ?string $extraText = null,
    )
    {
        $this->name = $name;
        $this->label = $label;
        $this->defaultValue = $defaultValue ?? '';
        $this->required = $required ?? false;
        $this->type = $type ?? 'text';
        $this->suffixText = $suffixText;
        $this->extraText = $extraText;
    }

    public function render(): View|Closure|string
    {
        return view('components.forms.input');
    }
}
