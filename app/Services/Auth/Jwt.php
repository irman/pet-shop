<?php

namespace App\Services\Auth;

use App\Models\JwtToken;
use App\Models\User;
use Exception;
use Firebase\JWT\JWT as FirebaseJWT;
use Firebase\JWT\Key;

class Jwt
{
    static function login(User $user): JwtToken
    {
        $expiresAt = now()->addMinutes(config('auth.jwt.ttl'))->getTimestamp();
        $token = Jwt::encode([
            'iss' => config('app.url'),
            'exp' => $expiresAt,
            'user_uuid' => $user->uuid,
        ]);

        $jwtToken = new JwtToken();
        $jwtToken->user_id = $user->id;
        $jwtToken->unique_id = $token;
        $jwtToken->token_title = 'Token for ' . $user->full_name;
        $jwtToken->expires_at = $expiresAt;
        $jwtToken->save();

        return $jwtToken;
    }
    static function encode($payload = []): string
    {
        $privateKey = config('auth.jwt.private_key');
        return FirebaseJWT::encode($payload, $privateKey, config('auth.jwt.algorithm'));
    }

    static function decode($token): ?array
    {
        try {
            return (array)FirebaseJWT::decode($token, new Key(config('auth.jwt.public_key'), config('auth.jwt.algorithm')));
        } catch (Exception $e) {
            return null;
        }
    }
}
