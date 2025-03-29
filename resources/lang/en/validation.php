<?php

return [
    'required' => 'O campo :attribute é obrigatório.', 
    'email' => 'O campo :attribute deve ser um e-mail válido.',
    'min' => [
        'string' => 'O campo :attribute deve ter pelo menos :min caracteres.',
    ],
    'max' => [
        'string' => 'O campo :attribute não pode ter mais de :max caracteres.',
    ],
    'unique' => 'O :attribute já está em uso.',
    'confirmed' => 'A confirmação do :attribute não corresponde.',

    'attributes' => [
        'codigo' => 'código',
        'email' => 'e-mail',
        'descricao' => 'descrição',
    ],
];