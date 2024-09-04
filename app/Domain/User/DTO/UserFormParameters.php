<?php
namespace App\Domain\User\DTO;

use App\Http\Requests\UserFormRequest;

abstract class UserFormParameters
{
    public function __construct(
        private string $name,
        private string $lastName,
        private string $email,
        private string $document,
        private string $birthDate,
        private string $phoneNumber,
        private string $zipCode,
        private string $uf,
        private string $city,
        private string $neighborhood,
        private string $address,
        private string $id = null,

    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getDocument(): string
    {
        return $this->document;
    }

    public function getBirthDate(): string
    {
        return $this->birthDate;
    }

    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }

    public function getZipCode(): string
    {
        return $this->zipCode;
    }

    public function getUf(): string
    {
        return $this->uf;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getNeighborhood(): string
    {
        return $this->neighborhood;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    abstract public static function fromRequest(UserFormRequest $request): self;

    public function toArray()
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'document' => $this->document,
            'birthDate' => $this->birthDate,
            'phoneNumber' => $this->phoneNumber,
            'zipCode' => $this->zipCode,
            'uf' => $this->uf,
            'city' => $this->city,
            'neighborhood' => $this->neighborhood,
            'address' => $this->address,
        ];
    }
}
