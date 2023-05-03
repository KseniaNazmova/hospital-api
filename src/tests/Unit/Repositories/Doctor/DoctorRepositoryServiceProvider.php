<?php

namespace Tests\Unit\Repositories\Doctor;

use App\Contracts\Repositories\DoctorRepositoryContract;
use App\Entities\Doctor\Doctor;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class DoctorRepositoryServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public function register()
    {
        $this->app->singleton(
            DoctorRepositoryContract::class,
            fn() => $this->app->make(EntityManagerInterface::class)->getRepository(Doctor::class)
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
            DoctorRepositoryContract::class,
        ];
    }
}
