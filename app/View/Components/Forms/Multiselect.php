<?php

namespace App\View\Components\Forms;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Multiselect extends Component
{
    public readonly string $name;

    public readonly string $label;

    /** @var array<string> */
    public readonly array $options;

    /** @var array<string> */
    public readonly array $selected;

    public readonly bool $required;

    public readonly ?string $extraText;

    /**
     * Create a new component instance.
     */
    public function __construct(
        string $name,
        string $label,
        array $options,
        ?array $selected = null,
        ?bool $required = null,
        ?string $extraText = null,
    ) {
        $this->name = $name;
        $this->label = $label;
        $this->options = $options;
        $this->selected = $selected ?? [];
        $this->required = $required ?? false;
        $this->extraText = $extraText;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.forms.multiselect');
    }
}
