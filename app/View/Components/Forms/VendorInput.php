<?php

namespace App\View\Components\Forms;

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

    /**
     * @param  array<string>  $defaultValue
     */
    public function __construct(
        string $name,
        string $label,
        array $defaultValue = [],
        ?bool $required = null,
    ) {
        $this->name = $name;
        $this->label = $label;
        $this->defaultValue = $defaultValue;
        $this->required = $required ?? false;
        $this->bytesCount = count(old($name, $defaultValue));
    }

    public function render(): View
    {
        return view('components.forms.vendor-input');
    }
}
