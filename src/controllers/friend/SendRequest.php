<?php

namespace Controllers\Friend;

use Model\FriendRepository;
use Model\User;
use RuntimeException;
use function Lib\Utils\redirect;

class SendRequest
{
    public function execute(User $connected_user, array $input): void
    {
        $friendRepository = new FriendRepository();
        if (!isset($input['requested_id'])) throw new RuntimeException('Invalid input');
        $friendRepository->sendRequest($connected_user->id, $input['requested_id']);
        redirect('/friends');
    }
}