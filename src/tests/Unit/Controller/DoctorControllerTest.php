<?php

namespace Tests\Unit\Controller;

use App\Contracts\Repositories\DoctorRepositoryContract;
use App\Http\Controllers\DoctorController;
use Carbon\Carbon;
use Database\Factories\DoctorFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Mockery;
use Tests\TestCase;

class DoctorControllerTest extends TestCase
{
    public function testCreate()
    {
        // Мокаем метод crate в DoctorRepository
        $doctorRepositoryMock = $this->createMock(DoctorRepositoryContract::class);
        $doctorDto = DoctorFactory::generateDoctorDto();
        $doctorRepositoryMock->method('create')->willReturn($doctorDto);

        // получим контроллер
        /** @var DoctorController $controller */
        $controller = App::make(DoctorController::class, [
            'doctorRepository' => $doctorRepositoryMock,
        ]);

        // Мокаем запрос
        $request = new Request();
        $requestMock = Mockery::mock($request);
        $requestData = DoctorFactory::generateDoctorRepositoryCreateDto()->toArray();
        $requestData['workdayStart'] = Carbon::now()->format("H:i");
        $requestData['workdayEnd'] = Carbon::now()->format("H:i");
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
        $this->assertEquals('Doctor created successfully', $response->getData()->message);

        $this->assertTrue(
            property_exists(
                $response->getData(),
                'doctor'
            )
        );

        $this->assertEquals($doctorDto->id->toString(), $response->getData()->doctor->id);
        $this->assertEquals($doctorDto->firstName, $response->getData()->doctor->firstName);
        $this->assertEquals($doctorDto->lastName, $response->getData()->doctor->lastName);
        $this->assertEquals($doctorDto->phone, $response->getData()->doctor->phone);
        $this->assertEquals($doctorDto->workdayStart->format(DATE_ATOM), $response->getData()->doctor->workdayStart);
        $this->assertEquals($doctorDto->workdayEnd->format(DATE_ATOM), $response->getData()->doctor->workdayEnd);
        $this->assertEquals($doctorDto->middleName, $response->getData()->doctor->middleName);
        $this->assertEquals($doctorDto->email, $response->getData()->doctor->email);

        if (!is_null($doctorDto->birthDate)) {
            $this->assertEquals($doctorDto->birthDate->format(DATE_ATOM), $response->getData()->doctor->birthDate);
        }
    }
}
