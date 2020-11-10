<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert; // contraintes de champs

class UpdatePassword
{
    private $OldPass;

    /**
     * @Assert\Length(min=8, minMessage="Votre mot de passe doit faire au moins 8 caractères")
     * 
     */
    private $NewPass;

    /**
     * @Assert\EqualTo(propertyPath="NewPass", message="Votre mot de passe doit etre identique")
     *
     */
    private $ConfirmPass;

    public function getOldPass(): ?string
    {
        return $this->OldPass;
    }

    public function setOldPass(string $OldPass): self
    {
        $this->OldPass = $OldPass;

        return $this;
    }

    public function getNewPass(): ?string
    {
        return $this->NewPass;
    }

    public function setNewPass(string $NewPass): self
    {
        $this->NewPass = $NewPass;

        return $this;
    }

    public function getConfirmPass(): ?string
    {
        return $this->ConfirmPass;
    }

    public function setConfirmPass(string $ConfirmPass): self
    {
        $this->ConfirmPass = $ConfirmPass;

        return $this;
    }
}
