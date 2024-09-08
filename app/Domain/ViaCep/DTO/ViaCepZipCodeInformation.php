<?php

namespace App\Domain\ViaCep\DTO;

use Illuminate\Http\Client\Response;

class ViaCepZipCodeInformation
{
    public function __construct(
        private string $cep,
        private string $logradouro,
        private string $complemento,
        private string $unidade,
        private string $bairro,
        private string $localidade,
        private string $uf,
        private string $estado,
        private string $regiao,
        private string $ibge,
        private string $gia,
        private string $ddd,
        private string $siafi,
    ) {
    }

    public function getCep(): string
    {
        return $this->cep;
    }

    public function getLogradouro(): string
    {
        return $this->logradouro;
    }

    public function getComplemento(): string
    {
        return $this->complemento;
    }

    public function getUnidade(): string
    {
        return $this->unidade;
    }

    public function getBairro(): string
    {
        return $this->bairro;
    }

    public function getLocalidade(): string
    {
        return $this->localidade;
    }

    public function getUf(): string
    {
        return $this->uf;
    }

    public function getEstado(): string
    {
        return $this->estado;
    }

    public function getRegiao(): string
    {
        return $this->regiao;
    }

    public function getIbge(): string
    {
        return $this->ibge;
    }

    public function getGia(): string
    {
        return $this->gia;
    }

    public function getDdd(): string
    {
        return $this->ddd;
    }

    public function getSiafi(): string
    {
        return $this->siafi;
    }

    public function getEndereco(): string
    {
        $address = $this->logradouro;

        if (!empty($this->complemento)) {
            $address .= ", {$this->complemento}";
        }

        return $address;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            cep: $data['cep'],
            logradouro: $data['logradouro'],
            complemento: $data['complemento'],
            unidade: $data['unidade'],
            bairro: $data['bairro'],
            localidade: $data['localidade'],
            uf: strtolower($data['uf']),
            estado: $data['estado'],
            regiao: $data['regiao'],
            ibge: $data['ibge'],
            gia: $data['gia'],
            ddd: $data['ddd'],
            siafi: $data['siafi'],
        );
    }
}
