<?php

namespace Controllers\Pages;

use Model\User;

class FriendPage
{
    public function execute(User $connected_user): void
    {
        require_once('templates/friends.php');
    }
}