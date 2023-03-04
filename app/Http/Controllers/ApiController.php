<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class ApiController extends Controller
{

    public function withError()
    {
        return response()->json(
            [
                'success' => false,
            ]
        );
    }

    public function withSuccess()
    {
        return response()->json(
            [
                'success' => true,
            ]
        );
    }
}
