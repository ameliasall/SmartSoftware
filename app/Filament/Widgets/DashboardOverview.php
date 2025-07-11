<?php

namespace App\Filament\Widgets;

use App\Models\User;
use App\Services\ApiService;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DashboardOverview extends BaseWidget
{
    // protected int|string|array $columnSpan = 15;
    protected function getStats(): array
    {
        $apiService = new ApiService();
        $customers = collect(
            value: $apiService->get(
                endpoint: '/c',
                authToken: auth()->user()->auth_token,
            )->json()
        );
        $active_customers = $customers->where('aktif', '1')->count();
        $inactive_customers = $customers->where('aktif', '0')->count();

        return [
            Stat::make('Total Customer', $customers->count())
                ->description('Jumlah total customer terdaftar')
                ->color('primary')
                ->icon('heroicon-o-users'),
            Stat::make('Customer Aktif', $active_customers)
                ->color('success')
                ->description('Jumlah customer yang aktif')
                ->icon('heroicon-o-check-circle'),
            Stat::make('Customer Non Aktif', $inactive_customers)
                ->color('danger')
                ->description('Jumlah customer yang tidak aktif')
                ->icon('heroicon-o-x-circle'),
        ];
    }
}
