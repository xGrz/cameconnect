<?php

namespace App\Http\Responses;

class SuccessResponse
{
    public static function make()
    {
        return response()
            ->json(['status' => 'success']);
    }
}
