CREATE TABLE IF NOT EXISTS instachat.users
(
	id           bigint UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	username     varchar(20)                      NOT NULL,
	password     varchar(64)                      NOT NULL,
	avatar       mediumblob                       NULL,
	created_date timestamp        DEFAULT (NOW()) NOT NULL,
	birth_date   date                             NOT NULL,
	display_name varchar(30)                      NULL,
	color        tinyint UNSIGNED DEFAULT (0)     NOT NULL,
	background   tinyint UNSIGNED DEFAULT '1'     NOT NULL,
	sexe         varchar(20)                      NOT NULL,
	email        varchar(320)                     NOT NULL,
	bio          varchar(200)                     NULL
) ENGINE = InnoDB
  CHARSET = utf8mb4;

CREATE TABLE IF NOT EXISTS instachat.blocked
(
	blocker_id   bigint UNSIGNED           NOT NULL,
	blocked_id   bigint UNSIGNED           NULL,
	blocked_word varchar(100)              NULL,
	blocked_date timestamp DEFAULT (NOW()) NOT NULL,
	CONSTRAINT fk_blocked_user FOREIGN KEY (blocked_id) REFERENCES instachat.users (id),
	CONSTRAINT fk_blocker_user FOREIGN KEY (blocker_id) REFERENCES instachat.users (id)
) ENGINE = InnoDB
  CHARSET = utf8mb4;

CREATE INDEX idx_blocked_blocked ON instachat.blocked (blocked_id);

CREATE TABLE IF NOT EXISTS instachat.friends
(
	requester_id  bigint UNSIGNED           NOT NULL PRIMARY KEY,
	requested_id  bigint UNSIGNED           NOT NULL,
	accepted      tinyint(1)                NULL COMMENT 'null = not viewed, false = rejected, true = accepted',
	send_date     timestamp DEFAULT (NOW()) NOT NULL,
	response_date timestamp DEFAULT (NOW()) NULL,
	CONSTRAINT fk_friends_users FOREIGN KEY (requester_id) REFERENCES instachat.users (id) ON UPDATE CASCADE ON DELETE CASCADE,
	CONSTRAINT fk_friends_users_0 FOREIGN KEY (requested_id) REFERENCES instachat.users (id) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE = InnoDB
  CHARSET = utf8mb4;

CREATE INDEX idx_friends_requested ON instachat.friends (requested_id);

CREATE TABLE IF NOT EXISTS instachat.posts
(
	id            bigint UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	content       varchar(400)               NOT NULL,
	author_id     bigint UNSIGNED            NOT NULL,
	creation_date timestamp  DEFAULT (NOW()) NOT NULL,
	photo         mediumblob                 NULL,
	emotion       smallint UNSIGNED          NOT NULL,
	deleted       tinyint(1) DEFAULT 0       NOT NULL,
	CONSTRAINT fk_posts_users FOREIGN KEY (author_id) REFERENCES instachat.users (id) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE = InnoDB
  CHARSET = utf8mb4;

CREATE TABLE IF NOT EXISTS instachat.comments
(
	id            bigint UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	content       varchar(120)               NOT NULL,
	reply_id      bigint UNSIGNED            NULL,
	post_id       bigint UNSIGNED            NOT NULL,
	creation_date timestamp  DEFAULT (NOW()) NOT NULL,
	author_id     bigint UNSIGNED            NOT NULL,
	deleted       tinyint(1) DEFAULT 0       NOT NULL,
	CONSTRAINT fk_comments_comments FOREIGN KEY (reply_id) REFERENCES instachat.comments (id) ON UPDATE CASCADE ON DELETE CASCADE,
	CONSTRAINT fk_comments_posts FOREIGN KEY (post_id) REFERENCES instachat.posts (id) ON UPDATE CASCADE ON DELETE CASCADE,
	CONSTRAINT fk_comments_users FOREIGN KEY (author_id) REFERENCES instachat.users (id) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE = InnoDB
  COLLATE = utf8mb4_bin;

CREATE INDEX idx_comments_post_id ON instachat.comments (post_id);

CREATE INDEX idx_comments_reply_id ON instachat.comments (reply_id);

CREATE INDEX idx_posts_author_id ON instachat.posts (author_id);

CREATE TABLE IF NOT EXISTS instachat.reactions
(
	id      bigint UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	post_id bigint UNSIGNED      NOT NULL,
	emoji   text CHARSET utf8mb4 NULL,
	CONSTRAINT fk_reactions_posts FOREIGN KEY (post_id) REFERENCES instachat.posts (id) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS instachat.reaction_users
(
	reaction_id bigint UNSIGNED NOT NULL,
	user_id     bigint UNSIGNED NOT NULL,
	CONSTRAINT fk_reaction_users_reactions FOREIGN KEY (reaction_id) REFERENCES instachat.reactions (id) ON UPDATE CASCADE ON DELETE CASCADE,
	CONSTRAINT fk_reaction_users_users FOREIGN KEY (user_id) REFERENCES instachat.users (id) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE = InnoDB
  CHARSET = utf8mb4;

CREATE INDEX idx_reaction_users_reaction_id ON instachat.reaction_users (reaction_id);

CREATE INDEX idx_reaction_users_user_id ON instachat.reaction_users (user_id);

CREATE INDEX idx_reactions_post_id ON instachat.reactions (post_id);

CREATE TABLE IF NOT EXISTS instachat.sessions
(
	id           varchar(64)               NOT NULL PRIMARY KEY,
	user_id      bigint UNSIGNED           NOT NULL,
	created_date timestamp DEFAULT (NOW()) NULL,
	CONSTRAINT fk_user_id FOREIGN KEY (user_id) REFERENCES instachat.users (id) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE = InnoDB
  CHARSET = utf8mb4;

CREATE TABLE IF NOT EXISTS instachat.votes
(
	comment_id bigint UNSIGNED NOT NULL,
	type       tinyint         NOT NULL,
	user_id    bigint UNSIGNED NOT NULL,
	CONSTRAINT fk_votes_comments FOREIGN KEY (comment_id) REFERENCES instachat.comments (id) ON UPDATE CASCADE ON DELETE CASCADE,
	CONSTRAINT fk_votes_users FOREIGN KEY (user_id) REFERENCES instachat.users (id) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE = InnoDB
  CHARSET = utf8mb4;
