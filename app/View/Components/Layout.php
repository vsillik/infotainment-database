<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Layout extends Component
{
    /**
     * @var array<string, string>
     */
    public readonly array $breadcrumbs;

    /**
     * @param  ?array<string, string>  $breadcrumbs
     */
    public function __construct(
        ?array $breadcrumbs = null
    ) {
        $this->breadcrumbs = $breadcrumbs ?? [];
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.layout');
    }
}
