<?php

namespace App\Exceptions;

use App\Traits\ApiResponser;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    use ApiResponser;

    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        // http not found
        if ($exception instanceof NotFoundHttpException || $exception instanceof HttpException) {
            $statusCode = $exception->getStatusCode();
            $message = Response::$statusTexts[$statusCode];

            return $this->errorResponse($message, $statusCode);
        }

        // instance not found
        if ($exception instanceof ModelNotFoundException) {
            $model = strtolower(class_basename($exception->getModel()));

            return $this->errorResponse("Does not exist any instance of {$model} with the given id", Response::HTTP_NOT_FOUND);
        }

        // validation exception
        if ($exception instanceof ValidationException) {
            $errors = $exception->validator->errors()->getMessages();

            return $this->errorResponse($errors, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        // access forbidden
        if ($exception instanceof AuthorizationException) {
            return $this->errorResponse($exception->getMessage(), Response::HTTP_FORBIDDEN);
        }

        // unauthorized access
        if ($exception instanceof AuthenticationException) {
            return $this->errorResponse($exception->getMessage(), Response::HTTP_UNAUTHORIZED);
        }

        // client exception
        if ($exception instanceof ClientException) {
            $message = $exception->getResponse()->getBody();
            $code = $exception->getCode();

            return $this->errorMessage($message, $code);
        }

        // if you are running in the development environment
        if (config('app.debug')) {
            return parent::render($request, $exception);
        }

        return $this->errorResponse('Unexpected error. Try again later', Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
