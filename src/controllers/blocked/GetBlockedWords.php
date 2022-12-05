<?php

namespace Controllers\Friend;

use Model\BlockedRepository;
use Model\User;
use RuntimeException;

class GetBlockedWords
{
    public function execute(User $connected_user, array $input): array
    {
        $friendRepository = new BlockedRepository();
        if (!isset($input['blocked_id'])) throw new RuntimeException('Invalid input');
        return $friendRepository->getBlockedWords($connected_user->id, $input['blocked_id']);
    }
}