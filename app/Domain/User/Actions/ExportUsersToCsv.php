<?php

namespace App\Domain\User\Actions;

use App\Domain\Util\Actions\ApplyMask;
use App\Domain\Util\Enums\MaskTemplateEnum;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Lang;
use SplFileInfo;
use SplFileObject;

class ExportUsersToCsv
{
    public function __construct(private ApplyMask $applyMask)
    {
    }

    public function execute(Collection $users): SplFileInfo
    {
        $file = new SplFileObject(
            sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'users_export_' . date('Y-m-d') . '.csv',
            'w+'
        );

        $headers = Lang::get('user.attributes');
        $file->fputcsv(
            [
                $headers['name'],
                $headers['email'],
                $headers['document'],
                $headers['birth_date'],
                $headers['phone_number'],
                $headers['zip_code'],
                $headers['uf'],
                $headers['city'],
                $headers['neighborhood'],
                $headers['address'],
                $headers['status'],
            ]
        );

        foreach ($users as $user) {
            $file->fputcsv(
                [
                    $user->name,
                    $user->email,
                    $this->applyMask->execute(MaskTemplateEnum::cpf, $user->document),
                    $user->birth_date,
                    $this->applyMask->execute(MaskTemplateEnum::phoneNumber, $user->phone_number),
                    $this->applyMask->execute(MaskTemplateEnum::zipCode, $user->zip_code),
                    $user->uf,
                    $user->city,
                    $user->neighborhood,
                    $user->address,
                    $user->textualStatus,
                ]
            );
        }

        return $file->getFileInfo();
    }
}
