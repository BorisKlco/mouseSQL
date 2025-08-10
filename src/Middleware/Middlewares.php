<?php

namespace Middleware;

class Middlewares
{
    const MAP = [
        'auth' => Auth::class,
        'guest' => Guest::class
    ];
}
