<?php

namespace Tests\Feature\Patient;

use Database\Factories\PatientFactory;
use Tests\TestCase;

class PatientCreateTest extends TestCase
{
    public function testCanCreateNewPatient()
    {
        $createDto = PatientFactory::generatePatientRepositoryCreateDto();

        // Act
        $response = $this->postJson('/api/patients', $createDto->toArray());

        // Assert
        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'Patient created successfully',
            ]);
    }
}
