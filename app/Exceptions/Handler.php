<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\File\Exception\AccessDeniedException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
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
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        // if (request()->expectsJson()) {
        //     $this->renderable(function (ValidationException $exception, $request) {
        //         return app('res')->error('validation error',$exception->validator->errors(), 422);
        //     });
        //     $this->renderable(function (AuthenticationException $exception, $request) {
        //         return app('res')->error('Unauthenticated.', [], 401);
        //     });
        // }
    }

    public function render($request, Throwable $exception)
    {
        if ($request->expectsJson()) {
            if ($exception instanceof ModelNotFoundException)
                return app('res')->error('object not found', [], 404);

            if ($exception instanceof AuthorizationException)
                return app('res')->error('unauthorized.', [], 401);

            if ($exception instanceof AuthenticationException)
                return app('res')->error('Unauthenticated.', [], 401);

            if ($exception instanceof AccessDeniedException)
                return app('res')->error('Unauthorized.', [], 403);

            if ($exception instanceof ValidationException)
                return app('res')->error('validation error', $exception->validator->errors(), 422);
        }

        return parent::render($request, $exception);
    }
}
