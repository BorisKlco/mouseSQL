<?php

namespace Middleware;

class Guest
{
    public function handle()
    {
        if (logged()) {
            redirect('/');
        }
    }
}
