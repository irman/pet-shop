<?php

namespace App\Services\Auth;

use App\Events\UserLoggedIn;
use App\Models\JwtToken;
use App\Models\User;
use Illuminate\Auth\GuardHelpers;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Http\Request;

class JwtGuard implements Guard
{
    use GuardHelpers;

    protected Request $request;
    protected ?string $token = null;
    protected ?Authenticatable $lastAttempted;
    protected ?JwtToken $jwtToken = null;

    public function __construct(UserProvider $provider, Request $request)
    {
        $this->provider = $provider;
        $this->request = $request;
    }

    public function user(): Authenticatable|User|null
    {
        if (!is_null($this->user)) {
            return $this->user;
        }

        $jwtToken = $this->jwtToken();

        if ($jwtToken) {
            $this->user = $jwtToken->user;
        }
        return $this->user;
    }

    public function jwtToken(): ?JwtToken
    {
        if (is_null($this->jwtToken)) {
            $token = $this->getToken();

            if ($token) {
                $payload = Jwt::decode($token);
                if ($payload) {
                    $user = User::whereUuid($payload['user_uuid'])->first();
                    if ($user) {
                        $jwtToken = JwtToken::query()
                            ->where('user_id', $user->id)
                            ->where('expires_at', '>', now())
                            ->where('unique_id', $token)
                            ->first();

                        if ($jwtToken) {
                            $jwtToken->last_used_at = now();
                            $jwtToken->save();
                            $this->jwtToken = $jwtToken;
                        }
                    }
                }
            }
        }

        return $this->jwtToken;
    }

    /**
     * @param array<string, string> $credentials
     * @return bool
     */
    public function validate(array $credentials = []): bool
    {
        return (bool) $this->provider->retrieveByCredentials($credentials);
    }

    /**
     * @param array<string, string> $credentials
     * @param bool $login
     * @return bool|string
     */
    public function attempt(array $credentials = [], bool $login = true): bool|string
    {
        /** @var User|null $user */
        $user = $this->provider->retrieveByCredentials($credentials);
        $this->lastAttempted = $user;

        if ($user && $this->provider->validateCredentials($user, $credentials)) {
            if ($login) {
                $this->login($user);
            }
            return true;
        }

        return false;
    }

    public function login(User $user): void
    {
        $jwtToken = Jwt::login($user);

        $this->token = $jwtToken->unique_id;
        $this->setUser($user);

        event(new UserLoggedIn($user));
    }

    public function logout(): void
    {
        $jwtToken = $this->jwtToken();
        if ($jwtToken) {
            $jwtToken->delete();
            $this->jwtToken = null;
            $this->user = null;
        }
    }

    public function getToken(): ?string
    {
        if (is_null($this->token)) {
            $this->token = $this->request->bearerToken();
        }

        return $this->token;
    }

    public function getLastAttempted(): ?Authenticatable
    {
        return $this->lastAttempted;
    }
}
