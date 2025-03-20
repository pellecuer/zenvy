<?php

namespace App\Entity;

use App\Enum\Status;
use App\Entity\UserRole;
use App\Repository\UserRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity('email')]
#[ORM\Table(name: '`user`')]
class User
{
    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private int $id;

    #[ORM\Column(type: Types::STRING,length: 255, unique:true, nullable:false)]
    #[Assert\Email(
        message: 'The email {{ value }} is not a valid email.',
    )]
    private string $email;

    #[ORM\Column(type: Types::STRING , length: 255, nullable:false)]
    private string $password;

    #[ORM\Column(type: Types::STRING, length: 255, nullable:true)]
    private ?string $full_name = null;

    #[ORM\Column(type: Types::STRING, enumType: Status::class, length: 20)]
    private Status $status;

    #[ORM\Column(type: Types::JSON)] 
    private array $roles = [UserRole::USER];

    #[ORM\Column(unique: true)]
    private \DateTimeImmutable $created_at;


    public function __construct(Status $tatus = Status::INACTIVE)
    {
        $this->status = $tatus;
        $this->created_at = new \DateTimeImmutable();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getFullName(): ?string
    {
        return $this->full_name;
    }

    public function setFullName(string $full_name): static
    {
        $this->full_name = $full_name;

        return $this;
    }

    public function getStatus(): Status
    {
        return $this->status;
    }

    public function setStatus(Status $status): self
    {
        $this->status = $status;
        return $this;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;

       // Garantir qu'un utilisateur a toujours au moins un rôle
       if (empty($roles)) {
           $roles[] = UserRole::USER;
       }

       return array_unique($roles);
    }

    public function setRoles(array $roles): void
    {
       $this->roles = $roles;
    }
    
    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }
}
