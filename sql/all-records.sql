INSERT INTO `demo` (`id`, `name`) VALUES (1, 'foo'), (2, 'bar'), (3, 'lorem');
INSERT INTO `role` (`id`, `name`) VALUES (1, 'guest'), (2, 'member'), (3, 'admin');
INSERT INTO `user` (`id`, `role_id`, `name`, `pass`) VALUES (1, 2, 'user', '$2y$11$eVVKcwwsb1UP7RSvdea21OWGJM3cYLBKSoPlAowBa0uQHjkguRB.K');