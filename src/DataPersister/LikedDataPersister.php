<?php

namespace App\DataPersister;

use App\Entity\Liked;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;

class LikedDataPersister implements ContextAwareDataPersisterInterface
{
    private $entityManager;    

    public function __construct(EntityManagerInterface $entityManager) 
    {
        $this->entityManager = $entityManager;        
    }

    public function supports($data, array $context = []): bool
    {
        return $data instanceof Liked;
    }

    public function persist($data, array $context = [])
    {
        $this->entityManager->persist($data);
        $this->entityManager->flush();
    }


    public function remove($data, array $context = [])
    {
        $this->entityManager->remove($data);
        $this->entityManager->flush();
    }
}