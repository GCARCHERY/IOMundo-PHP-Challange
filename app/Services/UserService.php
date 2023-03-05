<?php

namespace Services;

use Illuminate\Support\Collection;

use Models\User;
use Repositories\UserRepository;

class UserService
{
    private UserRepository $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    public function getUsers(array $data): Collection
    {
        return $this->userRepository->getUsers($data);
    }

    public function createUser(array $data): User
    {
        return $this->userRepository->createUser($data);
    }
}