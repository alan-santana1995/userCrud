<?php

namespace App\Http\Controllers;

use App\Http\Domain\User\Actions\GetPaginatedUsers;
use App\Http\Domain\User\Actions\GetUserFromId;
use App\Http\Domain\User\Actions\UpdateUser;
use App\Http\Domain\User\DTO\GetPaginatedUsersParameters;
use App\Http\Domain\User\DTO\UpdateUserParameters;
use App\Http\Requests\CreateNewUserRequest;
use App\Http\Requests\GetUsersRequest;
use App\Http\Requests\UniqueDocumentRequest;
use App\Http\Requests\UniqueEmailRequest;
use App\Http\Requests\UpdateUserRequest;
use CreateNewUser;
use CreateNewUserParameters;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function __construct(
        private GetPaginatedUsers $getPaginatedUsers,
        private GetUserFromId $getUserFromId,
        private UpdateUser $updateUser,
        private CreateNewUser $createNewUser
    ) {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(GetUsersRequest $request)
    {
        $parameters = GetPaginatedUsersParameters::fromGetUsersRequest($request);

        $users = $this->getPaginatedUsers->execute($parameters);

        return response()->json($users);
    }

    public function uniqueValidation(UniqueEmailRequest|UniqueDocumentRequest $request): JsonResponse
    {
        return response()->json();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateNewUserRequest $request)
    {
        $parameters = CreateNewUserParameters::fromRequest($request);

        $newId = $this->createNewUser->execute($parameters);

        return response()->json(
            [
                'id' => $newId
            ]
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = $this->getUserFromId->execute($id);

        return response()->json($user);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = $this->getUserFromId->execute(
            $id,
            [
                'name',
                'email',
                'document',
                'birth_date',
                'phone_number',
                'zip_code',
                'uf',
                'city',
                'neighborhood',
                'address',
            ]
        );

        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $updateUserRequest)
    {
        $parameters = UpdateUserParameters::fromRequest($updateUserRequest);

        $user = $this->updateUser->execute($parameters);

        return response()->json($user);
    }
}
