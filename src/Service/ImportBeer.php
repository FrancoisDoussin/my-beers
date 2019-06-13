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

    private $slugger;

    public function __construct(SerializerInterface $serializer, EntityManagerInterface $entityManager, Slugger $slugger)
    {
        $this->serializer = $serializer;
        $this->entityManager = $entityManager;
        $this->slugger = $slugger;
    }

    public function importFile(UploadedFile $uploadedFile): void
    {
        $datas = $this->serializer->decode(file_get_contents($uploadedFile->getPathname()), 'json');

        foreach ($datas as $data) {
            /** @var Beer $beer */
            $beer = $this->serializer->denormalize($data, Beer::class, 'json');
            $beer->setSlug($this->slugger->slugify($beer->getName()));
            $this->entityManager->persist($beer);
        }
        $this->entityManager->flush();
    }
}