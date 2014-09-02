<body class="texture" style="opacity: 1;">
    <div id="cl-wrapper" class="error-container texture">
        <div class="page-error">
            <h1 class="number text-center">404</h1>
            <h2 class="description text-center"><?php print t('Sorry, but the requested page does not exist'); ?>!</h2>
            <h3 class="text-center"><?php print t('Would you like to go'); ?> <a href="/admin"><?php print t('home'); ?></a>?</h3>
        </div>
        <div class="text-center copy">&copy; <?php print date('Y');?> <a href="/"><?php print Config::get('site/site_name'); ?></a></div>
    </div>
</body>