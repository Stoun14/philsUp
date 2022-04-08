<?php

namespace App\DataPersister;

use App\Entity\Liked;
use App\Entity\Message;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;

class LikedDataPersister implements DataPersisterInterface
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
        $message = $data-> getMessage()->getId();
        $user = $data-> getUser()->getId();

        $repository = $this->entityManager->getRepository(Liked::class);
        $liked = $repository->findBy(["message"=>$message, "user"=>$user]);

        if($liked)
        {
            foreach ($liked as $like) {
                $this->entityManager->remove($like);
            }
            
            $repository = $this->entityManager->getRepository(Message::class);
            $message = $repository->findOneBy(["id"=>$message]);
            $message->setCountLike($message->getCountLike()-1);
            $this->entityManager->persist($message);
        } else {
            $this->entityManager->persist($data);

            $repository = $this->entityManager->getRepository(Message::class);
            $message = $repository->findOneBy(["id"=>$message]);
            $message->setCountLike($message->getCountLike()+1);
            $this->entityManager->persist($message);
        }
        
        $this->entityManager->flush();
    }


    public function remove($data, array $context = [])
    {
        $this->entityManager->remove($data);
        $this->entityManager->flush();
    }
}