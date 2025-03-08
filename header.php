<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo wp_get_document_title(); ?></title>
    <?php if (timeless_get_site_favicon()) : ?>
    <link rel="icon" href="<?php echo esc_url(timeless_get_site_favicon()); ?>" type="image/x-icon">
    <link rel="shortcut icon" href="<?php echo esc_url(timeless_get_site_favicon()); ?>" type="image/x-icon">
    <?php endif; ?>
    <link rel="stylesheet" href="https://lf6-cdn-tos.bytecdntp.com/cdn/expire-1-M/mdui/1.0.1/css/mdui.min.css">
<link rel="stylesheet" href="https://lf1-cdn-tos.bytecdntp.com/cdn/expire-1-M/MaterialDesign-Webfont/7.2.96/css/materialdesignicons.min.css">
    
    
    <?php wp_head(); ?>
</head>
<body class="mdui-theme-primary-<?php echo esc_attr(get_option('theme_color', 'teal')); ?>" data-theme-color="<?php echo esc_attr(get_option('theme_color', 'teal')); ?>">
    <div id="loading" class="loading">
        <div class="loading-spinner"></div>
    </div>

    <?php if (is_front_page() && !is_paged()) : ?>
        <?php 
        $background_type = get_option('background_type', 'image');
        $home_video = get_option('home_video');
        $home_background = get_option('home_background');
        ?>
        <?php if ($background_type === 'video' && !empty($home_video)) : ?>
        <div class="hero">
            <video id="hero-video" autoplay muted loop playsinline>
                <source src="<?php echo esc_url($home_video); ?>" type="video/mp4">
            </video>
            <div class="hero-overlay"></div>
            <div class="hero-content container">
                <h1><?php bloginfo('name'); ?></h1>
                <p><?php bloginfo('description'); ?></p>
            </div>
        </div>
        <?php elseif ($background_type === 'image' && !empty($home_background)) : ?>
        <div class="home-header" style="background-image: url('<?php echo esc_url($home_background); ?>')">
            <div class="home-header-content">
                <h1 class="home-header-text"><?php echo esc_html(timeless_get_home_text()); ?></h1>
                <a href="#content" class="mdui-btn mdui-btn-raised mdui-ripple mdui-color-theme">浏览文章</a>
            </div>
        </div>
        <?php endif; ?>
    <?php endif; ?>

    <header class="site-header">
        <nav class="pixel-nav mdui-appbar">
          <div class="mdui-container">
            <button class="mdui-btn pixel-btn" id="menu-toggle">
              <i class="mdui-icon material-icons">menu</i>
            </button>
            <span class="mdui-typo-title"><?php bloginfo('name'); ?></span>
          </div>
        </nav>

        <div class="author-section mdui-shadow-10">
          <div class="pixel-frame">
            <?php echo get_avatar(get_the_author_meta('ID'), 96, '', '作者头像', array('class' => 'pixel-avatar')); ?>
            <div class="motto-box">
              <p class="pixel-text"><?php echo esc_html(get_the_author_meta('description')); ?></p>
            </div>
          </div>
        </div>
    </header>

    <?php get_template_part('pixel-menu'); ?>
