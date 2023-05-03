<?php

namespace App\Repositories\Patient;

use App\Contracts\Repositories\PatientRepositoryContract;
use App\Entities\Patient\Patient;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class PatientRepositoryServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public function register()
    {
        $this->app->singleton(
            PatientRepositoryContract::class,
            fn() => $this->app->make(EntityManagerInterface::class)->getRepository(Patient::class)
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
            PatientRepositoryContract::class,
        ];
    }
}
