<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\ThrottleRequestsException;

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
        $this->renderable(function (ThrottleRequestsException $e, $request) {
            if ($request->is('api/createTask')) {
                getSuccessResponse([
                    'error' => 'Too many task creation attempts. Please try again later.',
                    'retry_after' => $e->getHeaders()['Retry-After'] . ' sec' ?? 60
                ]);
            }
        });
    }
}
