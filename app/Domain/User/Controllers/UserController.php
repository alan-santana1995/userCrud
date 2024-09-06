<?php

namespace App\Domain\User\Controllers;

use App\Domain\User\Actions\CreateNewUser;
use App\Domain\User\Actions\GetPaginatedUsers;
use App\Domain\User\Actions\GetUserFromId;
use App\Domain\User\Actions\UpdateUser;
use App\Domain\User\DTO\GetPaginatedUsersParameters;
use App\Domain\User\DTO\UserFormParameters;
use App\Domain\User\Requests\CreateNewUserRequest;
use App\Domain\User\Requests\GetUsersRequest;
use App\Domain\User\Requests\UpdateUserRequest;
use App\Domain\ViaCep\Client\ViaCepClient;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function __construct(
        private GetPaginatedUsers $getPaginatedUsers,
        private GetUserFromId $getUserFromId,
        private UpdateUser $updateUser,
        private CreateNewUser $createNewUser,
        private ViaCepClient $viaCepClient,
    ) {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(GetUsersRequest $request): JsonResponse
    {
        $parameters = GetPaginatedUsersParameters::fromGetUsersRequest($request);

        $users = $this->getPaginatedUsers->execute($parameters);

        return response()->json($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateNewUserRequest $request)
    {
        $parameters = UserFormParameters::fromRequest($request);

        $zipCodeInfo = $this->viaCepClient->get($parameters->getZipCode());
        $parameters->setZipCodeInfo($zipCodeInfo);

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
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $updateUserRequest)
    {
        $parameters = UserFormParameters::fromRequest($updateUserRequest);

        if ($parameters->getZipCode() !== null) {
            $zipCodeInfo = $this->viaCepClient->get($parameters->getZipCode());
            $parameters->setZipCodeInfo($zipCodeInfo);
        }

        $user = $this->updateUser->execute($parameters);

        return response()->json($user);
    }

    public function destroy(string $id)
    {
        $parameters = UserFormParameters::fromArray(
            [
                'id' => $id,
                'status' => false,
            ]
        );

        $this->updateUser->execute($parameters);

        return response()->json();
    }
}
