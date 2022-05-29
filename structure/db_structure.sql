CREATE TABLE users (
    id integer primary key auto_increment,
    username varchar(16) not null unique,
    password varchar(255) not null,
    email varchar(255) not null unique,
    name varchar(255) not null,
    surname varchar(255) not null,
    propic varchar(255),
    nposts integer default 0
    ) Engine = InnoDB;

CREATE TABLE posts (
    id integer primary key auto_increment,
    user integer not null,
    time timestamp not null default current_timestamp,
    nlikes integer default 0,
    ncomments integer default 0,
    title varchar(31),
    content varchar(500),
    foreign key(user) references users(id) on delete cascade on update cascade
) Engine = InnoDB;

CREATE TABLE likes (
    user integer not null,
    post integer not null,
    index userindex(user),
    index postindex(post),
    foreign key(user) references users(id) on delete cascade on update cascade,
    foreign key(post) references posts(id) on delete cascade on update cascade,
    primary key(user, post)
) Engine = InnoDB;

CREATE TABLE comments (
    id integer primary key auto_increment,
    user integer not null,
    post integer not null,
    time timestamp not null default current_timestamp,
    text varchar(255),
    index userindex(user),
    index postindex(post),
    foreign key(user) references users(id) on delete cascade on update cascade,
    foreign key(post) references posts(id) on delete cascade on update cascade
) Engine = InnoDB;

CREATE TABLE favorites (
    id integer primary key auto_increment,
    user integer not null,
    title varchar(31),
    rating varchar(20),
    index userindex(user),
    CONSTRAINT unique_fav UNIQUE (user,title),
    foreign key(user) references users(id) on delete cascade on update cascade
) Engine = InnoDB;  

DELIMITER //

CREATE TRIGGER likes_trigger
AFTER INSERT ON likes
FOR EACH ROW
BEGIN
UPDATE posts 
SET nlikes = nlikes + 1
WHERE id = new.post;
END //

DELIMITER ;
CREATE TRIGGER unlikes_trigger
AFTER DELETE ON likes
FOR EACH ROW
BEGIN
UPDATE posts 
SET nlikes = nlikes - 1
WHERE id = old.post;
END //

DELIMITER //

CREATE TRIGGER comments_trigger
AFTER INSERT ON comments
FOR EACH ROW
BEGIN
UPDATE posts 
SET ncomments = ncomments + 1
WHERE id = new.post;
END //

DELIMITER //
CREATE TRIGGER posts_trigger
AFTER INSERT ON posts
FOR EACH ROW
BEGIN
UPDATE users 
SET nposts = nposts + 1
WHERE id = new.user;
END //

DELIMITER //
CREATE TRIGGER posts_delete_trigger
AFTER DELETE ON posts
FOR EACH ROW
BEGIN
UPDATE users 
SET nposts = nposts -1
WHERE id = old.user;
END //