<?php

class Auth extends Controller
{

    public function register(): void
    {
        $this->render('Register');
    }
    public function login(): void
    {
        $this->render('Login');
    }
}
