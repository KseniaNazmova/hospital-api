<?php

namespace Tests\Unit\Repositories\Doctor;

use App\Contracts\Repositories\DoctorRepositoryContract;
use App\Dto\Doctor\Repository\DoctorDto;
use App\Dto\Doctor\Repository\DoctorRepositoryCreateDto;
use Database\Factories\DoctorFactory;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class DoctorRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    private DoctorRepositoryContract $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = app(DoctorRepositoryContract::class);
    }

    public function testGetById(): void
    {
        $id = DoctorFactory::create()->id;

        $dto = $this->repository->getById($id);

        $this->assertInstanceOf(DoctorDto::class, $dto);
        $this->assertEquals($id, $dto->id);
    }

    public function testCreate(): void
    {
        $createDto = DoctorFactory::generateDoctorRepositoryCreateDto();
        $createDto->id = null;

        $dto = $this->repository->create($createDto);

        $this->assertInstanceOf(DoctorDto::class, $dto);
        $this->assertNotNull($dto->id);
        $this->assertNonGeneratedProperties($createDto, $dto);
    }

    public function testCreateWithId(): void
    {
        $createDto = DoctorFactory::generateDoctorRepositoryCreateDto();
        $createDto->id = Uuid::uuid4();

        $dto = $this->repository->create($createDto);

        $this->assertInstanceOf(DoctorDto::class, $dto);
        $this->assertEquals($createDto->id, $dto->id);
        $this->assertNonGeneratedProperties($createDto, $dto);
    }

    public function testGetByFullName(): void
    {
        $doctorDto = DoctorFactory::create();

        $foundDoctor = $this->repository->getByFullName(
            "$doctorDto->lastName $doctorDto->firstName $doctorDto->middleName"
        );

        // assert that the method returns the correct doctor DTO
        $this->assertEquals($doctorDto->lastName, $foundDoctor->lastName);
        $this->assertEquals($doctorDto->firstName, $foundDoctor->firstName);
        $this->assertEquals($doctorDto->middleName, $foundDoctor->middleName);
    }

    /**
     * @param DoctorRepositoryCreateDto $createDto
     * @param DoctorDto $dto
     * @return void
     */
    private function assertNonGeneratedProperties(DoctorRepositoryCreateDto $createDto, DoctorDto $dto): void
    {
        $this->assertEquals($createDto->firstName, $dto->firstName);
        $this->assertEquals($createDto->lastName, $dto->lastName);
        $this->assertEquals($createDto->phone, $dto->phone);
        $this->assertEquals($createDto->workdayStart, $dto->workdayStart);
        $this->assertEquals($createDto->workdayEnd, $dto->workdayEnd);
        $this->assertEquals($createDto->birthDate, $dto->birthDate);
        $this->assertEquals($createDto->middleName, $dto->middleName);
        $this->assertEquals($createDto->email, $dto->email);
    }
}
