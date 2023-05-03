<?php

namespace App\Repositories\Appointment;

use App\Contracts\Repositories\AppointmentRepositoryContract;
use App\Dto\Appointment\Repository\AppointmentDto;
use App\Dto\Appointment\Repository\AppointmentRepositoryCreateDto;
use App\Entities\Appointment\Appointment;
use App\Entities\Doctor\Doctor;
use App\Entities\Patient\Patient;
use App\Exceptions\ApiException;
use App\Exceptions\ErrorCodes;
use App\Transformers\AppointmentTransformer;
use Doctrine\ORM\EntityRepository;
use Ramsey\Uuid\UuidInterface;

class AppointmentRepository extends EntityRepository implements AppointmentRepositoryContract
{
    public function getById(UuidInterface $id): AppointmentDto
    {
        $entity = $this->getEntityById($id);

        if (is_null($entity)) {
            throw new ApiException("appointment not found by id $id", ErrorCodes::APPOINTMENT_NOT_FOUND);
        }

        return AppointmentTransformer::dtoFromEntity($entity);
    }

    public function create(
        AppointmentRepositoryCreateDto $createDto,
    ): AppointmentDto {
        $entity = new Appointment();

        $entity->prePersist();

        $this->_em->persist($entity);

        if (!is_null($createDto->id)) {
            $entity->setId($createDto->id);
        }

        $entity->setDoctor($this->_em->getReference(Doctor::class, $createDto->doctorId));
        $entity->setPatient($this->_em->getReference(Patient::class, $createDto->patientId));
        $entity->setStartAt($createDto->startAt);
        $entity->setFinishAt($createDto->finishAt);

        $this->_em->flush();

        return AppointmentTransformer::dtoFromEntity($entity);
    }

    private function getEntityById(UuidInterface $id): ?Appointment
    {
        return $this->find($id->toString());
    }
}
