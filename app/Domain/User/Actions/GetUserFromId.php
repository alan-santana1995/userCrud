<?php

namespace App\Domain\User\Actions;

use App\Domain\User\Models\User;
use Illuminate\Contracts\Database\Eloquent\Builder;

class GetUserFromId
{
    public function __construct(private User $user)
    {
    }

    public function execute(string $id, array $fields = []): User
    {
        return $this->user->newQuery()->when(
            $fields,
            fn (Builder $q, $fields) => $q->select($fields)
        )->firstOrFail($id);
    }
}
