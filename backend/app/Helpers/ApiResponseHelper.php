<?php

if (!function_exists('apiSuccessResponse')) {
    /**
     * Create a success API response.
     *
     * @param mixed $data
     * @param string $message
     * @param int $statusCode
     *
     * @return \Illuminate\Http\JsonResponse
     */
    function apiSuccessResponse($data = null, $message = 'Success', $statusCode = 200)
    {
        $response = [
            'status' => 'success',
            'message' => $message,
        ];

        if ($data !== null) {
            $response['data'] = $data;
        }

        return response()->json($response, $statusCode);
    }
}

if (!function_exists('apiErrorResponse')) {
    /**
     * Create a Error API response.
     *
     * @param mixed $data
     * @param string $message
     * @param int $statusCode
     *
     * @return \Illuminate\Http\JsonResponse
     */
    function apiErrorResponse($data = null, $message = 'Error', $statusCode = 400)
    {
        $response = [
            'status' => 'error',
            'message' => $message,
        ];

        if ($data !== null) {
            $response['data'] = $data;
        }
        return response()->json($response, $statusCode);
    }
}



if (!function_exists('apiValidationErrorResponse')) {
    /**
     * Create a validation error API response.
     *
     * @param array $errors
     * @param string $message
     * @param int $statusCode
     *
     * @return \Illuminate\Http\JsonResponse
     */
    function apiValidationErrorResponse($errors, $message = 'Validation Error', $statusCode = 422)
    {
        $response = [
            'status' => 'error',
            'message' => $message,
            'errors' => $errors,
        ];

        return response()->json($response, $statusCode);
    }
}

if (!function_exists('apiResponseCommonError')) {
    /**
     * Create a validation error API response.
     *
     * @param array $errors
     * @param string $message
     * @param int $statusCode
     *
     * @return \Illuminate\Http\JsonResponse
     */
    function apiResponseCommonError($errors, $message = 'Something wrong', $statusCode = 400)
    {
        $response = [
            'status' => 'error',
            'message' => $message,
            'errors' => $errors,
        ];
        return response()->json($response, $statusCode);
    }
}

