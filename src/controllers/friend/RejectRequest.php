<?php

namespace Controllers\Friend;

use Model\FriendRepository;
use Model\User;
use RuntimeException;
use function Lib\Utils\redirect;

class RejectRequest
{
    public function execute(User $connected_user, array $input): void
    {
        $friendRepository = new FriendRepository();
        if (!isset($input['requester_id'])) throw new RuntimeException('Invalid input');
        $friendRepository->rejectRequest($input['requester_id'], $connected_user->id);
        redirect('/friends');
    }
}