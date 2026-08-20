<?php

namespace App\Services;

use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function __construct(
        private readonly UserRepositoryInterface $users
    ) {
    }

    public function register(array $payload): array
    {
        $user = $this->users->create([
            'name' => $payload['name'],
            'email' => $payload['email'],
            'password' => $payload['password'],
        ]);

        $token = $user->createToken('default')->plainTextToken;

        return [
            'message' => 'Registration successful.',
            'token' => $token,
            'data' => $user,
        ];
    }

    public function login(array $payload): array
    {
        $user = $this->users->findByEmail($payload['email']);

        if (! $user || ! Hash::check($payload['password'], $user->password)) {
            throw new AuthenticationException('The provided credentials are incorrect.');
        }

        $token = $user->createToken($payload['device_name'] ?? 'default')->plainTextToken;

        return [
            'message' => 'Login successful.',
            'token' => $token,
            'data' => $user,
        ];
    }

    public function logout(Request $request): void
    {
        $request->user()?->currentAccessToken()?->delete();
    }
}
