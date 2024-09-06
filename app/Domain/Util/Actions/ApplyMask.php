<?php

namespace App\Domain\Util\Actions;

use App\Domain\Util\Enums\MaskTemplateEnum;

class ApplyMask
{
    public function execute(MaskTemplateEnum $template, string $value)
    {
        $value = str_split($value);

        return sprintf($template->value, ...$value);
    }
}
