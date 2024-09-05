<?php

namespace App\Domain\User\DTO;

use App\Domain\ViaCep\DTO\ViaCepZipCodeInformation;
use App\Http\Requests\UserFormRequest;
use Illuminate\Support\Arr;

class UserFormParameters
{
    public function __construct(
        private ?string $id,
        private ?string $name,
        private ?string $email,
        private ?string $document,
        private ?string $birthDate,
        private ?string $phoneNumber,
        private ?string $zipCode,
        private ?bool $status,
        private ?ViaCepZipCodeInformation $zipCodeInfo = null,
    ) {
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getDocument(): ?string
    {
        return $this->document;
    }

    public function getBirthDate(): ?string
    {
        return $this->birthDate;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function getZipCode(): ?string
    {
        return $this->zipCode;
    }

    public function setZipCodeInfo(
        ViaCepZipCodeInformation $zipCodeInfo
    ) {
        $this->zipCodeInfo = $zipCodeInfo;
    }

    public static function fromRequest(UserFormRequest $request): self
    {
        $data = $request->validated();

        return new self(
            id: Arr::get($data, 'id'),
            name: Arr::get($data, 'name'),
            email: Arr::get($data, 'email'),
            document: Arr::get($data, 'document'),
            birthDate: Arr::get($data, 'birth_date'),
            phoneNumber: Arr::get($data, 'phone_number'),
            zipCode: Arr::get($data, 'zip_code'),
            status: Arr::get($data, 'status', true)
        );
    }

    public function toArray()
    {
        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'document' => $this->document,
            'birth_date' => $this->birthDate,
            'phone_number' => $this->phoneNumber,
            'status' => $this->status,
            'zip_code' => $this->zipCode,
        ];
        if ($this->zipCodeInfo) {
            $data['uf'] = $this->zipCodeInfo?->getUf();
            $data['city'] = $this->zipCodeInfo?->getLocalidade();
            $data['neighborhood'] = $this->zipCodeInfo?->getBairro();

            $address = trim(
                $this->zipCodeInfo?->getLogradouro() . ' ' .
                $this->zipCodeInfo?->getComplemento()
            );
            $data['address'] = $address;
        }

        return $data;
    }
}
