<?php
declare(strict_types=1);

use Controllers\comments\GetCommentVotes;
use Controllers\Users\GetUser;
use Models\Comment;
use Models\CommentRepository;

/**
 * @var Comment $comment
 */
global $comment;
global $connected_user;
$comment_user = (new GetUser())->execute($comment->authorId);
$votes = (new GetCommentVotes())->execute($comment->id);
$up_votes = array_filter($votes, static fn($vote) => $vote->isUpvote);
$down_votes = array_filter($votes, static fn($vote) => !$vote->isUpvote);
$current_user_vote = array_filter($votes, static fn($vote) => $vote->userId === $connected_user->id)[0] ?? null;
$has_voted = $current_user_vote !== null;
$has_down_voted = $has_voted && !$current_user_vote->isUpvote;
$has_up_voted = $has_voted && $current_user_vote->isUpvote;

$comment_repository = new CommentRepository();
$replies = $comment_repository->commentHasReply($comment->id) ? count($comment_repository->getCommentsReplyingRecursively($comment->id)) : 0;
?>
<article class="comment-container" id="comment-<?= $comment->id ?>">
	<div class="comment-avatar">
		<img alt="profile picture" src="<?= $comment_user->displayAvatar() ?>">
	</div>
	<div class="comment-main">
		<div class="comment-info">
			<p class="comment-display-name"><?= $comment_user->getDisplayOrUsername() ?></p>
			<p class="comment-username">@<?= htmlspecialchars($comment_user->username) ?></p>
			<p class="subtitle">·</p>
			<div class="comment-date subtitle">
				<span><?php
					format_date_time_diff($comment->createdAt) ?></span>
			</div>
		</div>
		<div class="comment-content">
			<?php
			if ($comment->replyId !== null) {
				$reply = ($comment_repository)->getCommentById($comment->replyId);
				$reply_user = (new GetUser())->execute($reply->authorId);
				?>
				<div class="comment-reply subtitle">
					<p class="comment-reply-display-name">En réponse à
						<span class="comment-reply-author">@<?= htmlspecialchars($reply_user->username) ?></span>
					</p>
					<p class="comment-reply-content">
						"<?= substr($reply->content, 0, 50) ?>"
					</p>
				</div>
				<?php
			}
			?>
			<p class="comment-content"><?= htmlspecialchars($comment->content) ?></p>
		</div>
		<form method="post">
			<input name="comment-id" type="hidden" value="<?= $comment->id ?>">

			<div class="comment-footer">
				<button class="comment-replies action-btn" type="button">
					<span class="material-symbols-outlined action-btn-color">chat_bubble</span>
					<span><?= $replies === 0 ? '' : $replies ?></span>
				</button>

				<button class="comment-vote action-btn <?= $has_up_voted ? ' active' : '' ?>" formaction="/<?= $has_up_voted ? 'un-vote' : 'up-vote' ?>">
					<span class="material-symbols-outlined action-btn-color">arrow_upward</span>
					<span><?= count(array_filter($votes, static fn($v) => $v->isUpvote)) ?></span>
				</button>

				<button class="comment-vote action-btn <?= $has_down_voted ? ' active' : '' ?>" formaction="/<?= $has_down_voted ? 'un-vote' : 'down-vote' ?>">
					<span class="material-symbols-outlined action-btn-color">arrow_downward</span>
					<span><?= count(array_filter($votes, static fn($v) => !$v->isUpvote)) ?></span>
				</button>

				<button class="comment-share action-btn" type='button' data-link="<?= $comment->getLink() ?>">
					<span class="material-symbols-outlined action-btn-color">ios_share</span>
				</button>
			</div>
		</form>
	</div>
</article>
