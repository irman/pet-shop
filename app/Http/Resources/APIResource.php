<?php

namespace App\Http\Resources;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class APIResource extends JsonResource
{
    protected int $success = 1;
    protected ?string $error = null;
    /**
     * @var string[]
     */
    protected array $errors = [];
    protected int $statusCode = 200;

    public function __construct($resource, int $success = 1)
    {
        parent::__construct($resource);
        $this->success = $success;
    }

    public function withResponse(Request $request, JsonResponse $response): void
    {
        $response->setStatusCode($this->statusCode);
    }

    /**
     * @param Request $request
     * @return array<string, mixed>
     */
    public function with(Request $request): array
    {
        $with = [
            'success' => $this->success,
            'error' => $this->error,
            'errors' => $this->errors,
        ];
        if (is_null($this->error)) {
            $with['extra'] = [];
        } else {
            $with['trace'] = [];
        }
        return $with;
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

    /**
     * Customize the pagination information for the resource.
     *
     * @param Request $request
     * @param array<string, mixed> $paginated
     * @param array<string, mixed> $default
     * @return array<string, mixed>
     */
    public function paginationInformation(Request $request, array $paginated, array $default): array
    {
        return $paginated;
    }

    /**
     * @param string[] $errors
     * @return $this
     */
    public function setErrors(array $errors): APIResource
    {
        $this->errors = $errors;
        return $this;
    }

    public function setStatusCode(int $statusCode): APIResource
    {
        $this->statusCode = $statusCode;
        return $this;
    }
}
