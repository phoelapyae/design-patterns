<?php

namespace App\ChainOfResponsibility;

class AuthHandler extends HttpHandler
{
    public function handle($request)
    {
        if (! $request['is_logged_in']) {
            echo "Error 401: Unauthorized! Please login.\n";

            return false;
        }

        return $this->passToNext($request);
    }
}
