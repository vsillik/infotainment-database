<?php

namespace App\View\Components\Forms;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class StandaloneSelect extends Component
{
    public readonly string $name;

    /** @var array<string> */
    public readonly array $options;

    public readonly string $defaultValue;

    /**
     * @param  array<string>  $options
     */
    public function __construct(
        string $name,
        array $options,
        ?string $defaultValue,
    ) {
        $this->name = $name;
        $this->options = $options;
        $this->defaultValue = $defaultValue ?? '';
    }

    public function render(): View
    {
        return view('components.forms.standalone-select');
    }
}
