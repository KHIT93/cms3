CREATE TABLE `config` (
`cid` int(11) NOT NULL,
  `property` varchar(255) NOT NULL,
  `contents` text NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
CREATE TABLE `content_types` (
  `ctid` varchar(127) NOT NULL COMMENT 'Machine name for the content type',
  `title` varchar(255) NOT NULL COMMENT 'Human-readable name of the content type',
  `fields` text NOT NULL COMMENT 'JSON-array using the field name as the key and the Human-readable name as the value'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `fields` (
  `fid` varchar(255) NOT NULL COMMENT 'PK is based on content-type machine name and machine name of the field',
  `name` varchar(255) NOT NULL COMMENT 'Human-readable name of the field',
  `type` varchar(255) NOT NULL COMMENT 'Defines the field type'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `field_values` (
  `fid` varchar(255) NOT NULL COMMENT 'PK is based on the content-type machine name and the machine name of the field',
  `value` text NOT NULL COMMENT 'JSON-object containing all keys and values. For fields like text and textarea this field will be ignored. Call to dynamic contents such as functions will be declared by making {"phpfunc" : "name_of_the_function"}',
  `placeholder` int(11) NOT NULL COMMENT 'Text value used for the placeholder attribute of fx text and textarea'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `languages` (
  `code` varchar(10) NOT NULL,
  `name` varchar(512) NOT NULL COMMENT 'Human-readable name for the language',
  `active` int(11) NOT NULL DEFAULT '0' COMMENT 'Indicates whether the language is activated on the site or not'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `menus` (
`mid` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
CREATE TABLE `menu_links` (
`mlid` int(11) NOT NULL,
  `mid` int(11) NOT NULL COMMENT 'Reference to the menus.mid of the menu holding this link',
  `title` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `parent` int(11) NOT NULL COMMENT 'References the menu_links.mlid of the parent menu link. 0 is root',
  `position` int(11) NOT NULL COMMENT 'Used to order menu links. Lowest first',
  `show` int(11) NOT NULL COMMENT '0=Disabled, 1=Enabled'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
CREATE TABLE `modules` (
  `module` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL COMMENT 'Human-readable name of the module',
  `file` varchar(1024) NOT NULL COMMENT 'Path to the primary file of the module. This file will be included when the page is initializing. The path must be relative to the root of the module folder',
  `active` int(11) NOT NULL COMMENT 'Indicates if a moule is activated',
  `core` int(11) NOT NULL COMMENT 'Specifies if a module is located within the core'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `pages` (
`pid` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `author` int(11) NOT NULL DEFAULT '1' COMMENT 'References users.uid of the user who created the entry',
  `status` int(11) NOT NULL DEFAULT '1',
  `access` text NOT NULL COMMENT 'JSON-array of access rights for this entry',
  `keywords` varchar(512) NOT NULL,
  `description` text NOT NULL,
  `robots` varchar(255) NOT NULL COMMENT 'Comma-seperated string of options for search crawlers',
  `created` date NOT NULL,
  `last_updated` date NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
CREATE TABLE `permissions` (
  `permission` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL COMMENT 'Human-readable name of the permission',
  `description` text NOT NULL COMMENT 'Short description of the permission',
  `rid` text NOT NULL COMMENT 'References the roles.rid of all roles that have this permission',
  `module` varchar(255) NOT NULL COMMENT 'References the module or core component that added this permission'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `roles` (
`rid` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `position` int(11) NOT NULL COMMENT 'Used to order the roles when listing them to the user/administrator'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
CREATE TABLE `sessions` (
  `uid` int(11) NOT NULL COMMENT 'References the users.uid of the users session',
  `sid` varchar(128) NOT NULL COMMENT 'A hashed session ID generated by core',
  `ssid` varchar(128) NOT NULL COMMENT 'Secure session ID generated by core',
  `hostname` varchar(255) NOT NULL COMMENT 'The IP address that last used this session ID',
  `timestamp` int(11) NOT NULL COMMENT 'The UNIX timestamp when this session last requested a page',
  `session` text NOT NULL COMMENT 'JSON-array of session properties and values that need to be initialized on page load'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `sysguard` (
`sid` int(11) NOT NULL,
  `header` varchar(255) NOT NULL COMMENT 'A short description of the event. Fx 404 Page not found',
  `details` text NOT NULL COMMENT 'A detailed description of the unique event',
  `module` varchar(255) NOT NULL COMMENT 'Machine-name of the module that created the error. All core components use core as the module. Note that 404, 403 and 500 erros will show as core, unless a specific module generates the event themselves',
  `uid` int(11) NOT NULL COMMENT 'users.uid of the user performing the event that gets logged. If the users.uid is 0 it means anonymous user',
  `ref` text NOT NULL COMMENT 'URL of where the event happened',
  `timestamp` int(11) NOT NULL COMMENT 'UNIX Timestamp of the event'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
CREATE TABLE `system_definitions` (
  `definition` varchar(255) NOT NULL COMMENT 'Machine name of the definition',
  `name` varchar(512) NOT NULL COMMENT 'Human readable name of the definition',
  `options` text NOT NULL COMMENT 'JSON-array of options and human readable values'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `translation` (
`tid` int(11) NOT NULL,
  `string` text NOT NULL,
  `translation` text NOT NULL,
  `language` varchar(10) NOT NULL COMMENT 'References the languages.code for the language in which the string has been translated'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
CREATE TABLE `url_alias` (
`aid` int(11) NOT NULL,
  `source` text NOT NULL COMMENT 'The core path to the content. Fx. pages/123',
  `alias` text NOT NULL COMMENT 'The alias for the content referenced in url_alias.source. Fx. title-of-the-story = pages/123',
  `language` varchar(10) NOT NULL DEFAULT '0' COMMENT 'References the languages.code for this alias. If the value is 0 it is applied for all active langauges'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
CREATE TABLE `users` (
`uid` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(1024) NOT NULL,
  `role` int(11) NOT NULL DEFAULT '4' COMMENT 'References the roles.rid for the role applied to this user. Default value is for standard user',
  `email` text NOT NULL,
  `name` varchar(255) NOT NULL,
  `language` varchar(10) NOT NULL COMMENT 'References the languages.code for the user''s language',
  `active` int(11) NOT NULL COMMENT 'Specifies if the user account is active'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
CREATE TABLE `widgets` (
`wid` int(11) NOT NULL,
  `type` varchar(100) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `content` text COMMENT 'Contains that content of a widget. For dynamic widgets this field will contain a JSON-array of parameters for the function generating the dynamic content',
  `section` varchar(255) DEFAULT NULL COMMENT 'References the section from the THEMENAME.info file',
  `position` int(11) NOT NULL DEFAULT '0' COMMENT 'Used to order widgets when being rendered on the page',
  `show` int(11) NOT NULL DEFAULT '0' COMMENT 'Specifies how the contents of widgets.pages is being handled when rendering the widget',
  `pages` text COMMENT 'Comma-seperated list of page urls',
  `roles` text NOT NULL COMMENT 'Comma-seperated list of roles.rid that are allowed to see this widget. 0 is used for allowing anyone to view the widget'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
ALTER TABLE `config`
 ADD PRIMARY KEY (`cid`);
ALTER TABLE `content_types`
 ADD PRIMARY KEY (`ctid`);
ALTER TABLE `fields`
 ADD PRIMARY KEY (`fid`);
ALTER TABLE `field_values`
 ADD PRIMARY KEY (`fid`);
ALTER TABLE `languages`
 ADD PRIMARY KEY (`code`);
ALTER TABLE `menus`
 ADD PRIMARY KEY (`mid`);
ALTER TABLE `menu_links`
 ADD PRIMARY KEY (`mlid`);
ALTER TABLE `modules`
 ADD PRIMARY KEY (`module`);
ALTER TABLE `pages`
 ADD PRIMARY KEY (`pid`);
ALTER TABLE `permissions`
 ADD PRIMARY KEY (`permission`);
ALTER TABLE `roles`
 ADD PRIMARY KEY (`rid`);
ALTER TABLE `sessions`
 ADD PRIMARY KEY (`sid`,`ssid`);
ALTER TABLE `sysguard`
 ADD PRIMARY KEY (`sid`);
ALTER TABLE `system_definitions`
 ADD PRIMARY KEY (`definition`);
ALTER TABLE `translation`
 ADD PRIMARY KEY (`tid`);
ALTER TABLE `url_alias`
 ADD PRIMARY KEY (`aid`);
ALTER TABLE `users`
 ADD PRIMARY KEY (`uid`);
ALTER TABLE `widgets`
 ADD PRIMARY KEY (`wid`);
ALTER TABLE `config`
MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `menus`
MODIFY `mid` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `menu_links`
MODIFY `mlid` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `pages`
MODIFY `pid` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `roles`
MODIFY `rid` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `sysguard`
MODIFY `sid` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `translation`
MODIFY `tid` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `url_alias`
MODIFY `aid` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `users`
MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `widgets`
MODIFY `wid` int(11) NOT NULL AUTO_INCREMENT;