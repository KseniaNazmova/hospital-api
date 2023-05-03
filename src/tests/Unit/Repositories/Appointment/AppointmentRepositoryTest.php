<?php

namespace tests\Unit\Repositories\Appointment;

use App\Contracts\Repositories\AppointmentRepositoryContract;
use App\Dto\Appointment\Repository\AppointmentDto;
use App\Dto\Appointment\Repository\AppointmentRepositoryCreateDto;
use Database\Factories\AppointmentFactory;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class AppointmentRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    private AppointmentRepositoryContract $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = app(AppointmentRepositoryContract::class);
    }

    public function testGetById(): void
    {
        $id = AppointmentFactory::create()->id;

        $dto = $this->repository->getById($id);

        $this->assertInstanceOf(AppointmentDto::class, $dto);
        $this->assertEquals($id, $dto->id);
    }

    public function testCreate(): void
    {
        $createDto = AppointmentFactory::generateAppointmentRepositoryCreateDto();
        $createDto->id = null;

        $dto = $this->repository->create($createDto);

        $this->assertInstanceOf(AppointmentDto::class, $dto);
        $this->assertNotNull($dto->id);
        $this->assertNonGeneratedProperties($createDto, $dto);
    }

    public function testCreateWithId(): void
    {
        $createDto = AppointmentFactory::generateAppointmentRepositoryCreateDto();
        $createDto->id = Uuid::uuid4();

        $dto = $this->repository->create($createDto);

        $this->assertInstanceOf(AppointmentDto::class, $dto);
        $this->assertEquals($createDto->id, $dto->id);
        $this->assertNonGeneratedProperties($createDto, $dto);
    }

    /**
     * @param AppointmentRepositoryCreateDto $createDto
     * @param AppointmentDto $dto
     * @return void
     */
    private function assertNonGeneratedProperties(AppointmentRepositoryCreateDto $createDto, AppointmentDto $dto): void
    {
        $this->assertEquals($createDto->doctorId, $dto->doctorId);
        $this->assertEquals($createDto->patientId, $dto->patientId);
        $this->assertEquals($createDto->startAt, $dto->startAt);
        $this->assertEquals($createDto->finishAt, $dto->finishAt);
    }
}
