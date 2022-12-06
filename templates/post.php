<?php use Model\Emotion;
use Model\User;
use Model\Post;
use Model\Comment;

$css[] = 'post.css';
/** @var User $connected_user */
global $connected_user;
/** @var Post $post */
global $post;
/** @var Comment[] $comments */
global $comments; ?>
<div class="post-container">
    <div class="post-avatar">
        <img src="../static/images/logo.png" alt="avatar">
    </div>
    <div class="post-right-part">
        <div class="post-info">
            <div class="post-display-name">
                <?= $connected_user->getDisplayOrUsername() ?>
            </div>
            <div class="post-username">
                <?= "@$connected_user->username" ?>
            </div>
            <div class="post-dot-separator">·</div>
            <div class="post-date">
                <?php
                $post_date = $post->creation_date;
                $current_date = new DateTime();
                $diff = $current_date->diff($post_date);
                $date_only_formatter = IntlDateFormatter::create(
                    'fr_FR',
                    IntlDateFormatter::FULL,
                    IntlDateFormatter::FULL,
                    'Europe/Paris',
                    IntlDateFormatter::GREGORIAN,
                    'd MMMM yyyy'
                );
                if ($diff->days > 0) {
                    echo $date_only_formatter->format($post_date);
                } elseif ($diff->h > 0) {
                    echo $diff->h . ' h';
                } elseif ($diff->i > 0) {
                    echo $diff->i . ' min';
                } elseif ($diff->s >= 0) {
                    echo $diff->s . 's';
                }
                ?>
            </div>
            <div class="post-emotion">
                <span class="post-emotion"><?= Emotion::cases()[$post->emotion->value - 1]->display() ?></span>
            </div>
        </div>
        <div class="post-content">
            <?php if (isset($post->content)) {
                echo $post->content;
            } ?>
        </div>
        <div class="post-action-buttons">
            <button class="post-comment-btn">
                <span class="material-symbols-outlined post-action-buttons-color">chat_bubble</span>
                <p class="post-comment-count">
                    <?php
                    if (count($comments) > 0) echo count($comments);
                    ?>
                </p>
            </button>
            <button class="post-share-btn">
                <span class="material-symbols-outlined post-action-buttons-color">ios_share</span>
            </button>
            <button class="post-reaction-btn">
                <span class="material-symbols-outlined post-action-buttons-color">add_reaction</span>
            </button>
        </div>
    </div>
</div>


