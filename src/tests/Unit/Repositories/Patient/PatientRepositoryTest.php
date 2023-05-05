<?php

namespace Tests\Unit\Repositories\Patient;

use App\Contracts\Repositories\PatientRepositoryContract;
use App\Dto\Patient\Repository\PatientDto;
use App\Dto\Patient\Repository\PatientRepositoryCreateDto;
use Database\Factories\PatientFactory;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class PatientRepositoryTest extends TestCase
{
    private PatientRepositoryContract $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = app(PatientRepositoryContract::class);
    }

    public function testGetById(): void
    {
        $id = PatientFactory::create()->id;

        $dto = $this->repository->getById($id);

        $this->assertInstanceOf(PatientDto::class, $dto);
        $this->assertEquals($id, $dto->id);
    }

    public function testCreate(): void
    {
        $createDto = PatientFactory::generatePatientRepositoryCreateDto();
        $createDto->id = null;

        $dto = $this->repository->create($createDto);

        $this->assertInstanceOf(PatientDto::class, $dto);
        $this->assertNotNull($dto->id);
        $this->assertNonGeneratedProperties($createDto, $dto);
    }

    public function testCreateWithId(): void
    {
        $createDto = PatientFactory::generatePatientRepositoryCreateDto();
        $createDto->id = Uuid::uuid4();

        $dto = $this->repository->create($createDto);

        $this->assertInstanceOf(PatientDto::class, $dto);
        $this->assertEquals($createDto->id, $dto->id);
        $this->assertNonGeneratedProperties($createDto, $dto);
    }

    public function testGetByFullName(): void
    {
        $patientDto = PatientFactory::create();

        $fullName = "";

        foreach (['lastName', 'firstName', 'middleName'] as $prop) {
            if (!is_null($patientDto->$prop)) {
                $fullName .= $patientDto->$prop . " ";
            }
        }

        $foundPatient = $this->repository->getByFullName(trim($fullName));

        // assert that the method returns the correct patient DTO
        $this->assertEquals($patientDto->lastName, $foundPatient->lastName);
        $this->assertEquals($patientDto->firstName, $foundPatient->firstName);
        $this->assertEquals($patientDto->middleName, $foundPatient->middleName);
    }

    /**
     * @param PatientRepositoryCreateDto $createDto
     * @param PatientDto $dto
     * @return void
     */
    private function assertNonGeneratedProperties(PatientRepositoryCreateDto $createDto, PatientDto $dto): void
    {
        $this->assertEquals($createDto->snils, $dto->snils);
        $this->assertEquals($createDto->firstName, $dto->firstName);
        $this->assertEquals($createDto->lastName, $dto->lastName);
        $this->assertEquals($createDto->middleName, $dto->middleName);
        $this->assertEquals($createDto->birthDate, $dto->birthDate);
        $this->assertEquals($createDto->residence, $dto->residence);
    }
}
