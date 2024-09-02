<?php

namespace App\Http\Domain\User\Actions;

use App\Http\Domain\User\DTO\GetPaginatedUsersParameters;
use App\Http\Resources\PaginatedUserResource;
use App\Models\User;

class GetPaginatedUsers
{
    public function execute(GetPaginatedUsersParameters $parameters)
    {
        $users = User::paginate(
            $parameters->getPageSize(),
            $parameters->getPage(),
        );

        return PaginatedUserResource::collection($users);
    }
}
