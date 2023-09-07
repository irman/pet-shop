<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class APIResource extends JsonResource
{
    protected int $success = 1;
    protected ?string $error = null;

    public function __construct($resource, $success = 1)
    {
        parent::__construct($resource);
        $this->success = $success;
    }

    public function with(Request $request): array
    {
        return [
            'success' => $this->success,
            'error' => $this->error,
            'errors' => [],
            'extra' => [],
            'trace' => $this->when($this->error, []),
        ];
    }

    public function setSuccess(int $success): APIResource
    {
        $this->success = $success;
        return $this;
    }

    public function setError(?string $error): APIResource
    {
        $this->error = $error;
        if (!is_null($error)) {
            $this->success = 0;
        }
        return $this;
    }
}
