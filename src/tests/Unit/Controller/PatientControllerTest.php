<?php

namespace Tests\Unit\Controller;

use App\Contracts\Repositories\PatientRepositoryContract;
use App\Http\Controllers\PatientController;
use Database\Factories\PatientFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Mockery;
use Tests\TestCase;

class PatientControllerTest extends TestCase
{
    public function testCreate()
    {
        // Мокаем метод crate в PatientRepository
        $patientRepositoryMock = $this->createMock(PatientRepositoryContract::class);
        $patientDto = PatientFactory::generatePatientDto();
        $patientRepositoryMock->method('create')->willReturn($patientDto);

        // получим контроллер
        /** @var PatientController $controller */
        $controller = App::make(PatientController::class, [
            'patientRepository' => $patientRepositoryMock,
        ]);

        // Мокаем запрос
        $request = new Request();
        $requestMock = Mockery::mock($request);
        $requestData = PatientFactory::generatePatientRepositoryCreateDto()->toArray();
        $requestMock->shouldReceive('toArray')->andReturn($requestData);

        /**
         * Получаем ответ
         *
         * Игнорируем ошибку типа, т.к. отправляем мок объекста, вместо самого объекта.
         * @noinspection PhpParamsInspection
         */
        $response = $controller->create($requestMock);

        // Assert
        $this->assertEquals(200, $response->status());
        $this->assertEquals('success', $response->getData()->status);
        $this->assertEquals('Patient created successfully', $response->getData()->message);

        $this->assertTrue(
            property_exists(
                $response->getData(),
                'patient'
            )
        );

        $this->assertEquals($patientDto->id->toString(), $response->getData()->patient->id);
        $this->assertEquals($patientDto->snils, $response->getData()->patient->snils);
        $this->assertEquals($patientDto->createdAt->format(DATE_ATOM), $response->getData()->patient->createdAt);
        $this->assertEquals($patientDto->updatedAt->format(DATE_ATOM), $response->getData()->patient->updatedAt);
        $this->assertEquals($patientDto->firstName, $response->getData()->patient->firstName);
        $this->assertEquals($patientDto->lastName, $response->getData()->patient->lastName);
        $this->assertEquals($patientDto->middleName, $response->getData()->patient->middleName);
        $this->assertEquals($patientDto->birthDate->format(DATE_ATOM), $response->getData()->patient->birthDate);
        $this->assertEquals($patientDto->residence, $response->getData()->patient->residence);
    }
}
