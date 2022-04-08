<?php

namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Entity\Comment;
use App\Entity\Message;
use Doctrine\ORM\EntityManagerInterface;

class CommentDataPersister implements DataPersisterInterface
{

   private $entityManager;

   public function __construct(EntityManagerInterface $entityManager)
   {
       $this->entityManager = $entityManager;
   }

   public function supports($data): bool
   {
       return $data instanceof Comment;
   }
  
   public function persist($data)
   {
        if (!$data->getId()) {
           $data->setCreatedAt(new \DateTime('now'));
        }
        $data->setUpdatedAt(new \DateTime('now'));

        $message = $data->getMessage()->getId();
        $repository = $this->entityManager->getRepository(Message::class);
        $message = $repository->findOneBy(["id" => $message]);
        $message->setCountComment($message->getCountComment()+1);
        $this->entityManager->persist($message);

        $this->entityManager->persist($data);
        $this->entityManager->flush();
   }

   public function remove($data)
   {
        $message = $data->getMessage()->getId();
        $repository = $this->entityManager->getRepository(Message::class);
        $message = $repository->findOneBy(["id" => $message]);
        $message->setCountComment($message->getCountComment()-1);
        $this->entityManager->persist($message);
    
        $this->entityManager->remove($data);
        $this->entityManager->flush();
   }
}