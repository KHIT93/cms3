INSERT INTO `content_types`
VALUES('pages', 'Pages', '{"title" : "Title","body" : "Body","keywords" : "Keywords","description" : "Description","robots" : "Robots","alias" : "URL Alias","menulink" : "Menu item","published" : "Published"}');

INSERT INTO `fields`
VALUES
('pages_title', 'Title', 'text'),
('pages_body', 'Body', 'textarea'),
('pages_keywords', 'Keywords', 'text'),
('pages_description', 'Description', 'textarea'),
('pages_robots', 'Robots', 'checkbox'),
('pages_alias', 'URL Alias', 'text'),
('pages_menulink', 'Menu item', 'dropdown'),
('pages_published', 'Published', 'radio');

INSERT INTO `field_values`
VALUES
('pages_title', NULL, NULL),
('pages_body', NULL, NULL),
('pages_keywords', NULL, NULL),
('pages_description', NULL, NULL),
('pages_robots', '{"index" : "Indexing", "follow" : "Follow", "nodindex" : "No Indexing", "nofollow" : "No follow"}', NULL),
('pages_alias', NULL, NULL),
('pages_menulink', '{"phpfunc" : "getMenusAsArray"}', NULL),
('pages_published', '{"0" : "Unpublished", "1" : "Published"}', NULL);