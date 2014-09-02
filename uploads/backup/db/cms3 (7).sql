-- phpMyAdmin SQL Dump
-- version 4.2.7
-- http://www.phpmyadmin.net
--
-- Vært: localhost:8889
-- Genereringstid: 29. 08 2014 kl. 10:24:09
-- Serverversion: 5.5.34
-- PHP-version: 5.5.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `cms3`
--

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `config`
--

CREATE TABLE `config` (
`cid` int(11) NOT NULL,
  `property` varchar(255) NOT NULL,
  `contents` text NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Data dump for tabellen `config`
--

INSERT INTO `config` (`cid`, `property`, `contents`) VALUES
(1, 'site_name', 'KHansen IT'),
(2, 'site_home', 'home'),
(3, 'site_theme', 'core'),
(4, 'site_slogan', 'Webløsninger til alle'),
(5, 'site_language', 'da'),
(6, 'create_user', '0');

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `content_types`
--

CREATE TABLE `content_types` (
  `ctid` varchar(127) NOT NULL COMMENT 'Machine name for the content type',
  `title` varchar(255) NOT NULL COMMENT 'Human-readable name of the content type',
  `fields` text NOT NULL COMMENT 'JSON-array using the field name as the key and the Human-readable name as the value'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Data dump for tabellen `content_types`
--

INSERT INTO `content_types` (`ctid`, `title`, `fields`) VALUES
('pages', 'Pages', '{"title" : "Title","body" : "Body","keywords" : "Keywords","description" : "Description","robots" : "Robots","alias" : "URL Alias","menulink" : "Menu item","published" : "Published"}');

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `fields`
--

CREATE TABLE `fields` (
  `fid` varchar(255) NOT NULL COMMENT 'PK is based on content-type machine name and machine name of the field',
  `name` varchar(255) NOT NULL COMMENT 'Human-readable name of the field',
  `type` varchar(255) NOT NULL COMMENT 'Defines the field type'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Data dump for tabellen `fields`
--

INSERT INTO `fields` (`fid`, `name`, `type`) VALUES
('pages_alias', 'URL Alias', 'text'),
('pages_body', 'Body', 'textarea'),
('pages_description', 'Description', 'textarea'),
('pages_keywords', 'Keywords', 'text'),
('pages_menulink', 'Menu item', 'dropdown'),
('pages_published', 'Published', 'radio'),
('pages_robots', 'Robots', 'checkbox'),
('pages_title', 'Title', 'text');

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `field_values`
--

CREATE TABLE `field_values` (
  `fid` varchar(255) NOT NULL COMMENT 'PK is based on the content-type machine name and the machine name of the field',
  `value` text NOT NULL COMMENT 'JSON-object containing all keys and values. For fields like text and textarea this field will be ignored. Call to dynamic contents such as functions will be declared by making {"phpfunc" : "name_of_the_function"}',
  `placeholder` int(11) NOT NULL COMMENT 'Text value used for the placeholder attribute of fx text and textarea'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Data dump for tabellen `field_values`
--

INSERT INTO `field_values` (`fid`, `value`, `placeholder`) VALUES
('pages_alias', '', 0),
('pages_body', '', 0),
('pages_description', '', 0),
('pages_keywords', '', 0),
('pages_menulink', '{"phpfunc" : "getMenusAsArray"}', 0),
('pages_published', '{"0" : "Unpublished", "1" : "Published"}', 0),
('pages_robots', '{"index" : "Indexing", "follow" : "Follow", "nodindex" : "No Indexing", "nofollow" : "No follow"}', 0),
('pages_title', '', 0);

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `languages`
--

CREATE TABLE `languages` (
  `code` varchar(10) NOT NULL,
  `name` varchar(512) NOT NULL COMMENT 'Human-readable name for the language',
  `active` int(11) NOT NULL DEFAULT '0' COMMENT 'Indicates whether the language is activated on the site or not'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Data dump for tabellen `languages`
--

INSERT INTO `languages` (`code`, `name`, `active`) VALUES
('af', 'Afrikaans', 0),
('am', 'Amharic', 0),
('ar', 'Arabic', 0),
('as', 'Assamese', 0),
('ast', 'Asturian', 0),
('az', 'Azerbaijani', 0),
('be', 'Belarusian', 0),
('bg', 'Bulgarian', 0),
('bn', 'Bengali', 0),
('bo', 'Tibetan', 0),
('br', 'Breton', 0),
('bs', 'Bosnian', 0),
('ca', 'Catalan', 0),
('cs', 'Czech', 0),
('cy', 'Welsh', 0),
('da', 'Danish', 1),
('de', 'German', 0),
('dz', 'Dzongkha', 0),
('el', 'Greek', 0),
('en', 'English', 1),
('en-gb', 'English, British', 0),
('eo', 'Esperanto', 0),
('es', 'Spanish', 0),
('et', 'Estonian', 0),
('eu', 'Basque', 0),
('fa', 'Persian, Farsi', 0),
('fi', 'Finnish', 0),
('fil', 'Filipino', 0),
('fo', 'Faeroese', 0),
('fr', 'French', 0),
('fy', 'Frisian, Western', 0),
('ga', 'Irish', 0),
('gd', 'Scots Gaelic', 0),
('gl', 'Galician', 0),
('gsw-berne', 'Swiss German', 0),
('gu', 'Gujarati', 0),
('he', 'Hebrew', 0),
('hi', 'Hindi', 0),
('hr', 'Croatian', 0),
('ht', 'Haitian Creole', 0),
('hu', 'Hungarian', 0),
('hy', 'Armenian', 0),
('id', 'Indonesian', 0),
('is', 'Icelandic', 0),
('it', 'Italian', 0),
('ja', 'Japanese', 0),
('jv', 'Javanese', 0),
('ka', 'Georgian', 0),
('kk', 'Kazakh', 0),
('km', 'Khmer', 0),
('kn', 'Kannada', 0),
('ko', 'Korean', 0),
('ku', 'Kurdish', 0),
('ky', 'Kyrgyz', 0),
('lb', 'Luxembourgish', 0),
('lo', 'Lao', 0),
('lt', 'Lithuanian', 0),
('lv', 'Latvian', 0),
('mfe', 'Mauritian Creole', 0),
('mg', 'Malagasy', 0),
('mi', 'Maori', 0),
('mk', 'Macedonian', 0),
('ml', 'Malayalam', 0),
('mn', 'Mongolian', 0),
('mr', 'Marathi', 0),
('ms', 'Bahasa Malaysia', 0),
('mt', 'Maltese', 0),
('my', 'Burmese', 0),
('nb', 'Norwegian Bokmål', 0),
('ne', 'Nepali', 0),
('nl', 'Dutch', 0),
('nn', 'Norwegian Nynorsk', 0),
('oc', 'Occitan', 0),
('or', 'Oriya', 0),
('os', 'Ossetian', 0),
('pa', 'Punjabi', 0),
('pl', 'Polish', 0),
('prs', 'Afghanistan Persian', 0),
('ps', 'Pashto', 0),
('pt', 'Portuguese, International', 0),
('pt-br', 'Portuguese, Brazil', 0),
('pt-pt', 'Portuguese, Portugal', 0),
('rhg', 'Rohingya', 0),
('ro', 'Romanian', 0),
('ru', 'Russian', 0),
('rw', 'Kinyarwanda', 0),
('sco', 'Scots', 0),
('sd', 'Sindhi', 0),
('se', 'Northern Sami', 0),
('si', 'Sinhala', 0),
('sk', 'Slovak', 0),
('sl', 'Slovenian', 0),
('sq', 'Albanian', 0),
('sr', 'Serbian', 0),
('sv', 'Swedish', 0),
('sw', 'Swahili', 0),
('ta', 'Tamil', 0),
('ta-lk', 'Tamil, Sri Lanka', 0),
('te', 'Telugu', 0),
('test', 'Test', 0),
('th', 'Thai', 0),
('ti', 'Tigrinya', 0),
('tr', 'Turkish', 0),
('tyv', 'Tuvan', 0),
('ug', 'Uighur', 0),
('uk', 'Ukrainian', 0),
('ur', 'Urdu', 0),
('vi', 'Vietnamese', 0),
('xx-lolspea', 'Lolspeak', 0),
('zh-hans', 'Chinese, Simplified', 0),
('zh-hant', 'Chinese, Traditional', 0),
('zh-hk', 'Hong Kong Cantonese', 0);

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `menus`
--

CREATE TABLE `menus` (
`mid` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Data dump for tabellen `menus`
--

INSERT INTO `menus` (`mid`, `name`) VALUES
(1, 'Main Menu');

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `menu_links`
--

CREATE TABLE `menu_links` (
`mlid` int(11) NOT NULL,
  `mid` int(11) NOT NULL COMMENT 'Reference to the menus.mid of the menu holding this link',
  `title` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `parent` int(11) NOT NULL COMMENT 'References the menu_links.mlid of the parent menu link. 0 is root',
  `position` int(11) NOT NULL COMMENT 'Used to order menu links. Lowest first',
  `show` int(11) NOT NULL COMMENT '0=Disabled, 1=Enabled'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Data dump for tabellen `menu_links`
--

INSERT INTO `menu_links` (`mlid`, `mid`, `title`, `link`, `parent`, `position`, `show`) VALUES
(1, 1, 'Home', 'home', 0, 0, 1),
(2, 1, 'Contact', 'contact-us', 0, 1, 1),
(3, 1, 'Social media', 'social-media', 2, 0, 1);

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `modules`
--

CREATE TABLE `modules` (
  `module` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL COMMENT 'Human-readable name of the module',
  `file` varchar(1024) NOT NULL COMMENT 'Path to the primary file of the module. This file will be included when the page is initializing. The path must be relative to the root of the module folder',
  `active` int(11) NOT NULL COMMENT 'Indicates if a moule is activated',
  `core` int(11) NOT NULL COMMENT 'Specifies if a module is located within the core'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Data dump for tabellen `modules`
--

INSERT INTO `modules` (`module`, `name`, `file`, `active`, `core`) VALUES
('krumo', 'Krumo', 'class.krumo.php', 1, 1),
('update', 'Update', 'update.module.php', 1, 1);

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `pages`
--

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Data dump for tabellen `pages`
--

INSERT INTO `pages` (`pid`, `title`, `content`, `author`, `status`, `access`, `keywords`, `description`, `robots`, `created`, `last_updated`) VALUES
(1, 'Home', '<p>This is the homepage</p>', 1, 1, '{"any" : "true"}', 'home', 'This is the homepage', 'index,follow', '2014-08-06', '2014-08-06'),
(2, 'Contact us', '<p>Contact us using the form below</p>', 1, 0, '{"any" : "true"}', 'contact us, contact', 'Contact us today', 'index,follow', '2014-08-12', '2014-08-12'),
(4, 'About us', '<p>Read something about us</p>\r\n', 0, 1, '{"any" : "true"}', 'about us, about my company', 'Read something about us', 'index,follow', '2014-08-19', '2014-08-19');

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `permissions`
--

CREATE TABLE `permissions` (
  `permission` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL COMMENT 'Human-readable name of the permission',
  `description` text NOT NULL COMMENT 'Short description of the permission',
  `rid` text NOT NULL COMMENT 'References the roles.rid of all roles that have this permission',
  `module` varchar(255) NOT NULL COMMENT 'References the module or core component that added this permission'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Data dump for tabellen `permissions`
--

INSERT INTO `permissions` (`permission`, `name`, `description`, `rid`, `module`) VALUES
('access_admin', 'Access Administration pages', 'Allows access the to the administration pages. This permission is required for all administrative tasks', '1;2;3', 'core'),
('access_admin_content', 'Access the list of pages', 'Allows access to the list of content/pages', '1;2;3', 'core_content'),
('access_admin_content_add', 'Add new content', 'Allows access to add new content', '1;2;3', 'core_content'),
('access_admin_content_delete_all', 'Delete all content', 'Delete content created by any user', '1;2', 'core_content'),
('access_admin_content_delete_own', 'Delete own content', 'Delete content created by the current user', '1;2;3', 'core_content'),
('access_admin_content_edit_all', 'Edit all content', 'Edit content created by any user', '1;2', 'core_content'),
('access_admin_content_edit_own', 'Edit own content', 'Edit the content created by the current user', '1;2;3', 'core_content'),
('access_admin_dashboard', 'Access the Administration dashboard', 'Allows access to the administrative dashboard. Settings for individual widgets is required for full usage', '1;2;3', 'core'),
('access_admin_layout', 'Access the layout settings', 'Allows access to layout settings. This permission is required for managing menus, widgets and themes', '1;2', 'core_layout'),
('access_admin_layout_menus', 'Access the list of menus', 'Allows access to the list of menus', '1;2', 'core_layout_menus'),
('access_admin_layout_menus_add', 'Add new menus', 'Allows access to add a new menu', '1;2', 'core_layout_menus'),
('access_admin_layout_menus_delete', 'Delete menus', 'Allows access for deleting a menu', '1;2', 'core_layout_menus'),
('access_admin_layout_menus_items', 'Access the list of menu items for a menu', 'Allows access to the list of menu items in a menu', '1;2', 'core_layout_menus'),
('access_admin_layout_menus_items_add', 'Add new menu items', 'Allows access to add a new menu item', '1;2', 'core_layout_menus'),
('access_admin_layout_menus_items_delete', 'Delete menu items', 'Allows access to delete a menu item for a menu', '1;2', 'core_layout_menus'),
('access_admin_layout_menus_items_edit', 'Edit menu items', 'Allows access to edit menu items for a menu', '1;2', 'core_layout_menus'),
('access_admin_layout_themes', 'Access a list of all installed themes', 'Allows access to list of themes that are inside core/themes and themes', '1;2', 'core_layout_themes'),
('access_admin_layout_themes_change', 'Change the active theme', 'Allows access to change the current site theme.Roles with this permission should also have permission for moving widgets since not all themes have the same sections', '1;2', 'core_layout_themes'),
('access_admin_layout_themes_edit', 'Edit theme files', 'Allows access to edit the files for a theme using the built-in sourcecode-editor', '1', 'core_layout_themes'),
('access_admin_layout_widgets', 'Access the list of widgets', 'Allows access to the list of all widgets', '1;2', 'core_layout_widgets'),
('access_admin_layout_widgets_add', 'Add a new static widget', 'Allows access for adding a new static widget', '1;2', 'core_layout_widgets'),
('access_admin_layout_widgets_delete', 'Delete static widget', 'Allows access for deleting a static widget. Dynamic widgets are managed by the module which installed them', '1;2', 'core_layout_widgets'),
('access_admin_layout_widgets_edit', 'Edit widgets', 'Edit settings for widgets. This is the global setting. If a module has a separate permission for widget settings it will override this permission. Static widgets will always follow this permission', '1;2', 'core_layout_widgets'),
('access_admin_layout_widgets_move', 'Change the order of the widgets', 'Allows access to rearrange the widgets for the current layout', '1;2', 'core_layout_widgets'),
('access_admin_modules', 'Access the list of modules', 'Allows access to the list of all modules inside core/modules and modules', '1', 'core_modules'),
('access_admin_modules_add', 'Add a new module', 'Allows access to add a new module into the modules-folder', '1', 'core_modules'),
('access_admin_modules_disable', 'Disable a module', 'Allows access to disable a module', '1', 'core_modules'),
('access_admin_modules_enable', 'Enable a module', 'Allows access to enable an installed module', '1', 'core_modules'),
('access_admin_modules_install', 'Install a module', 'Allows access to install a new module', '1', 'core_modules'),
('access_admin_modules_uninstall', 'Uninstall af module', 'Allows access to uninstall a module. In order to uninstall a module the role will also need permission to disable a module', '1', 'core_modules'),
('access_admin_modules_update', 'Access the Update module', 'Allows access to use the Update module', '1;2', 'core_modules'),
('access_admin_modules_update_check', 'Check for updates', 'Allows access for checking update status for other modules', '1;2', 'core_modules'),
('access_admin_modules_update_core', 'Access updates for the system core', 'Allows access for viewing and updating the system core', '1', 'core_modules'),
('access_admin_modules_update_install', 'Install updates for a module', 'Allows access for updating a module', '1;2', 'core_modules'),
('access_admin_modules_update_list', 'See a list of updateable modules', 'Allows access to a list of modules that have pending updates', '1;2', 'core_modules'),
('access_admin_reports', 'Access the report viewer', 'Allows access to viewing reports for various parts of the system', '1;2', 'core_reports'),
('access_admin_settings', 'Access settings', 'Allows access to the settings of the site. This permission is required for any access to the site settings', '1;2', 'core_settings'),
('access_admin_settings_content_wysiwyg', 'Access settings for WYSIWYG editors', 'Allows access for changing the settings for WYSIWYG editors. By default this permission affects all WYSIWYG editors including 3rd party editors for 3rd party modules. 3rd party modules can however overwrite this permission with a custom permission that would also be required for editing the settings for the specific editor', '1;2', 'core_settings'),
('access_admin_settings_cron', 'Access cron settings', 'Allows access to change cron settings and manually run cron tasks', '1;2', 'core_settings'),
('access_admin_settings_development', 'Access developer settings', 'Allows access for the developer settings. This permission is required for using the krumo module alongside with the permission for the krumo module', '1', 'core_settings'),
('access_admin_settings_development_maintenance', 'Access maintenance settings', 'Allows access for managing the maintenance mode', '1;2', 'core_settings'),
('access_admin_settings_language', 'Access language and regional settings', 'Allows access for changing the global settings for language and regional settings', '1;2', 'core_settings'),
('access_admin_settings_language_translate', 'Access the translation console for the user interface', 'Allows access for the translation console in order to see all strings that can be translated and see the translation for the current primary language', '1;2;3', 'core_settings'),
('access_admin_settings_language_translate_edit', 'Translate the user interface', 'Allows access for editing translations in the translation console. This permission requires the permission for accessing the translation console', '1;2;3', 'core_settings'),
('access_admin_settings_search_errorpages', 'Access settings for Error pages', 'Allows access for using custom error pages', '1;2', 'core_settings'),
('access_admin_settings_search_metadata', 'Access global settings for metadata', 'Allows access for changing the global site settings regard metadata', '1;2;3', 'core_settings'),
('access_admin_settings_search_redirect', 'Access settings for URL redirects', 'Allows access for changing settings for the URL redirecting, such as preserving old aliases and how they should redirect to the correct page', '1;2', 'core_settings'),
('access_admin_settings_system', 'Access system settings', 'Allows access to the system settings', '1;2', 'core_settings'),
('access_admin_settings_system_email', 'Access system settings for emails', 'Allows access for changing email settings such as SMTP-server, username and password', '1;2', 'core_settings'),
('access_admin_settings_system_email_smtp', 'Access system settings for configuring the smtp settings', 'Allows access for changing email settings such as SMTP-server, username and password', '1;2', 'core_settings'),
('access_admin_settings_system_systemcheck', 'Access systemcheck', 'Allows access for checking the system health', '1', 'core_settings'),
('access_admin_settings_system_users', 'Access system settings for users', 'Allows access for global user settings', '1', 'core_settings'),
('access_admin_users', 'Access the list of users', 'Allows access to the list of all created users', '1;2', 'core_users'),
('access_admin_users_add', 'Add a new user', 'Allows access for creating a new user', '1;2', 'core_users'),
('access_admin_users_add_admin', 'Add a user to the adminstrators role', 'Allows the role to create users with the administrators user role', '1', 'core_users'),
('access_admin_users_add_editor', 'Add a user to the editor role', 'Allows the role to create users with the editor user role', '1;2', 'core_users'),
('access_admin_users_add_user', 'Add a user to the normal user role', 'Allows the role to create users with the normal user role', '1;2', 'core_users'),
('access_admin_users_add_webmaster', 'Add a user to the webmaster role', 'Allows the role to create users with the webmaster user role', '1', 'core_users'),
('access_admin_users_change_password', 'Change any users password', 'Change the password for any user. For this permission to work it requires the permission for editng any user account', '1;2', 'core_users'),
('access_admin_users_change_password_own', 'Change own password', 'Change your own password. This permission requires the permission for editing your own user settings', '1;2', 'core_users'),
('access_admin_users_delete', 'Delete a user', 'Allows access for deleting user accounts', '1', 'core_users'),
('access_admin_users_disable', 'Disable a user', 'Allows access for disabling user accounts. Please note that the system administrator cannot be disabled', '1;2', 'core_users'),
('access_admin_users_edit_all', 'Edit a user', 'Allows access for editing a user', '1;2', 'core_users'),
('access_admin_users_edit_own', 'Edit own user', 'Allows access for editing own user settings', '1;2', 'core_users'),
('access_admin_users_enable', 'Enable a user', 'Allows access for enabling user accounts', '1;2', 'core_users'),
('access_admin_users_permissions', 'Access the list of user role permissions', 'Allows access to view the list of all permissions created for this site', '1;2', 'core_users'),
('access_admin_users_permissions_change', 'Change permissions', 'Allows access for changing permissions. Only give this permission to administrators', '1', 'core_users'),
('access_admin_users_roles', 'Access the list of user roles', 'Allows access to view the list of all user roles', '1;2', 'core_users'),
('access_admin_users_roles_add', 'Add a new user role', 'Allows access for adding new user roles. In order for this to work properly you will need permission for changing user role permissions', '1', 'core_users'),
('access_admin_users_roles_delete', 'Delete a user role', 'Allows access for deleting a user role', '1', 'core_users'),
('access_admin_users_roles_edit', 'Edit a user role', 'Allows access for editng a user role. Note that this permission only grants access for changing the name of the user role', '1', 'core_users');

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `roles`
--

CREATE TABLE `roles` (
`rid` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `position` int(11) NOT NULL COMMENT 'Used to order the roles when listing them to the user/administrator'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Data dump for tabellen `roles`
--

INSERT INTO `roles` (`rid`, `name`, `position`) VALUES
(1, 'Administrator', 0),
(2, 'Webmaster', 1),
(3, 'Editor', 2),
(4, 'User', 3);

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `sessions`
--

CREATE TABLE `sessions` (
  `uid` int(11) NOT NULL COMMENT 'References the users.uid of the users session',
  `sid` varchar(128) NOT NULL COMMENT 'A hashed session ID generated by core',
  `ssid` varchar(128) NOT NULL COMMENT 'Secure session ID generated by core',
  `hostname` varchar(255) NOT NULL COMMENT 'The IP address that last used this session ID',
  `timestamp` int(11) NOT NULL COMMENT 'The UNIX timestamp when this session last requested a page',
  `session` text NOT NULL COMMENT 'JSON-array of session properties and values that need to be initialized on page load'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `sysguard`
--

CREATE TABLE `sysguard` (
`sid` int(11) NOT NULL,
  `header` varchar(255) NOT NULL COMMENT 'A short description of the event. Fx 404 Page not found',
  `details` text NOT NULL COMMENT 'A detailed description of the unique event',
  `module` varchar(255) NOT NULL COMMENT 'Machine-name of the module that created the error. All core components use core as the module. Note that 404, 403 and 500 erros will show as core, unless a specific module generates the event themselves',
  `uid` int(11) NOT NULL COMMENT 'users.uid of the user performing the event that gets logged. If the users.uid is 0 it means anonymous user',
  `ref` text NOT NULL COMMENT 'URL of where the event happened',
  `timestamp` int(11) NOT NULL COMMENT 'UNIX Timestamp of the event'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Data dump for tabellen `sysguard`
--

INSERT INTO `sysguard` (`sid`, `header`, `details`, `module`, `uid`, `ref`, `timestamp`) VALUES
(1, 'Log cleared by user', 'The system log has been cleared by the user Kenneth Hansen', 'core', 1, 'http://cms3.khit.dev/admin/reports/sysguard/clear', 1409198808),
(2, 'Page not found', 'The page http://cms3.khit.dev/mypages-2014/test was not found', 'page-not-found', 0, 'http://cms3.khit.dev/mypages-2014/test', 1409198879),
(3, 'Cron executed', 'Cron tasks have been executed', 'cron', 0, '', 1409248797),
(4, 'Access Denied', 'Access to the page was denied', 'access-denied', 0, 'http://cms3.khit.dev/admin', 1409285027);

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `system_definitions`
--

CREATE TABLE `system_definitions` (
  `definition` varchar(255) NOT NULL COMMENT 'Machine name of the definition',
  `name` varchar(512) NOT NULL COMMENT 'Human readable name of the definition',
  `options` text NOT NULL COMMENT 'JSON-array of options and human readable values'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Data dump for tabellen `system_definitions`
--

INSERT INTO `system_definitions` (`definition`, `name`, `options`) VALUES
('4D', '4D', ''),
('create_user', 'Create useraccounts', '{"0" : "Only admin can create new users","1" : "Users can create an account, but it requires approval from admin","2" : "Users can create an account without approval from admin"}'),
('cubrid', 'Cubrid', ''),
('dblib', 'FreeTDS', ''),
('firebird', 'Firebird', ''),
('ibm', 'IBM DB2', ''),
('informix', 'IBM Informix Dynamic Server', ''),
('mssql', 'Microsoft SQL', ''),
('mysql', 'MySQL', ''),
('oci', 'Oracle Call Interface', ''),
('odbc', 'ODBC v3 (IBM DB2, unixODBC and win32 ODBC)', ''),
('pgsql', 'PostgreSQL', ''),
('site_home', 'Site homepage', ''),
('site_language', 'Site language', ''),
('site_name', 'Site name', ''),
('site_slogan', 'Site slogan', ''),
('site_theme', 'Site theme', ''),
('sqlite', 'SQLite', ''),
('sqlsrv', 'Microsoft SQL / SQL Azure', ''),
('sybase', 'Sybase', '');

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `translation`
--

CREATE TABLE `translation` (
`tid` int(11) NOT NULL,
  `string` text NOT NULL,
  `translation` text NOT NULL,
  `language` varchar(10) NOT NULL COMMENT 'References the languages.code for the language in which the string has been translated'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=471 ;

--
-- Data dump for tabellen `translation`
--

INSERT INTO `translation` (`tid`, `string`, `translation`, `language`) VALUES
(1, 'Please <a href="http://browsehappy.com/"> upgrade your browser</a> or', 'Opgradér venligst din <a href="http://browsehappy.com/">browser</a> eller', 'da'),
(2, 'Warning', 'Advarsel', 'da'),
(3, 'Dashboard', 'Dashboard', 'da'),
(4, 'Content', 'Indhold', 'da'),
(5, 'Layout', 'Layout', 'da'),
(6, 'Modules', 'Moduler', 'da'),
(7, 'Users', 'Brugere', 'da'),
(8, 'Settings', 'Indstillinger', 'da'),
(9, 'Log out', 'Log ud', 'da'),
(10, 'Signed in as', 'Logget ind som', 'da'),
(11, 'Edit', 'Rediger', 'da'),
(12, 'Delete', 'Slet', 'da'),
(13, 'Published', 'Udgivet', 'da'),
(14, 'Site configuration', 'Generel opsætning', 'da'),
(15, 'Use this setting to configure generic site settings such as sitename and site slogan.', 'Brug denne side til at konfigurere generelle indstillinger for hjemmesiden såsom sidens navn og slogan.', 'da'),
(16, 'Performance', 'Ydelse', 'da'),
(17, 'Use this setting to configure performance settings and caching.', 'Brug denne side til at konfigurere ydelse og caching.', 'da'),
(18, 'System check', 'Systemtjek', 'da'),
(19, 'Check if all files and folders exist and if they have the correct permissions.', 'Tjek om alle filer og mapper findes og om de har de korrekte tilladelser.', 'da'),
(20, 'WYSIWYG settings', 'Indstillinger for WYSIWYG', 'da'),
(21, 'Configure the built-in CKEditor.', 'Konfigurér den indbyggede CKEditor.', 'da'),
(22, 'Development Mode', 'Udviklingstilstand', 'da'),
(23, 'Enable or disable Development Mode.', 'Aktiver eller deaktiver udviklingstilstand.', 'da'),
(24, 'Maintenance', 'Vedligeholdelse', 'da'),
(25, 'Configure maintenance mode for the website and enable/disable maintenance mode.', 'Konfigurér vedligeholdelse på hjemmeside og aktiver/deaktiver vedligeholdelsestilstand.', 'da'),
(26, 'URL Redirect', 'Viderestilling af URL', 'da'),
(27, 'Configure URL Redirect of different types', 'Konfigurér forskellige typer af viderestilling af URL', 'da'),
(28, 'Meta-tags', 'Meta-tags', 'da'),
(29, 'Configure metadata for the entire site. Change settings for search robots.', 'Konfigurér overordnede metadata for hele websitet og skift indstillinger for søgerobotter.', 'da'),
(30, 'Language', 'Sprog', 'da'),
(31, 'Configure website language.', 'Indstil sidens aktive sprog', 'da'),
(32, 'Translation', 'Oversættelse', 'da'),
(33, 'Use the translation console to translate strings from modules and themes into active site language.', 'Brug oversættelsespanelet til at oversætte tekst fra moduler og temaer', 'da'),
(34, 'System', 'System', 'da'),
(35, 'Content Mangement', 'Indholdsstyring', 'da'),
(36, 'Development & maintenance', 'Udvikling & vedligeholdelse', 'da'),
(37, 'Search &amp; Metadata', 'Søgning & Metadata', 'da'),
(38, 'Regional', 'Regionale indstillinger', 'da'),
(39, 'Admin', 'Admin', 'da'),
(40, 'Edit User', 'Rediger bruger', 'da'),
(41, 'Delete User', 'Slet bruger', 'da'),
(42, 'Disable User', 'Deaktiver bruger', 'da'),
(43, 'You have been logged out', 'Du er blevet logget ud', 'da'),
(44, 'Welcome', 'Velkommen', 'da'),
(45, 'You''ve been successfully logged in', 'Du er blevet logget ind', 'da'),
(46, 'You are using an <strong>outdated</strong> browser', 'Du bruger en <strong>gammel</strong> browser', 'da'),
(47, 'activate Google Chrome Frame', 'aktiver Google Chrome Frame', 'da'),
(48, 'to improve your experience', 'for at forbedre oplevelsen', 'da'),
(49, 'This code is taken from', 'Denne kode er kopieret fra', 'da'),
(50, 'Newest pages', 'Nyeste sider', 'da'),
(51, 'Page Title', 'Side titel', 'da'),
(52, 'Author', 'Forfatter', 'da'),
(53, 'Actions', 'Handlinger', 'da'),
(54, 'New Users', 'Nye brugere', 'da'),
(55, 'Title', 'Titel', 'da'),
(56, 'Status', 'Status', 'da'),
(57, 'Last updated', 'Sidst opdateret', 'da'),
(58, 'Add page', 'TIlføj side', 'da'),
(59, 'Create new page', 'Opret ny side', 'da'),
(60, 'Body', 'Brødtekst', 'da'),
(61, 'Metadata', 'Metadata', 'da'),
(62, 'URL Alias', 'URL Alias', 'da'),
(63, 'Menu', 'Menu', 'da'),
(64, 'Publish', 'Udgiv', 'da'),
(65, 'Meta Keywords', 'Nøgleord', 'da'),
(66, 'Meta Description', 'Beskrivelse', 'da'),
(67, 'Index', 'Indeksér', 'da'),
(68, 'Follow', 'Følg', 'da'),
(71, 'No Index', 'Ingen indeksering', 'da'),
(72, 'No Follow', 'Ingen Følg', 'da'),
(73, 'Add Menu Item', 'Tilføj menupunkt', 'da'),
(74, 'Select Menu', 'Vælg menu', 'da'),
(75, 'Unpublished', 'Ikke udgivet', 'da'),
(76, 'Login required', 'Login påkrævet', 'da'),
(77, 'Admin only', 'Kun administratorer', 'da'),
(78, 'Close', 'Luk', 'da'),
(79, 'Please select the item you want to manage below.', 'Vælg venligst et af nedenstående punkter.', 'da'),
(80, 'Menus', 'Menuer', 'da'),
(81, 'Themes', 'Temaer', 'da'),
(82, 'Name', 'Navn', 'da'),
(83, 'Username', 'Brugernavn', 'da'),
(84, 'Email', 'E-mail', 'da'),
(85, 'User Group', 'Brugergruppe', 'da'),
(86, 'Create new user', 'Opret ny bruger', 'da'),
(87, 'Create new User Account', 'Opret ny brugerkonto', 'da'),
(88, 'Email address', 'E-mail adresse', 'da'),
(89, 'Password', 'Adgangskode', 'da'),
(90, 'User', 'Bruger', 'da'),
(91, 'Create new account', 'Opret ny konto', 'da'),
(92, 'Search & Metadata', 'Søgning & Metadata', 'da'),
(93, 'View links', 'Vis links', 'da'),
(94, 'Edit menu', 'Rediger menu', 'da'),
(95, 'Delete menu', 'Slet menu', 'da'),
(96, 'You have been successfully logged in', 'Du er blevet logget ind', 'da'),
(97, 'Please proceed to', 'Fortsæt til', 'da'),
(98, 'the administrative interface', 'det administrative interface', 'da'),
(99, 'Please sign in', 'Log ind', 'da'),
(100, 'Remember me', 'Husk mig', 'da'),
(101, 'Sign in', 'Log på', 'da'),
(102, 'Edit page', 'Rediger side', 'da'),
(103, 'Save changes', 'Gem ændringer', 'da'),
(104, 'Cancel', 'Annuller', 'da'),
(105, 'Delete content', 'Slet indhold', 'da'),
(106, 'Are you sure that you want to delete', 'Er du sikker på at du vil slette', 'da'),
(107, 'Delete page', 'Slet side', 'da'),
(108, 'Go Back', 'Gå tilbage', 'da'),
(109, 'Error', 'Fejl', 'da'),
(110, 'Translate', 'Oversæt', 'da'),
(111, 'String', 'Streng', 'da'),
(112, 'Original string', 'Original streng', 'da'),
(113, 'Translated string', 'Oversat streng', 'da'),
(114, 'Translation has been successfully updated', 'Oversættelsen er blevet gemt', 'da'),
(115, 'Page has been successfully updated', 'Siden er blevet opdateret', 'da'),
(116, 'Widgets', 'Widgets', 'da'),
(117, 'Maintenance Mode', 'Vedligeholdelsestilstand', 'da'),
(118, 'On this page you can enable or disable the maintenance mode for this website. You will also be able to specify if the maintenance applies to the site and the database and to define a custom message that will be shown to the visitors', 'På denne side kan du aktivere eller deaktivere vedligeholdelsestilstanden på websitet. Du kan også specificere om vedligeholdelse kun er på selve siden eller om den påvirker databasen. Det er muligt at definere en besked der vises til besøgende.', 'da'),
(119, 'Enable Maintenance Mode', 'Aktiver vedligeholdelsestilstand', 'da'),
(120, 'Maintenance message', 'Besked under vedligeholdelse', 'da'),
(121, 'Email settings', 'E-mail indstillinger', 'da'),
(122, 'Configure settings for the system to use when sending email.', 'Konfigurér indstillinger der anvendes af systemet til udsendelse af e-mail.', 'da'),
(123, 'Site name', 'Sidens navn', 'da'),
(124, 'Enter the website name. This is often a human readable name or the domain', 'Indtast websitets navn. Dette er oftest i firmanavn eller domænet', 'da'),
(125, 'Site slogan', 'Site slogan', 'da'),
(126, 'If your site has a slogan this will be entered here. Please note that the slogan will only be displayed in the browser title if the active theme is printing it on the page', 'Hvis din side har et slogan/motto så kan du indtaste det her. Bemærk at dit slogan/motto kun vil blive vist i browserens titel hvis det aktive tema tillader det.', 'da'),
(127, 'Site frontpage', 'Forside', 'da'),
(128, 'Enter the relative path for the page that you want to use', 'Indtast den relative sti til den side du ønsker at bruge som forside', 'da'),
(129, 'Under development', 'Under udvikling', 'da'),
(130, 'Configure global settings for users and select how new users can be created.', 'Konfigurér globale indstillinger for brugere og vælg hvordan nye brugere oprettes.', 'da'),
(131, 'We are sorry, but the dashboard is currently unavailable on mobile devices.', 'Vi beklager, men dashboardet er ikke tilgængeligt for mobile enheder på nuværende tidspunkt.', 'da'),
(132, 'There was an error when trying to log you in', 'Der opstod en fejl i forsøget på at logge dig ind', 'da'),
(133, 'Service unavailable', 'Servicen er ikke tilgængelig', 'da'),
(134, 'Site maintenance in progress', 'Siden er under vedligeholdelse', 'da'),
(135, 'Sorry, but the website is currently undergoing maintenance', 'Beklager, men der foretages vedligeholdelse af siden', 'da'),
(136, 'Please check back later', 'Prøv venligst igen senere', 'da'),
(137, 'Please visit us back later', 'Besøg os venligst igen senere', 'da'),
(138, 'the frontpage', 'forsiden', 'da'),
(139, 'No advanced site information was collected from database', 'Der blev ikke overført nogen udvidet opsætning fra databasen', 'da'),
(140, 'Edit menu item', 'Rediger menupunkt', 'da'),
(141, 'Delete menu item', 'Slet menupunkt', 'da'),
(193, 'Link', 'Link', 'da'),
(194, 'Change password', 'Skift kodeord', 'da'),
(195, 'Current password', 'Nuværende kodeord', 'da'),
(196, 'New password', 'Nyt kodeord', 'da'),
(197, 'Confirm new password', 'Bekræft nyt kodeord', 'da'),
(198, 'Use this theme', 'Brug dette tema', 'da'),
(199, 'Apply theme', 'Anvend tema', 'da'),
(200, 'Are you sure that you want to change the active theme to', 'Er du sikker på at du vil ændre det aktive tema til', 'da'),
(201, 'Previous', 'Forrige', 'da'),
(202, 'Next', 'Næste', 'da'),
(203, 'Only admin can create new users', 'Kun administratorer kan oprette nye brugere', 'da'),
(204, 'Users can create an account, but it requires approval from admin', 'Brugere kan oprette en konto, men den skal godkendes af en administrator', 'da'),
(205, 'Users can create an account without approval from admin', 'Brugere kan oprette en konto uden administratorens godkendelse', 'da'),
(206, 'Save', 'Gem', 'da'),
(207, 'Here you can either enable or disable the built-in CKEditor. CKEditor is a Graphical editor for textareas which makes you create content like in any other texteditor.', 'Her kan du enten aktivere eller deaktivere den indbygende CKEditor. CKEditor er et grafisk værktøj til tekstområder, som muliggør oprettelse af indhold ligesom i et hvilket som helst tekstbehandlingsprogram.', 'da'),
(208, 'Enable CKEditor', 'Aktivér CKEditor', 'da'),
(209, 'Enable Development Mode', 'Aktivér udviklingstilstand', 'da'),
(210, 'Use Development Mode to enable the usage of developer modules.', 'Brug udviklingstilstand til at aktivere brugen af udviklermoduler.', 'da'),
(211, 'Widget', 'Widget', 'da'),
(212, 'Section', 'Sektion', 'da'),
(213, 'There are no widgets in this section', 'Der er ingen widgets i denne sektion', 'da'),
(214, 'Inactive', 'Inaktiv', 'da'),
(215, 'There are no inactive widgets', 'Der er ingen inaktive widgets', 'da'),
(216, 'Select', 'Vælg', 'da'),
(217, 'Create new widget', 'Opret ny widget', 'da'),
(218, 'Confirmation', 'Bekræftelse', 'da'),
(219, 'Menu items', 'Menupunkter', 'da'),
(220, 'This is your current theme', 'Dette er dit nuværende tema', 'da'),
(221, 'Systemcheck', 'Systemtjek', 'da'),
(222, 'Interface translation is not available on mobile devices and screens with low resolution.', 'Oversættelse af brugerfladen er ikke tilgængelig på mobile enheder og skærme med lav opløsning.', 'da'),
(223, 'Manage menus and menu items', 'Administrer menuer og menupunkter', 'da'),
(224, 'Install new themes and change your active theme', 'Installer nye temaer og skift til aktuelle tema', 'da'),
(225, 'Manage your widgets', 'Administrer dine widgets', 'da'),
(226, 'Developer mode enabled', 'Udviklingstilstand er aktiveret', 'da'),
(228, 'Install', 'Installer', 'da'),
(229, 'Configure', 'Konfigurer', 'da'),
(230, 'Uninstall', 'Afinstaller', 'da'),
(231, 'Enable', 'Aktiver', 'da'),
(232, 'No modules were loaded. Expected array.', 'Ingen moduler blev indlæst. Der var forventet et array', 'da'),
(233, 'Install module', 'Installer modul', 'da'),
(234, 'Are you sure that you want to install', 'Er du sikker på at du vil installere', 'da'),
(235, 'Enable module', 'Aktiver modul', 'da'),
(236, 'Are you sure that you want to enable', 'Er du sikker på at du ønsker at aktivere', 'da'),
(237, 'Sorry, but the requested page does not exist', 'Desværre, men den forespurgte side findes ikke', 'da'),
(238, 'Would you like to go', 'Ønsker du at gå', 'da'),
(239, 'home', 'hjem', 'da'),
(240, 'Manage automatic site maintenance tasks.', 'Håndtér automatiske vedligeholdelsesopgaver.', 'da'),
(241, 'Cron', 'Cron', 'da'),
(242, 'Cron takes care of running periodic tasks like checking for updates and indexing content for search.', 'Cron tager sig af at køre periodiske opgaver som f.eks. at søge efter opdatering og at indeksere indhold til søgning.', 'da'),
(243, 'Run cron', 'Kør cron', 'da'),
(244, 'never', 'aldrig', 'da'),
(245, 'hour', 'time', 'da'),
(246, 'hours', 'timer', 'da'),
(247, 'day', 'dag', 'da'),
(248, 'Run cron automatically each', 'Kør automatisk cron hver', 'da'),
(249, 'Cron has been completed', 'Cron er blevet gennemført', 'da'),
(250, 'We were unable to apply the theme', 'Vi kunne ikke anvende temaet', 'da'),
(251, 'The menu-item has been deleted', 'Menupunktet er blevet slettet', 'da'),
(252, 'An error occurred while trying to submit the form', 'Der opstod en fejl i forsøget på at indsende formularen', 'da'),
(253, 'Not found', 'Ikke fundet', 'da'),
(254, 'The file does not exists', 'Filen findes ikke', 'da'),
(255, 'There was an error while processing the request', 'Der opstod en fejl under behandling af forespørgslen', 'da'),
(256, 'There was an error while querying the pagedata', 'Der opstod en fejl under forespørgsel af indholdsdata', 'da'),
(257, 'There was an error while querying the userdata', 'Der opstod en fejl under forespørgsel af brugerdata', 'da'),
(258, 'There was an error while querying the menudata', 'Der opstod en fejl under forespørgsel af menudata', 'da'),
(259, 'There was an error while querying the menu items', 'Der opstod en fejl under forespørgsel af menupunkter', 'da'),
(260, 'There was an error while deleting the page', 'Der opstod en fejl i forbindelse med sletning af siden', 'da'),
(261, 'Page does not exist or URL was not typed correctly', 'Siden findes ikke eller URL-adressen er forkert', 'da'),
(262, 'All attached menu items have been deleted', 'Alle tilknyttede menupunkter er blevet slettet', 'da'),
(263, 'There was an error while deleting the menu items', 'Der opstod en fejl i forbindelse med sletning af menupunkterne', 'da'),
(264, 'The menu has been deleted', 'Menuen er blevet slettet', 'da'),
(265, 'There was an error while deleting the menu', 'Der opstod en fejl i forbindelse med sletning af menuen', 'da'),
(266, 'Menu does not exist or URL was not typed correctly', 'Menuen findes ikke eller URL-adressen er skrevet forkert', 'da'),
(267, 'There was an error while deleting the menu item', 'Der opstod en fejl i forbindelse med sletning af menupunktet', 'da'),
(268, 'Menu item does not exist or URL was not typed correctly', 'Menupunktet findes ikke eller URL-adressen er skrevet forkert', 'da'),
(269, 'The password has been successfully changed.', 'Adgangskoden er blevet ændret.', 'da'),
(270, 'The current password does not match', 'Den nuværende adgangskode er forkert', 'da'),
(271, 'The passwords do not match', 'Adgangskoderne er ikke ens', 'da'),
(272, 'There was an error while updating the site configuration', 'Der opstod en fejl i forbindelse med opdatering af sidens konfiguration', 'da'),
(273, 'There was an error while deleting the user', 'Der opstod en fejl i forbindelse med sletning af brugeren', 'da'),
(274, 'User does not exist or URL was not typed correctly', 'Brugeren findes ikke eller URL-adressen er skrevet forkert', 'da'),
(275, 'Site information has been updated', 'Sidens informationer er blevet opdateret', 'da'),
(276, 'Changes have been saved', 'Ændringerne er blevet gemt', 'da'),
(277, 'There was an error while updating the content configuration', 'Der opstod en fejl i forbindelse med opdatering af indholdskonfigurationen', 'da'),
(278, 'There was an error while updating the settings', 'Der opstod en fejl i forbindelse med opdateringer af indstillingerne', 'da'),
(279, 'Settings were successfully updated', 'Indstillingerne er blevet opdateret', 'da'),
(280, 'Invalid argument supplied by function', 'Funktionen har tilføjet et ugyldigt argument', 'da'),
(281, 'Something went wrong and the form elements cannot be displayed', 'Der gik noget galt og formularelementerne kan ikke vises', 'da'),
(282, 'Something went wrong and the form cannot be displayed', 'Der gik noget galt og formularen kan ikke vises', 'da'),
(283, 'There was an error creating the new page', 'Der opstod en fejl i forbindelse med oprettelse af den nye side', 'da'),
(284, 'There was an error creating the new menu item', 'Der opstod en fejl i forbindelse med oprettelse af det nye menupunkt', 'da'),
(285, 'Menu item has been saved succesfully', 'Menupunktet er blevet gemt', 'da'),
(286, 'There was an error updating the menu item', 'Der opstod en fejl i forbindelse med opdatering af menupunktet', 'da'),
(287, 'There was an error updating the page', 'Der opstod en fejl i forbindelse med opdatering af siden', 'da'),
(288, 'There was an error while generating the pagelist. Please contact your administrator if this error persists', 'Der opstod en fejl under oprettelse af indholdslisten. Kontakt venligst din administrator hvis problemet fortsætter', 'da'),
(289, 'Invalid', 'Ugyldig', 'da'),
(290, 'There was an error while getting the site configuration. Please contact your administrator if this error persists.', 'Der var en fejl under hentning af sidens konfiguration. Kontakt venligst din administrator hvis problemet fortsætter.', 'da'),
(291, 'No site information was collected from database', 'Der blev ikke hentet nogen information fra databasen', 'da'),
(292, 'There was an error while getting the detailed site configuration. Please contact your administrator if this error persists.', 'Der opstod en fejl under hentning af den detaljerede sidekonfiguration. Kontakt venligst din administrator hvis problemet fortsætter.', 'da'),
(293, 'No detailed site information was collected from database', 'Der blev ikke hentet detaljeret information fra databasen', 'da'),
(294, 'There was an error while querying the database for the current page', 'Der opstod en fejl i forbindelse med hentning af data for den aktuelle side', 'da'),
(295, 'There was an error while querying the database for the menu with ID:', 'Der opstod en fejl i forbindelse med hentning af data fra databasen for menuen med ID:', 'da'),
(296, 'There was an error while processing the string', 'Der opstod en fejl under behandling af strengen', 'da'),
(297, 'There was an error while processing the translation', 'Der opstod en fejl under behandling af oversættelsen', 'da'),
(298, 'There was an error while getting the language configuration', 'Der opstod en fejl i forbindelse med hentning af sprogkonfigurationen', 'da'),
(299, 'There was an error while querying the translations', 'Der opstod en fejl under hentning af oversættelserne', 'da'),
(300, 'There was an error updating the string', 'Der opstod en fejl under opdatering af strengen', 'da'),
(301, 'The module does not exist', 'Modulet findes ikke', 'da'),
(302, 'The module has been installed', 'Modulet er blevet installeret', 'da'),
(303, 'There was an error while installing the module', 'Der opstod en fejl under installation af modulet', 'da'),
(304, 'The module has been uninstalled', 'Modulet er blevet afinstalleret', 'da'),
(305, 'There was an error while uninstalling the module', 'Der opstod en fejl under afinstallation af modulet', 'da'),
(306, 'There was an error while querying the modules', 'Der opstod en fejl under hentning af modulerne', 'da'),
(307, 'There was an error verifying the existance of the user', 'Der opstod en fejl i forbindelse med verificering af brugerens eksistens', 'da'),
(308, 'There was an error while querying the user', 'Der opstod en fejl i forbindelse med hentning af brugeren', 'da'),
(309, 'There was an error while trying to authenticate and authorize the user', 'Der opstod en fejl i forsøget på at godkende og autorisere brugeren', 'da'),
(310, 'You have been logged out because your account is not activated', 'Der er blevet logget ud da din brugerkonto ikke er aktiveret', 'da'),
(311, 'There was an error while adding the new user', 'Der opstod en fejl under oprettelse af den nye bruger', 'da'),
(312, 'User settings have been updated', 'Brugerindstillingerne er blevet opdateret', 'da'),
(313, 'There was an error while updating the user settings', 'Der opstod en fejl under opdatering af brugerindstillingerne', 'da'),
(314, 'There was an error while enabling the user', 'Der opstod en fejl under aktivering af brugeren', 'da'),
(315, 'There was an error while disabling the user', 'Der opstod en fejl under deaktivering af brugeren', 'da'),
(316, 'There was an error while querying the widgetdata', 'Der opstod en fejl under hentning af widgetdata', 'da'),
(317, 'Enabled', 'Aktiveret', 'da'),
(318, 'Version', 'Version', 'da'),
(319, 'Description', 'Beskrivelse', 'da'),
(320, 'There was an error installing the module', 'Der opstod en fejl under installation af modulet', 'da'),
(321, 'There was an error enabling the module', 'Der opstod en fejl under aktivering af modulet', 'da'),
(322, 'The module', 'Modulet', 'da'),
(323, 'has been enabled', 'er blevet aktiveret', 'da'),
(324, 'Configuration', 'Konfiguration', 'da'),
(325, 'There are no items to show', 'Der er ingen elementer at vise', 'da'),
(326, 'Add new slider', 'Tilføj ny slider', 'da'),
(327, 'Slider name', 'Slider navn', 'da'),
(328, 'Input a name for the new slider', 'Indtast sliderens navn', 'da'),
(329, 'Slider interval', 'Slider interval', 'da'),
(330, 'Input the time interval for how long each slide should be displayed. This must be in milliseconds. Fx. 1 sec = 1000ms', 'Indtast tidsintervallet for hvor længe hver slide skal vises. Dette skal angives i millisekunder. F.eks. 1 sekund = 1000ms', 'da'),
(331, 'Yes', 'Ja', 'da'),
(332, 'No', 'Nej', 'da'),
(333, 'Create slider', 'Opret slider', 'da'),
(334, 'Fade effect', 'Fade effekt', 'da'),
(335, 'Slider active', 'Slider aktiv', 'da'),
(336, 'An error occurred while processing your submission', 'Der opstod en fejl under behandlingen af ​​din indsendelse', 'da'),
(337, 'The new slider was successfully created', 'Den nye slider er blevet oprettet', 'da'),
(338, 'Disable', 'Deaktiver', 'da'),
(339, 'Elements', 'Elementer', 'da'),
(340, 'Image', 'Billede', 'da'),
(341, 'Add new element', 'Tilføj nyt element', 'da'),
(342, 'Sliders', 'Sliders', 'da'),
(343, 'Roles', 'Roller', 'da'),
(344, 'Permission', 'Tilladelse', 'da'),
(345, 'administrator', 'administrator', 'da'),
(346, 'webmaster', 'webmaster', 'da'),
(347, 'editor', 'redaktør', 'da'),
(348, 'Permissions', 'Tilladelser', 'da'),
(349, 'Edit role', 'Rediger rolle', 'da'),
(350, 'Delete role', 'Slet rolle', 'da'),
(351, 'Add role', 'Tilføj rolle', 'da'),
(352, 'permission could not be updated', 'tilladelse kunne ikke opdateres', 'da'),
(353, 'permissions have been updated', 'tilladelser er blevet opdateret', 'da'),
(354, 'permissions have not been updated', 'tilladelser er ikke blevet opdateret', 'da'),
(355, 'Pages', 'Sider', 'da'),
(356, 'Show widget on specific pages', 'Vis widget på bestemte sider', 'da'),
(357, 'All pages except the ones listed', 'Alle sider undtagen de nævnte', 'da'),
(358, 'Only the listed pages', 'Kun de viste sider', 'da'),
(359, 'Choose a section for this widget', 'Vælg en sektion til denne widget', 'da'),
(360, 'This widget will only be shown to the following roles. If no roles are selected it will be shown to all roles', 'Denne widget vil kun blive vist til de følgende roller. Hvis ingen roller er valgt vil den blive vist til alle roller', 'da'),
(361, 'Save widget', 'Gem widget', 'da'),
(362, 'Leave this field unchanged in order to keep current settings', 'Undad at ændre på indholdet i dette felt for at beholde de nuværende indstillinger', 'da'),
(363, 'Delete widget', 'Slet widget', 'da'),
(364, 'An error occurred while creating a new widget', 'Der opstod en fejl under oprettelse af en ny widget', 'da'),
(365, 'Something went wrong. Please check the URL and try again', 'Der gik noget galt. Tjek URL''en og prøv igen', 'da'),
(366, 'General', 'Generelt', 'da'),
(367, 'Mailhost', 'Mailudbyder', 'da'),
(368, 'Insert the address for your SMTP-server. Fx. smtp.example.com', 'Indsæt adressen til din SMTP-server. F.eks. smtp.example.com', 'da'),
(369, 'Input your username for the SMTP-server. This is often your email address', 'Indtast dit brugernavn til SMTP-serveren. Dette er ofte det samme som e-mail adressen', 'da'),
(370, 'Input the password that matches the username above', 'Indtast adgangskoden der passer til ovenstående brugernavn', 'da'),
(371, 'Input the name that will be displayed in the reciepients mailbox. The default value is the site name', 'Indtast det navn der skal vises i modtagerens indbakke. Standardværdien er sitets navn', 'da'),
(372, 'Send from address', 'Send fra adresse', 'da'),
(373, 'Input the address which you want to send emails from', 'Indtast den adresse som du ønsker at sende e-mail fra', 'da'),
(374, 'My server requires SSL encryption', 'Min server kræver SSL kryptering', 'da'),
(375, 'Save settings', 'Gem indstillinger', 'da'),
(376, 'Configure the settings for using a mailserver to send mail from this website', 'Konfigurer indstillingerne for at bruge en mailserver til at sende mail fra hjemmesiden', 'da'),
(377, 'Something went wrong. We could not collect the email configuration', 'Der gik noget galt. Vi kunne ikke hente e-mail opsætningen', 'da'),
(378, 'Insert the address for your SMTP-server. Fx. smtp.example.com. Multiple servers are seperated by semicolon', 'Indsæt adressen til din SMTP-server. F.eks. smtp.example.com. Flere servere skal separares med semikolon', 'da'),
(379, 'My server requires authentication', 'Min server kræver godkendelse', 'da'),
(380, 'You do not have permission to perform this action', 'Du har ikke tilladelse til at udføre denne handling', 'da'),
(381, 'The page has been deleted', 'Siden er blevet slettet', 'da'),
(382, 'New page has been created', 'En ny side er blevet oprettet', 'da'),
(383, 'New menu item has been created', 'Et nyt menupunkt er blevet oprettet', 'da'),
(384, 'Are you sure that you want to disable', 'Er du sikker på at du vil deaktivere', 'da'),
(385, 'the user', 'brugeren', 'da'),
(386, 'has been disabled', 'er blevet deaktiveret', 'da'),
(387, 'Enable User', 'Aktiver bruger', 'da'),
(388, 'the new user', 'den nye bruger', 'da'),
(389, 'has been created', 'er blevet oprettet', 'da'),
(390, 'Error pages', 'Fejlsider', 'da'),
(391, 'Configure custom pages for HTTP errors such as 404, 403 and 500', 'Konfigurer brugerdefinerede sider til HTTP fejl, såsom 404, 403 og 500', 'da'),
(392, 'Administration', 'Administration', 'da'),
(393, 'Download additional modules from other developers in order to extend the functionality of the system', 'Hent yderligere moduler fra andre udviklere for at udvide systemets funktionalitet', 'da'),
(394, 'Review and install updates for enabled modules', 'Gennemse og installér opdateringer til aktiverede moduler', 'da'),
(395, 'Help', 'Hjælp', 'da'),
(396, 'Add content', 'Tilføj indhold', 'da'),
(397, 'Page', 'Side', 'da'),
(398, 'Site', 'Site', 'da'),
(399, 'Go to homepage', 'Gå til forsiden', 'da'),
(400, 'Enter a pattern for the page title. Fx. %page_title | %site_name', 'Indtast et mønster til visning af sidetitler. F.eks. %page_title | %site_name', 'da'),
(401, 'SEO Description', '', 'da'),
(402, 'Enter a default description, which will be used when there has not been entered a description on the page.', '', 'da'),
(403, 'SEO keywords', '', 'da'),
(404, 'Enter a set of keywords which will be used when there are no keywords for a page.', '', 'da'),
(405, 'From', 'Fra', 'da'),
(406, 'Enter an internal path or path alias to redirect (fx. <i>pages/123</i>). Fragment anchors (fx. #anchor) are <strong>not</strong> allowed', '', 'da'),
(407, 'To', 'Til', 'da'),
(408, 'Enter an internal path, path alias or external URL to redirect (fx. <i>pages/123</i> or <i>http://example.com</i>).', '', 'da'),
(409, 'All languages', 'Alle sprog', 'da'),
(410, 'A redirect set for a specific language will always be used when requesting this page in that language, and takes precedence over redirects set for <i>All languages</i>.', '', 'da'),
(411, 'Please provide paths for the error pages below.<br/>Note that there are more error pages than the ones listed below and these will be handled by core since these errors occurs before database access is established', '', 'da'),
(412, 'Error 404: Page not found', '', 'da'),
(413, 'Enter a path for a page which will be shown when a requested page does not exist', '', 'da'),
(414, 'Error 403: Access Denied', '', 'da'),
(415, 'Enter a path for a page which will be shown when a user does not have access to a requested page', '', 'da'),
(416, 'You are using an <strong>outdated</strong> browser Please <a href="@browserhappy"> upgrade your browser</a> or <a href="@chrome_frame_link">activate Google Chrome Frame</a> to improve your experience', '', 'da'),
(417, 'This code is taken from @bootstrap_link', '', 'da'),
(418, 'Add redirect', '', 'da'),
(419, 'All', 'Alle', 'da'),
(420, 'Sorry, the form you have submitted is invalid', '', 'da'),
(421, 'Create new useraccount', '', 'da'),
(422, 'Meta tags', '', 'da'),
(424, '<b>Disclaimer</b>:<br/>All help and documentation for core components will be in English.<br/>Help and documentation for 3rd party modules and themes might be supplied in other languages.', '', 'da'),
(425, 'No modules have implemented help or documentation', '', 'da'),
(426, 'Reports', 'Rapporter', 'da'),
(427, 'System log', 'System log', 'da'),
(428, 'System configuration', '', 'da'),
(429, 'View the system configuration and get information about the server hosting your website', '', 'da'),
(430, 'Status report', '', 'da'),
(431, 'View the status report and get an overview of any issues your site might have', '', 'da'),
(432, 'Latest log messages', '', 'da'),
(433, 'View the latest events from the site log', '', 'da'),
(434, 'Translation overview', '', 'da'),
(435, 'Shows how well the user interface is translated', '', 'da'),
(436, 'Common ''Page not found'' 404 erors', '', 'da'),
(437, 'View a list of URL''s that are returning 404 errors', '', 'da'),
(438, 'Common ''Access denid'' 403 erors', '', 'da'),
(439, 'View a list of URL''s that are returning 403 errors', '', 'da'),
(440, 'The site configuration report is listed below containing both site specific configuration and information about the configuration of the server hosting your website.', '', 'da'),
(441, 'The log is empty', '', 'da'),
(442, 'Recent log messages', '', 'da'),
(443, 'Event details', '', 'da'),
(444, 'Type', '', 'da'),
(445, 'Date', '', 'da'),
(446, 'Referrer', '', 'da'),
(447, 'Message', '', 'da'),
(448, 'Site configuration report', '', 'da'),
(449, 'Value', '', 'da'),
(450, 'Anonymous user', '', 'da'),
(451, '''Page not found'' 404 erors', '', 'da'),
(452, '''Access denid'' 403 erors', '', 'da'),
(453, 'Configuration report', '', 'da'),
(454, 'Site theme', '', 'da'),
(455, 'Site homepage', '', 'da'),
(456, 'Site language', '', 'da'),
(457, 'Create new useraccounts', '', 'da'),
(458, 'Add Redirection', '', 'da'),
(459, 'Create useraccounts', '', 'da'),
(460, 'Webserver', '', 'da'),
(461, 'PHP Version', '', 'da'),
(462, 'Databaseserver', '', 'da'),
(463, 'Databaseserver version', '', 'da'),
(464, 'PHP memory limit', '', 'da'),
(465, 'Cron tasks', '', 'da'),
(466, 'Cron tasks were last executed @date', '', 'da'),
(467, '''Page not found'' errors', '', 'da'),
(468, 'The requested report is unavailable', '', 'da'),
(469, '''Access Denied'' errors', '', 'da'),
(470, 'URL', '', 'da');

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `url_alias`
--

CREATE TABLE `url_alias` (
`aid` int(11) NOT NULL,
  `source` text NOT NULL COMMENT 'The core path to the content. Fx. pages/123',
  `alias` text NOT NULL COMMENT 'The alias for the content referenced in url_alias.source. Fx. title-of-the-story = pages/123',
  `language` varchar(10) NOT NULL DEFAULT '0' COMMENT 'References the languages.code for this alias. If the value is 0 it is applied for all active langauges'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Data dump for tabellen `url_alias`
--

INSERT INTO `url_alias` (`aid`, `source`, `alias`, `language`) VALUES
(1, 'pages/1', 'home', '0'),
(2, 'pages/2', 'contact-us', '0'),
(4, 'pages/4', 'about-us', '0');

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `users`
--

CREATE TABLE `users` (
`uid` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(1024) NOT NULL,
  `role` int(11) NOT NULL DEFAULT '4' COMMENT 'References the roles.rid for the role applied to this user. Default value is for standard user',
  `email` text NOT NULL,
  `name` varchar(255) NOT NULL,
  `language` varchar(10) NOT NULL COMMENT 'References the languages.code for the user''s language',
  `active` int(11) NOT NULL COMMENT 'Specifies if the user account is active'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Data dump for tabellen `users`
--

INSERT INTO `users` (`uid`, `username`, `password`, `role`, `email`, `name`, `language`, `active`) VALUES
(1, 'khansen.it', '$6$$l8/.TOrCIcDRSsJafrqmyvQcCrX0.QYWshdN9QcdKF.zyYz9AiKSf2KZcPP5r.kkF9Tyg3D9A39tbTUYOCul0.', 1, 'kenneth@khansen-it.dk', 'Kenneth Hansen', 'da', 1);

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `widgets`
--

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Data dump for tabellen `widgets`
--

INSERT INTO `widgets` (`wid`, `type`, `title`, `content`, `section`, `position`, `show`, `pages`, `roles`) VALUES
(1, 'dynamic', 'Main Menu', '{"func" : "generateMenu", "param" : "1"}', 'header', 0, 0, NULL, ''),
(2, 'dynamic', 'Primary content', '{"func" : "Page::getInstance", "param" : "0"}', 'content', 0, 0, NULL, ''),
(3, 'static', 'Footer', '<p>&copy; 2014 SITE NAME</p>', 'footer', 0, 0, NULL, '');

--
-- Begrænsninger for dumpede tabeller
--

--
-- Indeks for tabel `config`
--
ALTER TABLE `config`
 ADD PRIMARY KEY (`cid`);

--
-- Indeks for tabel `content_types`
--
ALTER TABLE `content_types`
 ADD PRIMARY KEY (`ctid`);

--
-- Indeks for tabel `fields`
--
ALTER TABLE `fields`
 ADD PRIMARY KEY (`fid`);

--
-- Indeks for tabel `field_values`
--
ALTER TABLE `field_values`
 ADD PRIMARY KEY (`fid`);

--
-- Indeks for tabel `languages`
--
ALTER TABLE `languages`
 ADD PRIMARY KEY (`code`);

--
-- Indeks for tabel `menus`
--
ALTER TABLE `menus`
 ADD PRIMARY KEY (`mid`);

--
-- Indeks for tabel `menu_links`
--
ALTER TABLE `menu_links`
 ADD PRIMARY KEY (`mlid`);

--
-- Indeks for tabel `modules`
--
ALTER TABLE `modules`
 ADD PRIMARY KEY (`module`);

--
-- Indeks for tabel `pages`
--
ALTER TABLE `pages`
 ADD PRIMARY KEY (`pid`);

--
-- Indeks for tabel `permissions`
--
ALTER TABLE `permissions`
 ADD PRIMARY KEY (`permission`);

--
-- Indeks for tabel `roles`
--
ALTER TABLE `roles`
 ADD PRIMARY KEY (`rid`);

--
-- Indeks for tabel `sessions`
--
ALTER TABLE `sessions`
 ADD PRIMARY KEY (`sid`,`ssid`);

--
-- Indeks for tabel `sysguard`
--
ALTER TABLE `sysguard`
 ADD PRIMARY KEY (`sid`);

--
-- Indeks for tabel `system_definitions`
--
ALTER TABLE `system_definitions`
 ADD PRIMARY KEY (`definition`);

--
-- Indeks for tabel `translation`
--
ALTER TABLE `translation`
 ADD PRIMARY KEY (`tid`);

--
-- Indeks for tabel `url_alias`
--
ALTER TABLE `url_alias`
 ADD PRIMARY KEY (`aid`);

--
-- Indeks for tabel `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`uid`);

--
-- Indeks for tabel `widgets`
--
ALTER TABLE `widgets`
 ADD PRIMARY KEY (`wid`);

--
-- Brug ikke AUTO_INCREMENT for slettede tabeller
--

--
-- Tilføj AUTO_INCREMENT i tabel `config`
--
ALTER TABLE `config`
MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- Tilføj AUTO_INCREMENT i tabel `menus`
--
ALTER TABLE `menus`
MODIFY `mid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- Tilføj AUTO_INCREMENT i tabel `menu_links`
--
ALTER TABLE `menu_links`
MODIFY `mlid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- Tilføj AUTO_INCREMENT i tabel `pages`
--
ALTER TABLE `pages`
MODIFY `pid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- Tilføj AUTO_INCREMENT i tabel `roles`
--
ALTER TABLE `roles`
MODIFY `rid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- Tilføj AUTO_INCREMENT i tabel `sysguard`
--
ALTER TABLE `sysguard`
MODIFY `sid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- Tilføj AUTO_INCREMENT i tabel `translation`
--
ALTER TABLE `translation`
MODIFY `tid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=471;
--
-- Tilføj AUTO_INCREMENT i tabel `url_alias`
--
ALTER TABLE `url_alias`
MODIFY `aid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- Tilføj AUTO_INCREMENT i tabel `users`
--
ALTER TABLE `users`
MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- Tilføj AUTO_INCREMENT i tabel `widgets`
--
ALTER TABLE `widgets`
MODIFY `wid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
