<?php
/**Use:
try {
    $validator = Validator::make($request->all(),[ 'name' => 'required' ]);
    if (!$validator->fails()) {
        return Helper::send_success_response($data);
    } else {
        return Helper::send_input_error_response($validator->messages()->first());
    }
} catch (Exception | Throwable $ex) {
    return Helper::exception_handling($ex);
}*/

/**
 * Sends  input error response
 *
 * @param type $validation_error_message
 * @return type \Illuminate\Http\JsonResponse
 */
function send_input_error_response($validation_error_message) {
    $status = 'fail';
    $message = 'Bad Request';
    $data = ['error' =>
        [
            'user_message' => $validation_error_message,
            'internal_message' => 'Required inputs need to be filled and it must be valid.',
            'code' => '1002'
        ]
    ];

    return send_fail_response($data, $message, $status, 400);
}

/**
 * Sends exception response
 *
 * @param type $error
 * @return type \Illuminate\Http\JsonResponse
 */
function send_exception_response($error) {
    $status = 'failed';
    $message = 'Internal Server Error';
    $data = [
        'error' => [
            'user_message' => 'Something went wrong. Kindly report on this.',
            'internal_message' => $error,
            'code' => '1100'
        ]
    ];

    return send_fail_response($data, $message, $status, 500);
}

/**
 *
 * Sends success reponse
 *
 * @param type $data
 * @return type \Illuminate\Http\JsonResponse
 */
function send_success_response($data) {
    $response_array = [
        "program" => config('app.name'),
        "version" => config('api.version'),
        "release" => config('api.release'),
        "datetime" => date('Y-m-d h:i:s A'),
        "timestamp" => time(),
        "status" => "success",
        "code" => "200",
        "message" => "OK",
        "data" => $data
    ];

    return response()->json($response_array, 200);
}

/**
 * Sends failure response
 *
 * @param type $data
 * @param type $message
 * @param type $status
 * @param type $status_code
 * @return type \Illuminate\Http\JsonResponse
 */
function send_fail_response($data, $message, $status = 'fail', $status_code = 500) {
    $response_array = [
        "program" => config('app.name'),
        "version" => config('api.version'),
        "release" => config('api.release'),
        "datetime" => date('Y-m-d h:i:s A'),
        "timestamp" => time(),
        "status" => $status,
        "code" => "$status_code",
        "message" => $message,
        "data" => $data
    ];

    return response()->json($response_array, $status_code);
}
