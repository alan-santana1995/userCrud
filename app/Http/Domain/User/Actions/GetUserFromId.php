<?php

namespace App\Http\Domain\User\Actions;

use App\Models\User;

class GetUserFromId
{
    public function execute(string $id, array $fields = []): User
    {
        $query = User::when(
            $fields,
            fn ($q, $fields) => $q->select($fields)
        );

        return $query->firstOrFail($id);
    }
}
