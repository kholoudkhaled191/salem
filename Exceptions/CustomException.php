<?php

namespace App\Exceptions;

use Exception;

class CustomException extends Exception
{
    protected $errorCode;
    protected $userMessage;

    public function __construct(string $message = '', int $code = 0, Exception $previous = null, string $userMessage = null, string $errorCode = null)
    {
        parent::__construct($message, $code, $previous);
        $this->userMessage = $userMessage ?? 'حدث خطأ غير متوقع';
        $this->errorCode = $errorCode ?? 'UNKNOWN_ERROR';
    }

    public function getUserMessage(): string
    {
        return $this->userMessage;
    }

    public function getErrorCode(): string
    {
        return $this->errorCode;
    }

    public function render($request)
    {
        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json([
                'success' => false,
                'message' => $this->getUserMessage(),
                'error_code' => $this->getErrorCode(),
            ], $this->getCode() ?: 500);
        }

        return redirect()->back()->with('error', $this->getUserMessage());
    }
}
