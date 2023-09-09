<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;

/**
 * @mixin User
 */
class UserResource extends APIResource
{
    protected bool $trimInfo = false;

    public function toArray(Request $request): array
    {
        return [
            'uuid' => $this->uuid,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            $this->mergeWhen(!$this->trimInfo, [
                'email_verified_at' => $this->email_verified_at,
                'avatar' => $this->avatar,
            ]),
            'address' => $this->address,
            'phone_number' => $this->phone_number,
            $this->mergeWhen(!$this->trimInfo, [
                'is_marketing' => $this->is_marketing,
            ]),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            $this->mergeWhen(!$this->trimInfo, [
                'last_login_at' => $this->last_login_at,
            ]),
            'token' => $this->whenHas('token'),
        ];
    }

    public function setTrimInfo(bool $trimInfo): UserResource
    {
        $this->trimInfo = $trimInfo;
        return $this;
    }
}
