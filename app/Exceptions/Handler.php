<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Throwable;
use Exception;
use Illuminate\Support\Arr;


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
        Illuminate\Validation\ValidationException::class,
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
           return  app()->environment(APPLICATION_MODE_PRODUCTION) ? true : false;
        });
        
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Throwable $e
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */

    public function render($request, Throwable $exception)
    {

        
        // When a exception is thrown, we will genrate o log first.
        if (!$this->shouldntReport($exception)) {
            exceptionLogWrite($exception);
        }
        
        // FOR API RESPONSE
        if ($this->isHttpException($exception) && $request->wantsJson() && $request->ajax() && app()->environment(APPLICATION_MODE_PRODUCTION)) {

            if ($exception->getStatusCode() == 404) {
                return response()->view('errors.' . '404', [], 404);
            }

            if ($exception->getStatusCode() == 500) {
                return response()->view('errors.' . '500', [], 500);
            }
        }

        // FOR WEB RESPONSE
        if($this->isHttpException($exception) && app()->environment(APPLICATION_MODE_PRODUCTION)){

            if ($exception->getStatusCode() == 404) {
                abrot(404);
            }

            if ($exception->getStatusCode() == 500) {
                abrot(500);
            }
        }
        // dd($exception);
        return parent::render($request, $exception);
    }

    /**
     * Base Method Override 
     */

    // protected function shouldntReport(Throwable $e)
    // {
    //     $dontReport = array_merge($this->dontReport, $this->internalDontReport);
    //     return !is_null( Arr::first($dontReport, fn ($type) => $e instanceof $type) );
    // }
    
}
