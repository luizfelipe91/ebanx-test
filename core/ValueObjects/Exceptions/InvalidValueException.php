<?php

namespace Core\ValueObjects\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class InvalidValueException extends Exception
{

    function __construct(string $message)
    {
        parent::__construct($message, 422);
    }

    /**
     * Report the exception.
     */
    public function report(): void
    {
    }

    /**
     * Render the exception into an HTTP response.
     */
    public function render(Request $request): JsonResponse
    {
        return response()->json([
            'message' => $this->message,
            'exception' => class_basename($this),
            'code' => $this->code
        ], $this->code);
    }
}
