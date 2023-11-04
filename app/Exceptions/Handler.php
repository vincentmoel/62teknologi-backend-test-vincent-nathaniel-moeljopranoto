<?php

namespace App\Exceptions;

use App\Helpers\Response;
use ErrorException;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Throwable;

class Handler extends ExceptionHandler
{
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        $request->headers->set('Accept', 'application/json');
        if ($request->expectsJson()) {
            return Response::noData(
                401,
                'Unauthenticated'
            );
        }
    }

    // Custom Handler
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof AuthorizationException) {
            return Response::noData(
                403,
                $exception->getMessage()
            );
        }
        
        if ($exception instanceof ModelNotFoundException) {
            return Response::noData(
                404,
                "Resource Not Found"
            );
        }
        
        if ($exception instanceof MethodNotAllowedHttpException) {
            return Response::noData(
                405,
                "Method Not Allowed"
            );
        }

        if ($exception instanceof NotFoundHttpException) {
            return Response::noData(
                404,
                "Route Not Found"
            );
        }
  
        if ($exception instanceof ValidationException){
            return Response::withErrors(
                $exception->status,
                "Unprocessable Content",
                $exception->errors()
            );
        }

        if ($exception instanceof AuthenticationException){
            return Response::noData(
                401,
                'Unauthenticated'
            );
        }

        if ($exception instanceof Exception){
            return Response::noData(
                500,
                $exception->getMessage(),

            );
        }

        if (in_array('api', $request->route()->middleware())) {
            $request->headers->set('Accept', 'application/json');
        }

        

        return parent::render($request, $exception);
    }

    private function transformValidationError(ValidationException $exception)
    {
        $arrError = [];

        foreach($exception->errors() as $error)
        {
            $arrError = array_merge($arrError, array_values($error));
        }
        return $arrError;
    }

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
    }
}
