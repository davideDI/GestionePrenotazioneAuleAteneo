<?php

namespace App\Exceptions;

use Illuminate\Http\Request;
use Exception;
use PDOException;
use ErrorException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        // \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception) {

        if ($exception instanceof TokenMismatchException){
            Log::error('Handler - TokenMismatchException : ['.$exception->getMessage().']');
            return redirect('/')->with('customError', -1);
        }

        if ($exception instanceof PDOException){
            Log::error('Handler - PDOException : ['.$exception->getMessage().']');
            return redirect('/')->with('customError', -1);
        }

        if ($exception instanceof ErrorException){
            Log::error('Handler - ErrorException : ['.$exception->getMessage().']');
            return redirect('/')->with('customError', -1);
        }

        if ($exception instanceof NotFoundHttpException){
            Log::error('Handler - NotFoundHttpException : ['.$exception->getMessage().']');

            if ($this->isApiCall($request)) {
                return $this->getResponse(true, 'ERROR_CODE_HTTP_EXCEPTION', 'The server responded with a status of 404 (Not Found)', null, 404, $request);
            }

            return response()->view('errors.404', [], 404);

        }

        return parent::render($request, $exception);

    }

    //Used to manage error 404 in Api Rest
    public function isApiCall(Request $request) {
        return strpos($request->getUri(), '/api/v') !== false;
    }

    function getResponse($error, $errorCode, $errorMessage, $data, $statusCode, $request) {

        if($error == true) {
            Log::error('Api: '.$request->getUri().'. Exception: '.$errorCode.'. Error Message: '.$errorMessage);
        }

        return response()->json(array(
            'error'         => $error,
            'error_code'    => $errorCode,
            'error_message' => $errorMessage,
            'data'          => $data,
            'status_code'   => $statusCode
        ), $statusCode);

    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        return redirect()->guest('login');
    }
}
