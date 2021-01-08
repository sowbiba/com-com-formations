INSERT IGNORE INTO `user`(
           `username`,
           `password`,
           `email`,
           `enabled`,
           `is_verified`,
           `salt`
) VALUES
    ('sowbiba', '$2y$13$0f6hS2z1hZzii/BU1j2CrOMGtYZqEddA77e0Fz3jUZA61tpf0vkSy', 'sowbiba@hotmail.com', 1, 1, 'sowbiba'),
    ('nadd', '$2y$13$rnbh94FXG4a2cuifSpx6EuR3LZXdI8jX5eknlHGAxWknG89rocrL2', 'nadd@gmail.com', 1, 1, 'nadd')
;

INSERT IGNORE INTO `user_role` (
            `user_id`,
            `role_id`
) VALUES
    ((SELECT `id` FROM `user` WHERE `username`='sowbiba'), (SELECT `id` FROM `role` WHERE `name`='ROLE_SUPER_ADMIN')),
    ((SELECT `id` FROM `user` WHERE `username`='nadd'), (SELECT `id` FROM `role` WHERE `name`='ROLE_ADMIN'))
;