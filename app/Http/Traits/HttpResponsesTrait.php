<?php

namespace App\Http\Traits;

trait HttpResponsesTrait
{
    /**
     * Success.
     *
     * @param mixed $data    Data
     * @param mixed $message Message
     * @param mixed $code    Code
     *
     * @return
     */
    protected function success($data, $message = null, $code = 200) {
        return response()->json([
            'status'  => __('Request was successful.'),
            'message' => $message,
            'data'    => $data,
        ], $code);
    }

    /**
     * Error.
     *
     * @param mixed $data    Data
     * @param mixed $message Message
     * @param mixed $code    Code
     *
     * @return
     */
    protected function error($data, $message = null, $code) {
        return response()->json([
            'status'  => __('Error has occurred...'),
            'message' => $message,
            'data'    => $data,
        ], $code);
    }
}
