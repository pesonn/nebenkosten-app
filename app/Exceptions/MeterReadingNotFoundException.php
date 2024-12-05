<?php

namespace App\Exceptions;

use Exception;
use http\Client\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MeterReadingNotFoundException extends Exception
{
    public function __construct(
        string $message,
        int $code = 0,
        \Exception $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }

    public function render(Request $request): JsonResponse
    {
        return response()->json([
            'error' => $this->getMessage(),
        ], 404);
    }

    public function __toString(): string
    {
        return __CLASS__ . ": {$this->message}\n";
    }


}
