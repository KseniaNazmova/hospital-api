<?php

namespace Tests\Unit\Controller;

use App\Contracts\Services\AppointmentServiceContract;
use App\Dto\Appointment\AppointmentListFilterDto;
use App\Dto\Appointment\Responses\AppointmentListResponseDto;
use App\Enums\SortDirectionEnum;
use App\Http\Controllers\AppointmentController;
use Carbon\Carbon;
use Database\Factories\AppointmentFactory;
use Illuminate\Http\Request;
use Mockery;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class AppointmentControllerTest extends TestCase
{
    public function testCreate()
    {
        $appointmentServiceMock = $this->createMock(AppointmentServiceContract::class);

        $appointmentDto = AppointmentFactory::generateAppointmentDto();
        $appointmentServiceMock->method('create')->willReturn($appointmentDto);

        $controller = new AppointmentController($appointmentServiceMock);

        $requestMock = Mockery::mock(Request::class);
        $requestMock->shouldReceive('toArray')->andReturn([
            "doctorId" => Uuid::uuid4(),
            "patientId" => Uuid::uuid4(),
            "startAt" => Carbon::now()->format(DATE_ATOM),
        ]);

        $response = $controller->create($requestMock);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('success', $response->getData()->status);
        $this->assertEquals('Appointment created successfully', $response->getData()->message);

        $this->assertTrue(property_exists($response->getData(), 'appointment'));

        $this->assertEquals($appointmentDto->id, $response->getData()->appointment->id);
    }

    public function testList()
    {
        $appointmentServiceMock = $this->createMock(AppointmentServiceContract::class);

        $listRequestDto = new AppointmentListFilterDto();
        $listRequestDto->doctorFullName = "John Doe";
        $listRequestDto->patientFullName = "Jane Smith";
        $listRequestDto->sortDirection = SortDirectionEnum::ASC;
        $listRequestDto->page = random_int(2, 6);
        $listRequestDto->perPage = 10;

        $mockedAppointmentList = [];
        for ($i = 0; $i < random_int(30, 40); $i++) {
            $mockedAppointmentList[] = AppointmentFactory::generateAppointmentDto();
        }

        $appointmentServiceMock->method('list')
            ->willReturn(
                new AppointmentListResponseDto(
                    $mockedAppointmentList,
                    $listRequestDto,
                )
            );

        $requestMock = Mockery::mock(Request::class);
        $requestMock->shouldReceive('toArray')->andReturn($listRequestDto->toArray());

        $appointmentController = new AppointmentController($appointmentServiceMock);
        $response = $appointmentController->list($requestMock);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('success', $response->getData()->status);

        $this->assertTrue(property_exists($response->getData(), 'appointments'));
        $this->assertCount(count($mockedAppointmentList), $response->getData()->appointments);
        $this->assertTrue(property_exists($response->getData(), 'filter'));

        $this->assertEquals('Appointments Page #' . $response->getData()->filter->page, $response->getData()->message);
    }
}
