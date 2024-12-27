<?php

namespace App\View\Components\Forms;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\ViewErrorBag;
use Illuminate\View\Component;

class ErrorsAlert extends Component
{

    public function __construct(
        public readonly ViewErrorBag $errors,
    ) {}

    public function render(): View|Closure|string
    {
        return view('components.forms.errors-alert');
    }
}
