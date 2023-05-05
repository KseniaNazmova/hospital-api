<?php

namespace App\Repositories\Doctor;

use App\Contracts\Repositories\DoctorRepositoryContract;
use App\Dto\Doctor\Repository\DoctorDto;
use App\Dto\Doctor\Repository\DoctorRepositoryCreateDto;
use App\Entities\Doctor\Doctor;
use App\Exceptions\ApiException;
use App\Exceptions\ErrorCodes;
use App\Transformers\DoctorTransformer;
use Doctrine\ORM\EntityRepository;
use Ramsey\Uuid\UuidInterface;

class DoctorRepository extends EntityRepository implements DoctorRepositoryContract
{
    public function getById(UuidInterface $id): DoctorDto
    {
        $entity = $this->getEntityById($id);

        if (is_null($entity)) {
            throw new ApiException("doctor not found by id $id", ErrorCodes::DOCTOR_NOT_FOUND);
        }

        return DoctorTransformer::dtoFromEntity($entity);
    }

    public function create(
        DoctorRepositoryCreateDto $createDto,
    ): DoctorDto {
        $entity = new Doctor();

        $entity->prePersist();

        $this->_em->persist($entity);

        if (!is_null($createDto->id)) {
            $entity->setId($createDto->id);
        }

        $entity->setFirstName($createDto->firstName);
        $entity->setMiddleName($createDto->middleName);
        $entity->setLastName($createDto->lastName);
        $entity->setPhone($createDto->phone);
        $entity->setWorkdayStart($createDto->workdayStart);
        $entity->setWorkdayEnd($createDto->workdayEnd);
        $entity->setBirthDate($createDto->birthDate);
        $entity->setEmail($createDto->email);

        $this->_em->flush();

        return DoctorTransformer::dtoFromEntity($entity);
    }

    private function getEntityById(UuidInterface $id): ?Doctor
    {
        return $this->find($id->toString());
    }

    public function getByFullName(string $fullName): ?DoctorDto
    {
        $queryBuilder = $this->createQueryBuilder('d');

        $queryBuilder
            ->where("TRIM(CONCAT(d.lastName, ' ', d.firstName, ' ', d.middleName)) LIKE :fullName")
            ->setParameter('fullName', "%$fullName%")
            ->setMaxResults(1);

        $entity = $queryBuilder->getQuery()->getOneOrNullResult();

        return $entity ? DoctorTransformer::dtoFromEntity($entity) : null;
    }
}
