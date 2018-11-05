INSERT INTO `role` (`id`, `name`, `deleted`, `hidden`, `updated_at`, `created_at`) VALUES
(1,	'guest',	0,	0,	NOW(),	NOW()),
(2,	'member',	0,	0,	NOW(),	NOW()),
(3,	'admin',	0,	0,	NOW(),	NOW()),
(4,	'superadmin',	0,	0,	NOW(),	NOW());

INSERT INTO `user` (`id`, `role_id`, `name`, `pass`, `two_factor`, `two_factor_secret`, `deleted`, `hidden`, `updated_at`, `created_at`) VALUES
(1,	2,	'user',	'$2y$11$eVVKcwwsb1UP7RSvdea21OWGJM3cYLBKSoPlAowBa0uQHjkguRB.K',	0,	'',	0,	0,	NOW(),	NOW());