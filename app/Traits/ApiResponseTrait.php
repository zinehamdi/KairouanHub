<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponseTrait
{
	/**
	 * Success Response
	 *
	 * @param mixed $data
	 * @param string $message
	 * @param int $code
	 * @return JsonResponse
	 */
	protected function successResponse($data, string $message = null, int $code = 200): JsonResponse
	{
		return response()->json([
			'status' => 'success',
			'message' => $message,
			'data' => $data
		], $code);
	}

	/**
	 * Error Response
	 * 
	 * Flutter-friendly error format
	 * Clean, actionable messages
	 *
	 * @param string $message
	 * @param int $code
	 * @param mixed $errors
	 * @return JsonResponse
	 */
	protected function errorResponse(string $message, int $code = 400, $errors = null): JsonResponse
	{
		$response = [
			'status' => 'error',
			'message' => $message,
			'code' => $this->getErrorCode($code),
		];

		if ($errors) {
			$response['errors'] = $errors;
		}

		return response()->json($response, $code);
	}

	/**
	 * Get Flutter-friendly error code
	 */
	private function getErrorCode(int $httpCode): string
	{
		return match($httpCode) {
			400 => 'BAD_REQUEST',
			401 => 'UNAUTHORIZED',
			403 => 'FORBIDDEN',
			404 => 'NOT_FOUND',
			422 => 'VALIDATION_ERROR',
			429 => 'RATE_LIMIT',
			500 => 'SERVER_ERROR',
			default => 'UNKNOWN_ERROR',
		};
	}
}
