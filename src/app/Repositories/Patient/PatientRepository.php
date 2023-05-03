<?php

namespace App\Repositories\Patient;

use App\Contracts\Repositories\PatientRepositoryContract;
use App\Dto\Patient\Repository\PatientDto;
use App\Dto\Patient\Repository\PatientRepositoryCreateDto;
use App\Entities\Patient\Patient;
use App\Exceptions\ApiException;
use App\Exceptions\ErrorCodes;
use App\Transformers\PatientTransformer;
use Doctrine\ORM\EntityRepository;
use Ramsey\Uuid\UuidInterface;

class PatientRepository extends EntityRepository implements PatientRepositoryContract
{
    public function getById(UuidInterface $id): PatientDto
    {
        $entity = $this->getEntityById($id);

        if (is_null($entity)) {
            throw new ApiException("patient not found by id $id", ErrorCodes::PATIENT_NOT_FOUND);
        }

        return PatientTransformer::dtoFromEntity($entity);
    }

    public function create(
        PatientRepositoryCreateDto $createDto,
    ): PatientDto {
        $entity = new Patient();

        $entity->prePersist();

        $this->_em->persist($entity);

        if (!is_null($createDto->id)) {
            $entity->setId($createDto->id);
        }

        $entity->setFirstName($createDto->firstName);
        $entity->setLastName($createDto->lastName);
        $entity->setMiddleName($createDto->middleName);
        $entity->setSnils($createDto->snils);
        $entity->setBirthDate($createDto->birthDate);
        $entity->setResidence($createDto->residence);

        $this->_em->flush();

        return PatientTransformer::dtoFromEntity($entity);
    }

    private function getEntityById(UuidInterface $id): ?Patient
    {
        return $this->find($id->toString());
    }
}
