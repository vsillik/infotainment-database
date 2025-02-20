<?php

namespace App\View\Components\Forms;

use Illuminate\Contracts\View\View;

class Select extends StandaloneSelect
{
    public readonly string $label;

    public readonly bool $required;

    public readonly ?string $extraText;

    /**
     * @param  array<string>  $options
     */
    public function __construct(
        string $name,
        string $label,
        array $options,
        ?string $defaultValue,
        ?bool $required = null,
        ?string $extraText = null,
    ) {
        parent::__construct($name, $options, $defaultValue);
        $this->label = $label;
        $this->required = $required ?? false;
        $this->extraText = $extraText;
    }

    public function render(): View
    {
        return view('components.forms.select');
    }
}
