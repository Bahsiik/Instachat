<?php

namespace Controllers\Friend;

require_once('src/model/Friend.php');

use Model\User;
use Model\FriendRepository;

class GetFriends
{
    public function execute(User $connected_user): array
    {
        $friendRepository = new FriendRepository();
        return $friendRepository->getFriends($connected_user->id);
    }
}