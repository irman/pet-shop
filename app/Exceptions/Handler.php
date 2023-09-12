<?php

namespace App\Exceptions;

use App\Http\Resources\APIResource;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
        });
    }

    protected function convertValidationExceptionToResponse(ValidationException $e, $request): JsonResponse
    {
        $resource = new APIResource([], 0);
        $resource->setError('Failed Validation')->setErrors($e->errors())->setStatusCode(422);
        return $resource->toResponse($request);
    }

    /**
     * @param Throwable $e
     * @return array<string, mixed>|Response|APIResource
     */
    protected function convertExceptionToArray(Throwable $e): array|Response|APIResource
    {
        $message = $e->getMessage();
        if ($message === 'This action is unauthorized.') {
            $message = null;
        }
        if ($e instanceof AccessDeniedHttpException) {
            return [
                'success' => 0,
                'data' => [],
                'error' => $message ?? 'Unauthorized: Not enough privileges',
                'errors' => [],
                'trace' => [],
            ];
        }

        return parent::convertExceptionToArray($e);
    }
}
