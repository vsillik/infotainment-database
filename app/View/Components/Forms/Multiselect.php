<?php

namespace App\View\Components\Forms;

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
     * @param  array<string>  $options
     * @param  array<string>|null  $selected
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

    public function render(): View
    {
        return view('components.forms.multiselect');
    }
}
