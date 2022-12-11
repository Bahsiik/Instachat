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
<article class="comment-container">
	<div class="comment-avatar">
		<img alt="profile picture" src="<?= $comment_user->displayAvatar() ?>">
	</div>
	<div class="comment-main">
		<div class="comment-info">
			<p class="comment-display-name"><?= $comment_user->getDisplayOrUsername() ?></p>
			<p class="comment-username">@<?= htmlspecialchars($comment_user->username) ?></p>
			<div class="comment-date subtitle">
				<span><?php
					format_date_time_diff($comment->createdAt) ?></span>
			</div>
		</div>
		<div class="comment-content">
			<?php
			if ($comment->replyId !== null) {
				$reply = (new CommentRepository())->getCommentById($comment->replyId);
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
</article>
