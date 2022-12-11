<?php
declare(strict_types=1);

use Controllers\Users\GetUser;
use Models\Comment;
use Models\CommentRepository;

/**
 * @var Comment $comment
 */
global $comment;
global $connected_user;
$comment_user = (new GetUser())->execute($comment->authorId);
?>
<div class="comment-container">
	<div class="comment-header">
		<div class="comment-avatar">
			<img alt="profile picture" src="<?= $comment_user->displayAvatar() ?>">
		</div>
		<div class="comment-info">
			<h3 class="comment-display-name"><?= $comment_user->getDisplayOrUsername() ?></h3>
			<p class="comment-username">@<?= htmlspecialchars($comment_user->username) ?></p>
			<div class="comment-date">
				<span><?php
					format_date_time($comment->createdAt) ?></span>
			</div>
		</div>
	</div>
	<div class="comment-content">
		<?php
		if ($comment->replyId !== null) {
			$reply = (new CommentRepository())->getCommentById($comment->replyId);
			$reply_user = (new GetUser())->execute($reply->authorId);
			?>
			<div class="comment-reply">
				<div class="comment-reply-header">
					<div class="comment-reply-info">
						<h3 class="comment-reply-display-name">En réponse à
							<span class="comment-reply-author">@<?= htmlspecialchars($reply_user->username) ?></span>
						</h3>
					</div>
				</div>
				<div class="comment-reply-content">
					"<?= substr($reply->content, 0, 50) ?>"
				</div>
			</div>
			<?php
		}
		?>
		<p><?= htmlspecialchars($comment->content) ?></p>
	</div>
	<div class="comment-footer">
		<button class="comment-replies action-btn">
			<span class="material-symbols-outlined action-btn-color">chat_bubble</span>
			<span><?= count((new CommentRepository())->getCommentsReplyingRecursively($comment->id)) ?></span>
		</button>
		<button class="comment-upvote action-btn">
			<span class="material-symbols-outlined action-btn-color">arrow_upward</span>
			<span><?= $comment->upVotes ?></span>
		</button>
		<button class="comment-downvote action-btn">
			<span class="material-symbols-outlined action-btn-color">arrow_downward</span>
			<span><?= $comment->downVotes ?></span>
		</button>
		<button class="comment-share action-btn">
			<span class="material-symbols-outlined action-btn-color">ios_share</span>
		</button>
	</div>
</div>
