<?php
    header("Content-type: text/css; charset: UTF-8");

    $font_unit = 'px';

    $header_bgSrc = $configurations['header_bgSrc'];
    $menu_bgSrc = $configurations['menu_bgSrc'];
    $subMenu_bgSrc = $configurations['subMenu_bgSrc'];
    $body_bgSrc = $configurations['body_bgSrc'];

    $header_bgColor = $configurations['header_bgColor'];
    $menu_bgColor = $configurations['menu_bgColor'];
    $subMenu_bgColor = $configurations['subMenu_bgColor'];
    $body_bgColor = $configurations['body_bgColor'];
    
    // $base_fontSize = $configurations['base_fontSize'];
    $menu_fontSize = $configurations['menu_fontSize'];
    $subMenu_fontSize = $configurations['subMenu_fontSize'];
    // $heading_fontSize = $configurations['heading_fontSize'];
    // $content_fontSize = $configurations['content_fontSize'];

    // $base_fontColor = $configurations['base_fontColor'];
    $menu_fontColor = $configurations['menu_fontColor'];
    $subMenu_fontColor = $configurations['subMenu_fontColor'];
    $heading_fontColor = $configurations['heading_fontColor'];
    // $content_fontColor = $configurations['content_fontColor'];
    
    $menu_fontColor = $configurations['menu_fontColor'];
    $menuLink_fontColor = $configurations['menuLink_fontColor'];
    $menuHLink_fontColor = $configurations['menuHLink_fontColor'];
    $menuALink_bgColor = $configurations['menuALink_bgColor'];
?>

header {
<?php if(isset($header_bgSrc)):?>
background:url(<?php echo WebTemplateForm::getUploadURL('custom', $header_bgSrc) ?>) no-repeat;
<?php else:?>
background:none;
<?php endif; ?>
<?php if(isset($header_bgColor)):?>background-color: <?php echo $header_bgColor ?>;<?php endif; ?>
<?php if(isset($heading_fontColor)):?>color: <?php echo $heading_fontColor ?>;<?php endif; ?>
}
main {
<?php if(isset($body_bgSrc)):?>
background:url(<?php echo WebTemplateForm::getUploadURL('custom', $body_bgSrc) ?>) repeat;
<?php else:?>
background:none;
<?php endif; ?>
<?php if(isset($body_bgColor)):?>background-color: <?php echo $body_bgColor ?>;<?php endif; ?>
}
footer {
<?php if(isset($menu_bgSrc)):?>
background:url(<?php echo WebTemplateForm::getUploadURL('custom', $menu_bgSrc) ?>) no-repeat;
<?php else:?>
background:none;
<?php endif; ?>
<?php if(isset($menu_bgColor)):?>
background-color: <?php echo $menu_bgColor ?>;
border-color: <?php echo $menu_bgColor ?>;
<?php if(isset($menu_fontColor)):?>color: <?php echo $menu_fontColor ?>;<?php endif; ?>
<?php if(isset($menu_fontSize)):?>font-size: <?php echo $menu_fontSize . $font_unit ?>;<?php endif; ?>
<?php endif; ?>
}

.subItems {
<?php if(isset($subMenu_bgSrc)):?>
background:url(<?php echo WebTemplateForm::getUploadURL('custom', $subMenu_bgSrc) ?>) no-repeat;
<?php else:?>
background:none;
<?php endif; ?>
<?php if(isset($subMenu_bgColor)):?>
background-color: <?php echo $subMenu_bgColor ?>;
border-color: <?php echo $subMenu_bgColor ?>;
<?php if(isset($subMenu_fontColor)):?>color: <?php echo $subMenu_fontColor ?>;<?php endif; ?>
<?php if(isset($subMenu_fontSize)):?>font-size: <?php echo $subMenu_fontSize . $font_unit ?>;<?php endif; ?>
<?php endif; ?>
}


