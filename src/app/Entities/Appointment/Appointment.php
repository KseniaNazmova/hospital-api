<?php

namespace App\Entities\Appointment;

use App\Entities\AbstractEntity;
use App\Entities\Doctor\Doctor;
use App\Entities\Patient\Patient;
use App\Repositories\Appointment\AppointmentRepository;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AppointmentRepository::class)]
#[ORM\Table(name: 'appointments')]
class Appointment extends AbstractEntity
{
    #[ORM\ManyToOne(targetEntity: Doctor::class)]
    #[ORM\JoinColumn(name: 'doctor_id', referencedColumnName: 'id', nullable: false)]
    protected Doctor $doctor;

    #[ORM\ManyToOne(targetEntity: Patient::class)]
    #[ORM\JoinColumn(name: 'patient_id', referencedColumnName: 'id', nullable: false)]
    protected Patient $patient;

    #[ORM\Column(type: 'datetime')]
    protected DateTimeInterface $startAt;

    #[ORM\Column(type: 'datetime')]
    protected DateTimeInterface $finishAt;

    public function getDoctor(): Doctor
    {
        return $this->doctor;
    }

    public function setDoctor(Doctor $doctor): void
    {
        $this->doctor = $doctor;
    }

    public function getPatient(): Patient
    {
        return $this->patient;
    }

    public function setPatient(Patient $patient): void
    {
        $this->patient = $patient;
    }

    public function getStartAt(): DateTimeInterface
    {
        return $this->startAt;
    }

    public function setStartAt(DateTimeInterface $startAt): void
    {
        $this->startAt = $startAt;
    }

    public function getFinishAt(): DateTimeInterface
    {
        return $this->finishAt;
    }

    public function setFinishAt(DateTimeInterface $finishAt): void
    {
        $this->finishAt = $finishAt;
    }
}
