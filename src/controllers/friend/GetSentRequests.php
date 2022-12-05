<?php

namespace Controllers\Friend;

use Model\FriendRepository;
use Model\User;

class GetSentRequests
{
    public function execute(User $connected_user): array
    {
        $friendRepository = new FriendRepository();
        return $friendRepository->getSentRequests($connected_user->id);
    }
}