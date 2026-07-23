<?php

namespace App\Http\Responses;

use App\Filament\Pages\CallTakingDashboard;
use App\Filament\Pages\ForensicsDashboard;
use App\Filament\Pages\GeneralDashboard;
use App\Filament\Pages\LogisticsDashboard;
use App\Filament\Pages\MainDashboard;
use App\Filament\Pages\MonitoringDashboard;
use App\Filament\Pages\ReceptionDashboard;
use App\Filament\Pages\TransportDashboard;
use Filament\Auth\Http\Responses\Contracts\LoginResponse as LoginResponseContract;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Livewire\Features\SupportRedirects\Redirector;

class CustomLoginResponse implements LoginResponseContract
{
    public function toResponse($request): RedirectResponse|Redirector
    {
        $user = Auth::user();

        $redirectUrl = match ($user->department->name) {
            'Call-Center' => CallTakingDashboard::getUrl(),
            'Monitoring' => MonitoringDashboard::getUrl(),
            'Analysis &  Intelligence' => GeneralDashboard::getUrl(),
            'Forensics' => ForensicsDashboard::getUrl(),
            'Transport' => TransportDashboard::getUrl(),
            'Estate & Logistics' => LogisticsDashboard::getUrl(),
            'Administration' => MainDashboard::getUrl(),
            'General' => GeneralDashboard::getUrl(),
            'IT' => GeneralDashboard::getUrl(),
            'FrontDesk' => ReceptionDashboard::getUrl(),
            default => GeneralDashboard::getUrl(),
        };

        return redirect()->intended($redirectUrl);
    }
}