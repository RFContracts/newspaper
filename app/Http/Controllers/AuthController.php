<?php

namespace App\Http\Controllers;

use App\Eloquent\User;
use App\Http\Requests\RegisterRequest;
use http\Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Class AuthController
 * @package App\Http\Controllers
 */
class AuthController extends Controller
{
    /**
     * Login action.
     *
     * @param Request $request
     * @return JsonResponse|Response
     */
    public function login(Request $request)
    {
        try {
            $data = User::login($request);
            return response()->json($data, $data['code']);
        } catch (Exception $e) {
            return response()->json(['data' => $e, 'message' => 'Error'], 500);
        }
    }

	/**
	 * Register action
	 *
	 * @param RegisterRequest $request
	 * @return JsonResponse
	 */
	public function register(RegisterRequest $request)
    {
        try {
            $data = User::register($request);
            return response()->json($data, $data['code']);
        } catch (Exception $e) {
            return response()->json(['data' => $e, 'message' => 'Error'], 500);
        }
    }

}
