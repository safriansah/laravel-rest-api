<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class BaseController extends Controller
{
    //
    public function handleRequest(callable $callback, $isTransaction = true)
    {
        if ($isTransaction) DB::beginTransaction();

        try {
            $data = $callback();

            if ($isTransaction) DB::commit();

            return $this->sendResponse(false, 200, "success", $data);
        } catch (Throwable $th) {
            Log::error($th);

            if ($isTransaction) DB::rollBack();

            return $this->sendResponse(true, 406, $th->getMessage());
        }
    }

    public function sendResponse($error = false, $status = 200, $message = null, $data = null) {
        return response()->json([
            'error' => $error,
            'message' => $message,
            'data' => $data,
        ], $status);
    }
}
