<?php

namespace App\Domain\User\Controllers;

use App\Domain\User\Actions\ExportUsersToCsv;
use App\Domain\User\Actions\GetAllUsers;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class UserReportController extends Controller
{
    public function __construct(
        private ExportUsersToCsv $exportUsersToCsv,
        private GetAllUsers $getAllUsers
    ) {
    }

    public function csv(): BinaryFileResponse
    {
        $users = $this->getAllUsers->execute();

        $fileInfo = $this->exportUsersToCsv->execute($users);

        return response()->download(
            $fileInfo
        );
    }
}
