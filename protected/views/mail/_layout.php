<html>
    <head>
    </head>
    <body>
        <?php echo $content; ?>
        <hr/>
        <pre><?php echo Configuration::getKey('email_signature'); ?></pre>
    </body>
</html>