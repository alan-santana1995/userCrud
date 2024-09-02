<?php

return [
    'get' => [
        'attributes' => [
            'page' => 'Número da página',
            'page_size' => 'Itens por página'
        ],
        'validation_errors' => [
            'page.integer' => 'O número da página deve ser um número.',
            'page.min' => 'O número da página deve ser igual ou superior a 1.'
        ]
    ]
];
