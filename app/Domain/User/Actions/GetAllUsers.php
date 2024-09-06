<?php

namespace App\Domain\User\Actions;

use App\Domain\User\Models\User;
use Illuminate\Database\Eloquent\Collection;

class GetAllUsers
{
    public function __construct(private User $user)
    {
    }

    public function execute(): Collection
    {
        return $this->user->get();
    }
}
