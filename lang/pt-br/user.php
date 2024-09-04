<?php

return [
    'get' => [
        'attributes' => [
            'page' => 'Número da página',
            'page_size' => 'Itens por página'
        ],
        'messages' => [
            'page.integer' => 'O número da página deve ser um número.',
            'page.min' => 'O número da página deve ser igual ou superior a 1.'
        ]
    ],
    'user_form' => [
        'messages' => [
            'name.required' => 'O nome do usuário deve ser informado.',
            'name.string' => 'O campo Nome deve ser um texto.',
            'name.max' => 'O tamanho máximo do nome é de no máximo 100 caracteres.',
            'surname.required' => 'O sobrenome do usuário deve ser informado.',
            'surname.string' => 'O campo sobrenome deve ser um texto.',
            'surname.max' => 'O tamanho máximo do nome é no máximo 255 caracteres.',
            'email.required' => 'O e-mail do usuário deve ser informado.',
            'email.email' => 'O e-mail informado tem um formato inválido.',
            'email.unique' => 'O e-mail informado já está cadastrado em nosso sistema.',
            'document.required' => 'O CPF deve ser informado.',
            'document.string' => 'O CPF informado deve ser um texto.',
            'document.max' => 'O CPF informado deve ter 11 caracteres (sem contar pontos e o traço).',
            'document.unique' => 'O CPF informado já está em uso.',
            'document.cpf' => 'O CPF informado não é válido.',
            'birth_date.required' => 'A data de nascimento deve ser informada.',
            'birth_date.date_format' => 'A data de nascimento esta no formato inválido. O válido é DD/MM/YYYY',
            'phone_number.required' => 'O número de telefone é obrigatório.',
            'phone_number.max' => 'O máximo de dígitos esperado para o telefone é de 11 números.',
            'zip_code.required' => 'O CEP deve ser informado',
            'zip_code.string' => 'O valor informado no campo CEP deve ser um texto',
            'zip_code.max' => 'O CEP deve conter no máximo 7 digitos.',
            'uf.required' => 'O Estado(UF) deve ser informado.',
            'uf.string' => 'O valor campo Estado(UF) deve ser um texto.',
            'uf.enum' => 'O Estado(UF) informado não é válido.',
            'city.required' => 'A Cidade deve ser informada.',
            'city.string' => 'O valor do campo Cidade deve ser um texto.',
            'city.max' => 'O nome da Cidade pode conter no máximo 100 caracteres.',
            'neighborhood.required' => 'O Bairro deve ser informado.',
            'neighborhood.string' => 'O campo Bairro deve ser um texto.',
            'neighborhood.max' => 'O nome do Bairro deve ter no máximo 100 caracteres.',
            'address.required' => 'O Endereço deve ser informado.',
            'address.string' => 'O campo Endereço deve ser um texto.',
            'address.max' => 'O Endereço deve conter no máximo 100 caracteres.',
        ]
    ],
    'attributes' => [
        'name' => 'Nome',
        'email' => 'E-mail',
        'document' => 'CPF',
        'birth_date' => 'Data de Nascimento',
        'phone_number' => 'Número de Telefone',
        'zip_code' => 'CEP',
        'uf' => 'Estado',
        'city' => 'Cidade',
        'neighborhood' => 'Bairro',
        'address' => 'Endereço',
    ]
];
