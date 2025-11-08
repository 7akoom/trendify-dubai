<?php

namespace App\Traits;

trait WebResponse
{
    public function redirectWithMessage(string $route, string $message, string $type = 'success')
    {
        return redirect()->route($route)->with('message', $message)->with('type', $type);
    }
}
