<?php
// app/Exceptions/Handler.php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Illuminate\Session\TokenMismatchException;
use App\Exceptions\TenantException;
use App\Exceptions\StockInsufficientException;
use App\Exceptions\PaymentException;

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
        AuthenticationException::class,
        ValidationException::class,
        TenantException::class,
        StockInsufficientException::class,
        PaymentException::class,
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
            if (app()->bound('sentry')) {
                app('sentry')->captureException($e);
            }
        });

        // Custom reporting for specific exceptions
        $this->reportable(function (StockInsufficientException $e) {
            \Log::warning('Stock insufficient error', [
                'product_id' => $e->getProductId(),
                'requested' => $e->getRequestedQuantity(),
                'available' => $e->getAvailableStock(),
                'store_id' => $e->getStoreId(),
                'trace' => $e->getTraceAsString()
            ]);
        });

        $this->reportable(function (PaymentException $e) {
            \Log::error('Payment processing error', [
                'transaction_id' => $e->getTransactionId(),
                'payment_method' => $e->getPaymentMethod(),
                'error_code' => $e->getErrorCode(),
                'trace' => $e->getTraceAsString()
            ]);
        });
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $e
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function render($request, Throwable $e)
    {
        // API Responses
        if ($request->expectsJson() || $request->is('api/*')) {
            return $this->renderApiException($request, $e);
        }

        // Web Responses
        if ($e instanceof ModelNotFoundException) {
            return response()->view('errors.404', [], 404);
        }

        if ($e instanceof NotFoundHttpException) {
            return response()->view('errors.404', [], 404);
        }

        if ($e instanceof MethodNotAllowedHttpException) {
            return response()->view('errors.405', [], 405);
        }

        if ($e instanceof TokenMismatchException) {
            return redirect()->back()->withErrors(['csrf' => 'Session expired. Please try again.']);
        }

        if ($e instanceof AuthenticationException) {
            return redirect()->guest(route('login'));
        }

        if ($e instanceof UnauthorizedHttpException) {
            return response()->view('errors.401', [], 401);
        }

        if ($e instanceof TenantException) {
            return redirect()->route('landing')->with('error', $e->getMessage());
        }

        if ($e instanceof StockInsufficientException) {
            if ($request->is('admin/*')) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', $e->getMessage());
            }
            return response()->view('errors.stock-insufficient', [
                'message' => $e->getMessage(),
                'product' => $e->getProductName()
            ], 422);
        }

        if ($e instanceof PaymentException) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Payment failed: ' . $e->getMessage());
        }

        return parent::render($request, $e);
    }

    /**
     * Render API exception responses.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $e
     * @return \Illuminate\Http\JsonResponse
     */
    protected function renderApiException($request, Throwable $e)
    {
        $statusCode = 500;
        $errorCode = 'INTERNAL_ERROR';
        $message = 'An unexpected error occurred.';

        if ($e instanceof ValidationException) {
            $statusCode = 422;
            $errorCode = 'VALIDATION_ERROR';
            $message = 'Validation failed.';
            
            return response()->json([
                'success' => false,
                'error' => [
                    'code' => $errorCode,
                    'message' => $message,
                    'errors' => $e->errors()
                ]
            ], $statusCode);
        }

        if ($e instanceof ModelNotFoundException) {
            $statusCode = 404;
            $errorCode = 'RESOURCE_NOT_FOUND';
            $message = 'The requested resource was not found.';
        }

        if ($e instanceof NotFoundHttpException) {
            $statusCode = 404;
            $errorCode = 'ENDPOINT_NOT_FOUND';
            $message = 'API endpoint not found.';
        }

        if ($e instanceof MethodNotAllowedHttpException) {
            $statusCode = 405;
            $errorCode = 'METHOD_NOT_ALLOWED';
            $message = 'HTTP method not allowed for this endpoint.';
        }

        if ($e instanceof AuthenticationException) {
            $statusCode = 401;
            $errorCode = 'UNAUTHENTICATED';
            $message = 'Authentication required.';
        }

        if ($e instanceof UnauthorizedHttpException) {
            $statusCode = 403;
            $errorCode = 'UNAUTHORIZED';
            $message = 'You do not have permission to access this resource.';
        }

        if ($e instanceof TenantException) {
            $statusCode = 403;
            $errorCode = 'TENANT_ERROR';
            $message = $e->getMessage();
        }

        if ($e instanceof StockInsufficientException) {
            $statusCode = 422;
            $errorCode = 'STOCK_INSUFFICIENT';
            $message = $e->getMessage();
            
            return response()->json([
                'success' => false,
                'error' => [
                    'code' => $errorCode,
                    'message' => $message,
                    'data' => [
                        'product_id' => $e->getProductId(),
                        'requested_quantity' => $e->getRequestedQuantity(),
                        'available_stock' => $e->getAvailableStock()
                    ]
                ]
            ], $statusCode);
        }

        if ($e instanceof PaymentException) {
            $statusCode = 422;
            $errorCode = 'PAYMENT_ERROR';
            $message = $e->getMessage();
        }

        // Log unexpected errors
        if ($statusCode === 500) {
            \Log::error('API Exception: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'url' => $request->fullUrl(),
                'method' => $request->method(),
                'input' => $request->except(['password', 'password_confirmation'])
            ]);
        }

        return response()->json([
            'success' => false,
            'error' => [
                'code' => $errorCode,
                'message' => $message,
                'timestamp' => now()->toISOString()
            ]
        ], $statusCode);
    }

    /**
     * Prepare exception for rendering.
     *
     * @param  \Throwable  $e
     * @return \Throwable
     */
    protected function prepareException(Throwable $e)
    {
        if ($e instanceof ModelNotFoundException) {
            $e->setModel($e->getModel());
        }

        return parent::prepareException($e);
    }
}