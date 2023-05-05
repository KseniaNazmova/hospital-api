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
use DateTimeInterface;
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

    /** @return AppointmentDto[] */
    public function list(
        ?UuidInterface $doctorId = null,
        ?UuidInterface $patientId = null,
        ?DateTimeInterface $startFrom = null,
        ?DateTimeInterface $startTo = null,
    ): array {
        $qb = $this->createQueryBuilder('Appointment');

        if ($doctorId !== null) {
            $qb->leftJoin('Appointment.doctor', 'Doctor')
                ->andWhere('Doctor.id = :doctorId')
                ->setParameter('doctorId', $doctorId);
        }

        if ($patientId !== null) {
            $qb->leftJoin('Appointment.patient', 'Patient')
                ->andWhere('Patient.id = :patientId')
                ->setParameter('patientId', $patientId);
        }

        if ($startFrom !== null) {
            $qb->andWhere('Appointment.startAt >= :startFrom')
                ->setParameter('startFrom', $startFrom);
        }

        if ($startTo !== null) {
            $qb->andWhere('Appointment.startAt <= :startTo')
                ->setParameter('startTo', $startTo);
        }

        $list = $qb->getQuery()->getResult();

        return array_map(
            static fn(Appointment $appointment): AppointmentDto => AppointmentTransformer::dtoFromEntity($appointment),
            $list
        );
    }

    private function getEntityById(UuidInterface $id): ?Appointment
    {
        return $this->find($id->toString());
    }
}
