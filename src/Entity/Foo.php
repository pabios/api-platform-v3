<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\FooRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

//@todo uid v4
#[ORM\Entity(repositoryClass: FooRepository::class)]
#[ApiResource]
class Foo
{
    #[ORM\Id]
    #[ORM\GeneratedValue('CUSTOM')]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?Uuid $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    public function getId(): ?Uuid
    {
        return $this->id;
    }

//    public function setId(?Uuid $id): static
//    { // @todo see generated
//        if ($id === null) {
//            $id = uuid_generate_sha1('hell','');
//        }
//
//        $this->id = $id;
//
//        return $this;
//    }
    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }
}
