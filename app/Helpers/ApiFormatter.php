<?php
// file ini
namespace App\Helpers;

class Apiformatter {
    protected static $response = [
        'code' => NULL,
        'message' => NULL,
        'data' => NULL,

    ];

    public static function createApi($code = NULL, $message = NULL, $data = NULL) {
        //mengisi data ke variable $response yang diatas
        self::$response['code'] = $code;
        self::$response['message'] = $message;
        self::$response['data'] = $data;
        //mengembalikan hasil pengisian data $response dengan format json
        return response()->json(self::$response, self::$response['code']);
    }
}
?>