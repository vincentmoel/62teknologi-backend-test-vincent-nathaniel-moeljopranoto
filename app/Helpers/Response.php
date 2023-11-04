<?php

namespace App\Helpers;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class Response
{

    public static function build($code, $data, $totalData = null)
    {
        if($totalData == null)
        {
            return response()->json(
                $data, 
                $code
            );
    
        }

        $response = [
            "total" => $totalData,
        ];

        return response()->json(
            array_merge($data, $response), 
            $code
        );

    }

    public static function noData($code, $message)
    {
        return response()->json([
            "code"      => $code,
            "message"   => $message,
        ], $code);
    }

    public static function withErrors($code, $message, $errors)
    {
        return response()->json([
            "code"      => $code,
            "message"   => $message,
            "errors"    => $errors
        ], $code);
    }
}
