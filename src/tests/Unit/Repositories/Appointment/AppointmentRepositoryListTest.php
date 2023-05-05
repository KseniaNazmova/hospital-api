<?php

namespace tests\Unit\Repositories\Appointment;

use App\Contracts\Repositories\AppointmentRepositoryContract;
use Carbon\Carbon;
use Database\Factories\AppointmentFactory;
use Database\Factories\DoctorFactory;
use Database\Factories\PatientFactory;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AppointmentRepositoryListTest extends TestCase
{
    use DatabaseTransactions;

    private AppointmentRepositoryContract $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = app(AppointmentRepositoryContract::class);

        for ($i = 0; $i < random_int(30, 40); $i++) {
            AppointmentFactory::create();
        }
    }

    public function testListMethodFiltersDoctor()
    {
        $doctor = DoctorFactory::create();

        $count = random_int(30, 40);

        for ($i = 0; $i < $count; $i++) {
            AppointmentFactory::create(["doctorId" => $doctor->id]);
        }

        $appointments = $this->repository->list($doctor->id);

        $this->assertCount($count, $appointments);

        foreach ($appointments as $appointment) {
            $this->assertEquals($doctor->id->toString(), $appointment->doctorId->toString());
        }
    }

    public function testListMethodFiltersPatient()
    {
        $patient = PatientFactory::create();

        $count = random_int(30, 40);

        for ($i = 0; $i < $count; $i++) {
            AppointmentFactory::create(["patientId" => $patient->id]);
        }

        $appointments = $this->repository->list(patientId: $patient->id);

        $this->assertCount($count, $appointments);

        foreach ($appointments as $appointment) {
            $this->assertEquals($patient->id->toString(), $appointment->patientId->toString());
        }
    }

    public function testListMethodFiltersByStartDate()
    {
        $startFrom = Carbon::now()->subDay();
        AppointmentFactory::create(["startAt" => Carbon::now()]);
        $appointments = $this->repository->list(startFrom: $startFrom);

        $this->assertNotEmpty($appointments);

        foreach ($appointments as $appointment) {
            $this->assertGreaterThanOrEqual($startFrom, $appointment->startAt);
        }
    }
}
