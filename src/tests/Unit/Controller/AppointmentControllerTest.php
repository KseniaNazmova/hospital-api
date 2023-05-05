<?php

namespace Tests\Unit\Controller;

use App\Contracts\Services\AppointmentServiceContract;
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
        // Mock the AppointmentService
        $appointmentServiceMock = $this->createMock(AppointmentServiceContract::class);

        $appointmentDto = AppointmentFactory::generateAppointmentDto();
        $appointmentServiceMock->method('create')->willReturn($appointmentDto);

        // Create the AppointmentController instance with the mocked AppointmentService
        $controller = new AppointmentController($appointmentServiceMock);

        // Create a mock request with the necessary data
        $requestMock = Mockery::mock(Request::class);
        $requestMock->shouldReceive('toArray')->andReturn([
            "doctorId" => Uuid::uuid4(),
            "patientId" => Uuid::uuid4(),
            "startAt" => Carbon::now()->format(DATE_ATOM),
        ]);

        // Call the create method on the controller and get the response
        $response = $controller->create($requestMock);

        // Assert that the response is valid
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('success', $response->getData()->status);
        $this->assertEquals('Appointment created successfully', $response->getData()->message);

        $this->assertTrue(property_exists($response->getData(), 'appointment'));

        $this->assertEquals($appointmentDto->id, $response->getData()->appointment->id);
    }
}
