<?php

namespace App\View\Components\Forms;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Select extends Component
{
    public readonly string $name;

    public readonly string $label;

    /** @var array<string> */
    public readonly array $options;

    public readonly string $defaultValue;

    public readonly bool $required;

    public readonly ?string $extraText;

    public function __construct(
        string $name,
        string $label,
        array $options,
        ?string $defaultValue,
        ?bool $required = null,
        ?string $extraText = null,
    )
    {
        $this->name = $name;
        $this->label = $label;
        $this->options = $options;
        $this->defaultValue = $defaultValue ?? '';
        $this->required = $required ?? false;
        $this->extraText = $extraText;
    }

    public function render(): View|Closure|string
    {
        return view('components.forms.select');
    }
}
