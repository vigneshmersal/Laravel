<?php
namespace App\Helpers;

class ApiHelper {
    public static $successCode = 200;
    public static $errorCode = 400;
    public static $failCode = 401;
    public static $exceptionCode = 500;

    public static $status, $message, $data = [];

    /**
     * return \ApiHelper::success(['otp' => $otp]);
     */
    public static function success($data = [], $message = "success", $status = 1)
    {
        self::$status = $status;
        self::$message = $message;
        self::$data = $data;
        return ApiHelper::apiResponse(self::$successCode);
    }

    /**
     * return \ApiHelper::error($validator->errors());
     * return \ApiHelper::error($validator->messages()->first());
     */
    public static function error($validationErrors = [], $message = "Bad Request", $status = 0)
    {
        self::$status = $status;
        self::$message = $message;
        self::$data = [
            'error' => 'Validation Error',
            'error_details' => $validationErrors
        ];
        return ApiHelper::apiResponse(self::$errorCode);
    }

    /**
     * return \ApiHelper::fail("Invalid credentials");
     */
    public static function fail($message = "fail", $data = [], $status = 0)
    {
        self::$status = $status;
        self::$message = $message;
        self::$data = $data;
        return ApiHelper::apiResponse(self::$failCode);
    }

    /**
     * return \ApiHelper::exception($ex);
     */
    public static function exception($ex, $message = "Internal Server Error", $status = 0)
    {
        self::$status = $status;
        self::$message = $message;
        self::$data = [
            'error' => 'Something went wrong.',
            'error_details' => 'Error: '.$ex->getMessage().', Line Number: '.$ex->getLine()
        ];
        return ApiHelper::apiResponse(self::$exceptionCode);
    }

    /**
     * API Response
     */
    public static function apiResponse($code)
    {
        $data = [
            "status" => self::$status,
            "message" => self::$message,
        ];
        if (count(self::$data) > 0) {
            $data = array_merge($data, ['data'=>self::$data]);
        }
        return response()->json($data, $code);
    }
}
