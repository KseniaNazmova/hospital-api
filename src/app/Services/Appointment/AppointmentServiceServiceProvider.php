<?php

namespace App\Services\Appointment;

use app\Contracts\Services\AppointmentServiceContract;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class AppointmentServiceServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public function register()
    {
        $this->app->singleton(
            AppointmentServiceContract::class,
            AppointmentService::class,
        );
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides(): array
    {
        return [
            AppointmentServiceContract::class,
        ];
    }
}
