<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Tylercd100\LERN\Facades\LERN;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
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

    public function report(Throwable $e)
    {
        if ($this->shouldReport($e)) {

            //Check to see if LERN is installed otherwise you will not get an exception.
            if (app()->bound("lern")) {
                app()->make("lern")->record($e); //Record the Exception to the database
                // app()->make("lern")->notify($e); //Notify the Exception

                /*
                OR...
                // app()->make("lern")->handle($e); //Record and Notify the Exception
                */
            }
        }

        return parent::report($e);
    }
}
