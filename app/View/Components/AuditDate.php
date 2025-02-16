<?php

namespace App\View\Components;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Carbon;
use Illuminate\View\Component;

class AuditDate extends Component
{
    public function __construct(
        public readonly ?Carbon $timestamp = null,
        public readonly ?User $by = null,
    ) {}

    public function render(): View
    {
        return view('components.audit-date');
    }
}
