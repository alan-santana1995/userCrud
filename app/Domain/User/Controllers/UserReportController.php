<?php

namespace App\Domain\User\Controllers;

use App\Domain\User\Requests\ExportUsersRequest;
use App\Http\Controllers\Controller;

class UserReportController extends Controller
{
    public function get(ExportUsersRequest $request)
    {
        $userExporter = $this->userExportActionFactory->create($request->get('type'));

        $file = $userExporter->execute();

        return response()->download($file);
    }
}
