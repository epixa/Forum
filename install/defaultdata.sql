insert into `user` (`alias`) values
    ('testusr');

insert into user_auth (user_id, login_id, pass_hash) values
    (last_insert_id(), 'testusr', '$2a$08$8uHd26d5YtE8Q6nn91DUJ.C/peuhIk.5u5y1g.fg.cFKROPjG7UcO');