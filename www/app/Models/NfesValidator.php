<?php

namespace App\Models;

class NfesValidator
{
    public const ERROR_MESSAGES = [
        'required'       => 'O campo :attribute é obrigatório',
        'numeric'        => 'O valor do campo deve ser numérico',
        'string'         => 'O valor do campo deve ser uma string',
    ];
    public const NEW_PACKAGE_RULE = [
        'total_value'    => 'required|numeric',
        'access_key'     => 'required|string',
        'xml'            => 'required|string'
    ];
}
