<?php

namespace Middleware;

class Auth
{
    public function handle()
    {
        if (!logged()) {
            redirect('/login');
        }
    }
}
