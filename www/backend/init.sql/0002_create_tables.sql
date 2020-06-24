create table users
(
    id         int auto_increment
        primary key,
    username   varchar(128)                        not null,
    password   varchar(128)                        not null,
    email      varchar(128)                        not null,
    created_at timestamp default CURRENT_TIMESTAMP not null,
    token      char(16)                            null,
    updated_at timestamp default CURRENT_TIMESTAMP not null on update CURRENT_TIMESTAMP,
    constraint users_email_uindex
        unique (email)
);

create table images
(
    id          int auto_increment
        primary key,
    file_name   varchar(128)                              not null,
    created_at  timestamp       default CURRENT_TIMESTAMP not null,
    user_id     int                                       not null,
    title       varchar(128)                              null,
    description varchar(2048)                             null,
    file_hash   char(32)                                  not null,
    constraint images_users
        foreign key (user_id) references users (id)
);

create index images_file_hash_index
    on images (file_hash);

create index user_id
    on images (user_id);

