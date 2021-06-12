<?php defined('BLUDIT') or die('Bludit CMS.');

// Load plugins rules
include(PATH_RULES.'60.plugins.php');

// Plugins before all
Theme::plugins('beforeAll');

// Load rules
include(PATH_RULES.'60.router.php');
include(PATH_RULES.'69.pages.php');
include(PATH_RULES.'99.header.php');
include(PATH_RULES.'99.paginator.php');
include(PATH_RULES.'99.themes.php');

// Plugins before site loaded
Theme::plugins('beforeSiteLoad');

// Theme init.php
if (Sanitize::pathFile(PATH_THEMES, $site->theme().DS.'init.php')) {
	include(PATH_THEMES.$site->theme().DS.'init.php');
}

// Theme HTML
if (Sanitize::pathFile(PATH_THEMES, $site->theme().DS.'index.php')) {
	include(PATH_THEMES.$site->theme().DS.'index.php');
} else {
	echo '<h3 style="text-align: center; margin-top: 2rem;">لطفاً تنظیمات قالب وبسایت را در بخش مدیریت بررسی کنید و یک قالب را فعال کنید.<h3>';
}

// Plugins after site loaded
Theme::plugins('afterSiteLoad');

// Plugins after all
Theme::plugins('afterAll');
