<?php

namespace Controllers\User;

class CreateUserPage
{
    public function execute(): void
    {
        require_once('templates/register.php');
    }
}