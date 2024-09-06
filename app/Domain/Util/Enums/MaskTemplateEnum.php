<?php

namespace App\Domain\Util\Enums;

enum MaskTemplateEnum: string
{
    case zipCode = '%s%s%s%s%s-%s%s%s';
    case phoneNumber = '(%s%s) %s%s%s%s-%s%s%s%s';
    case cpf = '%s%s%s.%s%s%s.%s%s%s-%s%s';
}
