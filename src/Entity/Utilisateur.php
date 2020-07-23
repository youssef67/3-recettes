<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\UtilisateurRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UtilisateurRepository::class)
 * @UniqueEntity(
 * fields={"username"},
 * message="le user existe déjà"
 * )
 */
class Utilisateur implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min = 5, max = 10, minMessage = "Le username doit faire 5 caractères minimum", maxMessage = "Le username doit faire 10 caractères maximum")
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min = 5, max = 10, minMessage = "Le mdp doit faire 5 caractères minimum", maxMessage = "Le username doit faire 10 caractères maximum")
     */
    private $password;

    /**
     * @Assert\Length(min = 5, max = 10, minMessage = "Le mdp doit faire 5 caractères minimum", maxMessage = "Le username doit faire 10 caractères maximum")
     * @Assert\EqualTo(propertyPath="password", message="les mdp ne sont pas équivalent")
     */
    private $verificationPassword;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $roles;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getVerificationPassword(): ?string
    {
        return $this->verificationPassword;
    }

    public function setVerificationPassword(string $verificationPassword): self
    {
        $this->verificationPassword = $verificationPassword;

        return $this;
    }

    public function getSalt()
    {
        
    }

    public function eraseCredentials()
    {
        
    }

    public function getRoles()
    {
        return [$this->roles];
    }

    public function setRoles(?string $roles): self
    {
        if($roles === NULL)
        {
            $this->roles = "ROLE_USER";
        }
        else
        {
            $this->roles = $roles;
        }
        
        return $this;
    }
}
