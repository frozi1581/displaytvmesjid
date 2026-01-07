<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

	protected function sendSuccess(int $code, string $message = null, $data = null, $redirect = null) : mixed {
		$successResponse = [
			'status' => 'success',
			'code' => $code,
			'message' => $message,
            'redirect' => $redirect,
			'response' => $data,
		];

		return response()->json($successResponse, $code);
	}

	protected function sendError(int $code, string $message = null) : mixed {
		return response()->json([
			'status' => 'error',
			'code' => $code,
			'message' => $message,
		], $code);
	}
}
