<?php

namespace Controllers;

use Services\UserService;

class UserController extends BaseApiController
{
    private UserService $userService;

    public function __construct()
    {
        $this->userService = new UserService();
    }

    public static function routes(): array
    {
        return [
            [
                'method' => 'GET',
                'uri' => '/users',
                'action' => 'getUsers',
            ],
            [
                'method' => 'POST',
                'uri' => '/register',
                'action' => 'registerUser',
            ]
        ];
    }

    public function registerUser(array $data): void
    {
        if (
            empty($data['name'])
            || empty($data['email'])
            || empty($data['consent'])
            || empty($data['imageData'])
        ) {
            $this->error(['message' => 'Invalid data!']);
        }

        if (!json_decode($data['consent'])) {
            $this->errorBadRequest();
        }

        $this->userService->createUser($data);

        $this->success();
    }

    public function getUsers(array $data): void
    {
        $this->success([
            'users' => $this->userService->getUsers($data)->toArray()
        ]);
    }
}