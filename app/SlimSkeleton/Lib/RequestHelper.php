<?php

namespace SlimSkeleton\Lib;

use Psr\Http\Message\ServerRequestInterface as Request;

class RequestHelper
{
    public static function param(Request $request, $name, $queryOnly = false)
    {
        if($request->getMethod() == "GET" && $request->getQueryParams() || $queryOnly) {
            return array_key_exists($name, $request->getQueryParams()) ? $request->getQueryParams()[$name] : null;
        }

        if($request->getParsedBody()) {
            return array_key_exists($name, $request->getParsedBody()) ? $request->getParsedBody()[$name] : null;
        }
        
        return null;
    }
}