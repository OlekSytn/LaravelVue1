<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Auth\AuthenticationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
        AuthenticationException::class,
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
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
        //
    }


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
        if ($exception instanceof NotFoundHttpException) {
            if ($request->is('api/*')) {
                $data = [
                    "status"  => 404,
                    "success" => false,
                    "message" => "url not found"
                ];
                return response()->json($data);
            }
        }

        if($exception instanceof MethodNotAllowedHttpException){
            if ($request->is('api/*')) {
                $data = [
                    "status"  => 401,
                    "success" => false,
                    "message" => "invalid method"
                ];
                return response()->json($data);
            }
        }

        if($exception instanceof AuthenticationException){
            if ($request->is('api/*')) {
                $data = [
                    "status"  => 403,
                    "success" => false,
                    "message" => "un-authenticated user"
                ];
                return response()->json($data);
            }
        }
        if ($exception instanceof ModelNotFoundException) {
            $data = [
                "status"  => 404,
                "success" => false,
                "message" => "your item not found"
            ];
            return response()->json($data);
        }

        return parent::render($request, $exception);
    }


}
