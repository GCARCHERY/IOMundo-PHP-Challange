<?php

namespace Repositories;

use Illuminate\Support\Collection;
use Models\User;

class UserRepository
{
    public function getUsers(array $data): Collection
    {
        $users = User::query();

        $users->when(isset($data['name']), function ($query) use ($data) {
            return $query->where('name', 'LIKE', '%'.$data['name'].'%');
        });
        $users->when(isset($data['email']), function ($query) use ($data) {
            return $query->where('email', 'LIKE', '%'.$data['email'].'%');
        });

        return $users->get();
    }

    public function createUser(array $data): User
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'user_image' => $data['imageData'],
        ]);
    }
}