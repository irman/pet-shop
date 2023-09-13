<?php

namespace App\Exceptions;

use App\Http\Resources\APIResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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
        $error = null;
        $previous = $e->getPrevious();
        if ($e instanceof AccessDeniedHttpException) {
            $message = $e->getMessage();
            if ($message === 'This action is unauthorized.') {
                $message = null;
            }
            $error = $message ?? 'Unauthorized: Not enough privileges';
        } elseif ($previous instanceof ModelNotFoundException) {
            $error = class_basename($previous->getModel()) . ' not found';
        }

        if ($error){
            return [
                'success' => 0,
                'data' => [],
                'error' => $error,
                'errors' => [],
                'trace' => [],
            ];
        }

        return parent::convertExceptionToArray($e);
    }
}
