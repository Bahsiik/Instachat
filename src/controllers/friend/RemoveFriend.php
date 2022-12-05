<?php

namespace Controllers\Friend;

use Model\FriendRepository;
use Model\User;
use RuntimeException;
use function Lib\Utils\redirect;

class RemoveFriend
{
    public function execute(User $connected_user, array $input): void
    {
        $friendRepository = new FriendRepository();
        if (!isset($input['friend_id'])) throw new RuntimeException('Invalid input');
        $friendRepository->removeFriend($connected_user->id, $input['friend_id']);
        redirect('/friends');
    }
}