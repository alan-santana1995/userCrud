<?php

namespace App\Domain\User\Actions;

use App\Domain\User\DTO\GetPaginatedUsersParameters;
use App\Http\Resources\PaginatedUserResource;
use App\Domain\User\Models\User;

class GetPaginatedUsers
{
    public function __construct(private User $user)
    {
    }
    public function execute(GetPaginatedUsersParameters $parameters): PaginatedUserResource
    {
        $users = $this->user->newQuery()
        ->whereStatus(true)
        ->latest()
        ->paginate(
            perPage: $parameters->getPageSize(),
            page: $parameters->getPage(),
        );

        return new PaginatedUserResource($users);
    }
}