.navbar-default {
<?php if(isset($menu_bgSrc)):?>
background:url(<?php echo WebTemplateForm::getUploadURL('custom', $menu_bgSrc) ?>) no-repeat;
<?php else:?>
background:none;
<?php endif; ?>
<?php if(isset($menu_bgColor)):?>
background-color: <?php echo $menu_bgColor ?>;
border-color: <?php echo $menu_bgColor ?>;
<?php endif; ?>
<?php if(isset($menu_fontColor)):?>color: <?php echo $menu_fontColor ?>;<?php endif; ?>
<?php if(isset($menu_fontSize)):?>font-size: <?php echo $menu_fontSize . $font_unit ?>;<?php endif; ?>
}
.navbar-default .navbar-text {
<?php if(isset($menu_fontColor)):?>color: <?php echo $menu_fontColor ?>;<?php endif; ?>
}
.navbar-default .navbar-nav > li > a {
<?php if(isset($menu_fontColor)):?>color: <?php echo $menu_fontColor ?>;<?php endif; ?>
}
.navbar-default .navbar-nav > li > a:hover, .navbar-default .navbar-nav > li > a:focus {
<?php if(isset($menuHLink_fontColor)):?>color: <?php echo $menuHLink_fontColor ?>;<?php endif; ?>
}
.navbar-default .navbar-nav > .active > a, .navbar-default .navbar-nav > .active > a:hover, .navbar-default .navbar-nav > .active > a:focus {
<?php if(isset($menuHLink_fontColor)):?>color: <?php echo $menuHLink_fontColor ?>;<?php endif; ?>
<?php if(isset($menuALink_bgColor)):?>background-color: <?php echo $menuALink_bgColor ?>;<?php endif; ?>
}
.navbar-default .navbar-nav > .open > a, .navbar-default .navbar-nav > .open > a:hover, .navbar-default .navbar-nav > .open > a:focus {
<?php if(isset($menuHLink_fontColor)):?>color: <?php echo $menuHLink_fontColor ?>;<?php endif; ?>
<?php if(isset($menuALink_bgColor)):?>background-color: <?php echo $menuALink_bgColor ?>;<?php endif; ?>
}
.navbar-default .navbar-toggle {
<?php if(isset($menuALink_bgColor)):?>background-color: <?php echo $menuALink_bgColor ?>;<?php endif; ?>
}
.navbar-default .navbar-toggle:hover, .navbar-default .navbar-toggle:focus {
<?php if(isset($menuALink_bgColor)):?>background-color: <?php echo $menuALink_bgColor ?>;<?php endif; ?>
}
.navbar-default .navbar-link {
<?php if(isset($menu_fontColor)):?>color: <?php echo $menu_fontColor ?>;<?php endif; ?>
}
.navbar-default .navbar-link:hover {
<?php if(isset($menuHLink_fontColor)):?>color: <?php echo $menuHLink_fontColor ?>;<?php endif; ?>
}

@media (max-width: 767px) {
    .navbar-default .navbar-nav .open .dropdown-menu > li > a {
        <?php if(isset($menu_fontColor)):?>color: <?php echo $menu_fontColor ?>;<?php endif; ?>
    }
    .navbar-default .navbar-nav .open .dropdown-menu > li > a:hover, .navbar-default .navbar-nav .open .dropdown-menu > li > a:focus {
<?php if(isset($menuHLink_fontColor)):?>color: <?php echo $menuHLink_fontColor ?>;<?php endif; ?>
    }
    .navbar-default .navbar-nav .open .dropdown-menu > .active > a, .navbar-default .navbar-nav .open .dropdown-menu > .active > a:hover, .navbar-default .navbar-nav .open .dropdown-menu > .active > a:focus {
<?php if(isset($menuHLink_fontColor)):?>color: <?php echo $menuHLink_fontColor ?>;<?php endif; ?>
<?php if(isset($menuALink_bgColor)):?>background-color: <?php echo $menuALink_bgColor ?>;<?php endif; ?>
    }
}

<?php if(isset($menu_bgColor)):?>
.topic {
border-left-color:<?php echo $menu_bgColor ?>;
}
<?php endif; ?>
