<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported(logged).
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Validation\ValidationException::class,
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

    public function isValid($value)
    {
        try {
            // Validate the value...
        } catch (Throwable $e) {
            report($e);

            return false;
        }
    }

    /**
     * Report or log an exception.
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
    public function render($request, Exception $exception)
    {
        # Handling custom exception
        if ($exception instanceof CustomException) {
            return response()->view('errors.custom', [], 500);
        }

        if ($e instanceof HttpResponseException) {
            return $e->getResponse();
        } elseif ($e instanceof ModelNotFoundException) {
            $e = new NotFoundHttpException($e->getMessage(), $e);
        } elseif ($e instanceof AuthenticationException) {
            return $this->unauthenticated($request, $e);
        } elseif ($e instanceof AuthorizationException) {
            $e = new HttpException(403, $e->getMessage());
        } elseif ($e instanceof ValidationException && $e->getResponse()) {
            return $e->getResponse();
        }

        if ($this->isHttpException($exception)) {
            $statusCode = $exception->getStatusCode();
            switch ($statusCode) {
                case '404':
                    return response()->view('errors/404');
                case '500';
                    return response()->view('errors/500');
            }

            if (view()->exists('errors.'.$statusCode)) {
                return response()->view('errors.'.$statusCode, [], $statusCode);
            }
            // or
            if (in_array($statusCode, array(403, 404, 500, 503))){
                return response()->view('errors.' . $statusCode, [], $statusCode);
            }
        }

        if ($request->expectsJson() && ($exception instanceof NotFoundHttpException || $exception instanceof MethodNotAllowedHttpException) ) {
        }

        # This will replace our 404 response with a JSON response.
        if ($exception instanceof ModelNotFoundException ||
            $exception instanceof NotFoundHttpException &&
            $request->wantsJson() ) {
                return response()->json(['error' => 'Not Found'], 404);
                abort(404, 'The resource you are looking for could not be found');
        }

        if ($e instanceof TokenMismatchException) {
            if ($request->ajax()) return response('Token Mismatch Exception', 401);
            return redirect()->route('auth.login.get');
        }

        if ($e instanceof \PDOException) { // database unavailable or login details wrong
            return response()->view('errors.404', ['message', $e->getMessage()], 404);
        }

        return parent::render($request, $exception);
    }

    /**
     * Get the default context variables for logging.
     * add global data for to every exception's log message
     * @return array
     */
    protected function context()
    {
        return array_merge(parent::context(), [
            'foo' => 'bar',
        ]);
    }
}
