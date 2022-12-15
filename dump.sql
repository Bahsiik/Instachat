create table users
(
    id           bigint unsigned auto_increment
        primary key,
    username     varchar(20)                      not null,
    password     varchar(64)                      not null,
    avatar       mediumblob                       null,
    created_date timestamp        default (now()) not null,
    birth_date   date                             not null,
    display_name varchar(30)                      null,
    fontsize     tinyint unsigned default (0)     not null,
    color        tinyint unsigned default (0)     not null,
    background   tinyint unsigned default (0)     not null,
    sexe         varchar(20)                      not null,
    email        varchar(320)                     not null,
    bio          varchar(200)                     null
)
    engine = InnoDB;

create table blocked
(
    blocker_id   bigint unsigned not null,
    blocked_id   bigint unsigned null,
    blocked_word varchar(100)    null,
    constraint fk_blocked_user
        foreign key (blocked_id) references users (id),
    constraint fk_blocker_user
        foreign key (blocker_id) references users (id)
)
    engine = InnoDB;

create index idx_blocked_blocked
    on blocked (blocked_id);

create table friends
(
    requested_id  bigint unsigned            not null,
    accepted      tinyint(1) default (false) null comment 'null = not viewed, false = rejected, true = accepted',
    send_date     timestamp  default (now()) not null,
    response_date timestamp  default (now()) null,
    requester_id  bigint unsigned            not null,
    constraint fk_friends_users
        foreign key (requester_id) references users (id),
    constraint fk_friends_users_0
        foreign key (requested_id) references users (id)
            on update cascade on delete cascade
)
    engine = InnoDB;

create index idx_friends_requested
    on friends (requested_id);

create table posts
(
    id            bigint unsigned auto_increment
        primary key,
    content       varchar(400)               not null,
    author_id     bigint unsigned            not null,
    creation_date timestamp  default (now()) not null,
    photo         mediumblob                 null,
    emotion       smallint unsigned          not null,
    deleted       tinyint(1) default 0       not null,
    constraint fk_posts_users
        foreign key (author_id) references users (id)
            on update cascade on delete cascade
)
    engine = InnoDB;

create table comments
(
    id            bigint unsigned auto_increment
        primary key,
    content       varchar(120)                 not null,
    upvotes       int unsigned default (0)     not null,
    downvotes     int unsigned default (0)     not null,
    reply_id      bigint unsigned              null,
    post_id       bigint unsigned              not null,
    creation_date timestamp    default (now()) not null,
    author_id     bigint unsigned              not null,
    deleted       tinyint(1)   default 0       not null,
    constraint fk_comments_comments
        foreign key (reply_id) references comments (id)
            on update cascade on delete cascade,
    constraint fk_comments_posts
        foreign key (id) references posts (id)
            on update cascade on delete cascade,
    constraint fk_comments_users
        foreign key (author_id) references users (id)
            on update cascade on delete cascade
)
    engine = InnoDB;

create index idx_comments_post_id
    on comments (post_id);

create index idx_comments_reply_id
    on comments (reply_id);

create index idx_posts_author_id
    on posts (author_id);

create table reactions
(
    id      bigint unsigned auto_increment
        primary key,
    post_id bigint unsigned not null,
    emoji   varchar(2)      not null,
    constraint fk_reactions_posts
        foreign key (post_id) references posts (id)
            on update cascade on delete cascade
)
    engine = InnoDB;

create table reaction_users
(
    reaction_id bigint unsigned not null
        primary key,
    user_id     bigint unsigned not null,
    constraint fk_reaction_users_reactions
        foreign key (reaction_id) references reactions (id)
            on update cascade on delete cascade,
    constraint fk_reaction_users_users
        foreign key (user_id) references users (id)
            on update cascade on delete cascade
)
    engine = InnoDB;

create index idx_reaction_users_user_id
    on reaction_users (user_id);

create index idx_reactions_post_id
    on reactions (post_id);

create table sessions
(
    id            varchar(64)               not null
        primary key,
    user_id       bigint unsigned           not null,
    creation_date timestamp default (now()) null,
    constraint fk_user_id
        foreign key (user_id) references users (id)
)
    engine = InnoDB;