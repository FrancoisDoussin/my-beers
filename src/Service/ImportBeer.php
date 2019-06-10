<?php


namespace App\Service;


use App\Entity\Beer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Serializer\SerializerInterface;

class ImportBeer
{
    private $serializer;

    private $entityManager;

    public function __construct(SerializerInterface $serializer, EntityManagerInterface $entityManager)
    {
        $this->serializer = $serializer;
        $this->entityManager = $entityManager;
    }

    public function importFile(UploadedFile $uploadedFile): void
    {
        $datas = $this->serializer->decode(file_get_contents($uploadedFile->getPathname()), 'json');

        foreach ($datas as $data) {
            $beer = $this->serializer->denormalize($data, Beer::class, 'json');
            $this->entityManager->persist($beer);
        }
        $this->entityManager->flush();
    }
}