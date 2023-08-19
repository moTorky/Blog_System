CREATE TABLE users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    username TEXT UNIQ NOT NULL,
    password TEXT NOT NULL,
    user_role INTEGER NOT NULL default 1,
    pic_path TEXT,
);
-- there are there roles 0:admin 1:auther 

CREATE TABLE category(
    id int(11) primary key auto_increment,
    name text not null unique
);
--dont forget to add comment table 1:m post:comment
CREATE TABLE posts (
    id int(11) PRIMARY KEY auto_increment,
    title varchar(255) UNIQUE NOT NULL ,
    content TEXT NOT NULL,
    published int(1) NOT NULL default 0,
    author_id int(11) NOT NULL ,
    created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE inc_images_path(
    image_id int(11) PRIMARY KEY AUTO_INCREMENT,
    post_id int(11) REFERENCES posts(id) ON DELETE CASCADE,
    img_path VARCHAR(255) UNIQUE NOT NULL
); -- we can't use compiend primary_key(post_id, img_path), cuz img_path can be change, and i's too long

CREATE TABLE post_category(
    post_id int(11),
    category_id int(11)
);

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `fk_author_id` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`);
COMMIT;

--
-- Indexes for table `post_category`
--
ALTER TABLE `post_category`
  ADD PRIMARY KEY (`post_id`,`category_id`),
  ADD KEY `fk_post_id` (`post_id`),
  ADD KEY `fk_category_id` (`category_id`);
--
-- Constraints for table `post_category`
--
ALTER TABLE `post_category`
  ADD CONSTRAINT `fk_post_id` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`),
  ADD CONSTRAINT `fk_category_id` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`);
COMMIT;

ALTER TABLE `inc_images_path`
    ADD CONSTRAINT `fk_post_img_id` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`);