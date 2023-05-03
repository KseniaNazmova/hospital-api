<?php

namespace App\Repositories\Appointment;

use App\Contracts\Repositories\AppointmentRepositoryContract;
use App\Entities\Appointment\Appointment;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class AppointmentRepositoryServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public function register()
    {
        $this->app->singleton(
            AppointmentRepositoryContract::class,
            fn() => $this->app->make(EntityManagerInterface::class)->getRepository(Appointment::class)
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
            AppointmentRepositoryContract::class,
        ];
    }
}
