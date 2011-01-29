-- Remove foreign key constraints so we can drop all the tables
-- Save the original check value so we can revert it
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;

drop table if exists core_acl_rule;
create table core_acl_rule (
    id int not null auto_increment,
    resource_id varchar(255) not null,
    role_id varchar(255) not null,
    privilege varchar(255),
    `assertion` varchar(255),
    primary key(id),
    unique key(resource_id, role_id)
) engine=innodb;

drop table if exists `user`;
create table `user` (
    id int not null auto_increment,
    `alias` varchar(255) not null,
    primary key(id)
) engine=innodb;

drop table if exists user_auth;
create table user_auth (
    id int not null auto_increment,
    user_id int not null,
    login_id varchar(255) not null,
    pass_hash varchar(255) not null,
    primary key(id),
    constraint auth_has_user foreign key(user_id) references `user`(id) on delete cascade
) engine=innodb;

drop table if exists user_profile;
create table user_profile (
    id int not null auto_increment,
    user_id int not null,
    email varchar(255) not null,
    primary key(id),
    constraint profile_has_user foreign key(user_id) references `user`(id) on delete cascade
) engine=innodb;

drop table if exists user_session;
create table user_session (
    id int not null auto_increment,
    user_id int not null,
    session_key varchar(255) not null,
    last_activity datetime not null,
    primary key(id),
    unique key(session_key),
    constraint session_has_user foreign key(user_id) references `user`(id) on delete cascade
) engine=innodb;

drop table if exists post;
create table post (
    id int not null auto_increment,
    discriminator varchar(255) not null,
    title varchar(255) not null,
    date_created datetime not null,
    created_by_user_id int not null,
    date_updated datetime,
    updated_by_user_id int,
    url varchar(255),
    description varchar(1000),
    primary key(id),
    constraint post_created_by foreign key(created_by_user_id) references `user`(id) on delete restrict,
    constraint post_updated_by foreign key(updated_by_user_id) references `user`(id) on delete restrict
) engine=innodb;

drop table if exists post_comment;
create table post_comment (
    id int not null auto_increment,
    content text not null,
    date_created datetime not null,
    created_by_user_id int not null,
    date_updated datetime,
    updated_by_user_id int,
    post_id int not null,
    primary key(id),
    constraint comment_created_by foreign key(created_by_user_id) references `user`(id) on delete restrict,
    constraint comment_updated_by foreign key(updated_by_user_id) references `user`(id) on delete restrict,
    constraint comment_has_post foreign key(post_id) references post(id) on delete cascade
) engine=innodb;

-- Set the foreign key checks back to the original value
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;