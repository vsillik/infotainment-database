<?php

namespace App\View\Components\Forms;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class VendorInput extends Component
{
    public readonly string $name;

    public readonly string $label;

    /** @var array<string> */
    public readonly array $defaultValue;

    public readonly bool $required;

    public readonly int $bytesCount;


    public function __construct(
        string $name,
        string $label,
        array $defaultValue = [],
        ?bool $required = null,
    )
    {
        $this->name = $name;
        $this->label = $label;
        $this->defaultValue = $defaultValue;
        $this->required = $required ?? false;
        $this->bytesCount = count(old($name, $defaultValue));
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.forms.vendor-input');
    }
}
