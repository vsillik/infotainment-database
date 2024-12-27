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

    public readonly ?int $minLength;

    public readonly ?int $maxLength;

    public function __construct(
        string $name,
        string $label,
        ?string $defaultValue = null,
        ?bool $required = null,
        ?int $minLength = null,
        ?int $maxLength = null,
    )
    {
        $this->name = $name;
        $this->label = $label;
        $this->defaultValue = $defaultValue ?? '';
        $this->required = $required ?? false;
        $this->minLength = $minLength;
        $this->maxLength = $maxLength;
    }

    public function render(): View|Closure|string
    {
        return view('components.forms.textarea');
    }
}
