<?php
/**
 * Timeless主题函数文件
 */

// 引入主题设置页面
require get_template_directory() . '/inc/theme-settings.php';

// 注册后台样式
function timeless_admin_styles() {
    wp_enqueue_style('timeless-admin-style', get_template_directory_uri() . '/admin.css');
    wp_enqueue_media();
}
add_action('admin_enqueue_scripts', 'timeless_admin_styles');

// 注册主题支持
function timeless_setup(): void {
    // 添加特色图片支持
    add_theme_support('post-thumbnails');
    
    // 添加标题标签支持
    add_theme_support('title-tag');
    
    // 添加自动生成feed链接
    add_theme_support('automatic-feed-links');
    
    // HTML5支持
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));
    
    // 注册导航菜单
    register_nav_menus(array(
        'primary' => '主菜单',
        'footer' => '页脚菜单',
    ));
}
add_action('after_setup_theme', 'timeless_setup');

// 注册侧边栏
function timeless_widgets_init(): void {
    register_sidebar(array(
        'name'          => '侧边栏',
        'id'            => 'sidebar-1',
        'description'   => '添加小工具到侧边栏',
        'before_widget' => '<div class="mdui-card sidebar-widget">',
        'after_widget'  => '</div>',
        'before_title'  => '<div class="mdui-card-primary"><div class="mdui-card-primary-title">',
        'after_title'   => '</div></div>',
    ));
}
add_action('widgets_init', 'timeless_widgets_init');

// 注册样式和脚本
function timeless_scripts(): void {
    // 注册主题样式
    wp_enqueue_style('timeless-style', get_stylesheet_uri(), array(), '1.0.0');
    
    // 注册Material图标
    wp_enqueue_style('material-icons', 'https://fonts.googleapis.com/icon?family=Material+Icons', array(), null);
    
    // 注册自定义脚本
    wp_enqueue_script('timeless-script', get_template_directory_uri() . '/js/main.js', array(), '1.0.0', true);
    
    // 注册加载动画脚本
    wp_enqueue_script('loading-animation', get_template_directory_uri() . '/js/loading-animation.js', array(), '1.0.0', false);
    
    // 注册Masonry布局库
    wp_enqueue_script('masonry', 'https://unpkg.com/masonry-layout@4.2.2/dist/masonry.pkgd.min.js', array('jquery'), '4.2.2', true);
    
    // 注册无限滚动脚本
    wp_enqueue_script('infinite-scroll', get_template_directory_uri() . '/js/infinite-scroll.js', array('jquery', 'masonry'), '1.0.0', true);
    
    // 传递主题设置到前端
    wp_localize_script('infinite-scroll', 'timelessAjax', array(
        'ajaxurl' => admin_url('admin-ajax.php')
    ));
    wp_localize_script('loading-animation', 'timelessSettings', array(
        'loadingAnimationDuration' => get_option('loading_animation_duration', 3)
    ));
}
add_action('wp_enqueue_scripts', 'timeless_scripts');

/**
 * 获取网站favicon
 */
function timeless_get_site_favicon(): string {
    return get_option('site_favicon', '');
}

/**
 * 获取文章浏览次数
 */
function getPostViews(int $postID): string {
    if (!is_singular()) return '0';
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if ($count === '') {
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return '0';
    }
    return $count;
}

// Ajax加载更多文章
function load_more_posts() {
    $page = isset($_POST['page']) ? (int)$_POST['page'] : 1;
    $args = array(
        'posts_per_page' => 20,
        'paged' => $page,
        'post_status' => 'publish',
        'ignore_sticky_posts' => 1
    );
    
    $query = new WP_Query($args);
    $response = array();
    
    if ($query->have_posts()) {
        ob_start();
        while ($query->have_posts()) {
            $query->the_post();
            get_template_part('template-parts/content', get_post_format());
        }
        $response['html'] = ob_get_clean();
        $response['has_more'] = $page < $query->max_num_pages;
    } else {
        $response['html'] = '';
        $response['has_more'] = false;
    }
    
    wp_reset_postdata();
    wp_send_json_success($response);
}
add_action('wp_ajax_load_more_posts', 'load_more_posts');
add_action('wp_ajax_nopriv_load_more_posts', 'load_more_posts');

/**
 * 更新文章浏览次数
 */
function setPostViews(int $postID): void {
    if (!is_singular()) return;
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if ($count === '') {
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '1');
    } else {
        $count++;
        update_post_meta($postID, $count_key, (string)$count);
    }
}

/**
 * 获取默认主题颜色
 */
function timeless_get_default_color(): string {
    return get_option('theme_color', 'teal');
}

/**
 * 获取ICP备案号
 */
function timeless_get_icp_number(): string {
    return get_option('icp_number', '');
}

/**
 * 获取首页显示文章数量
 */
function timeless_get_home_posts_count(): int {
    return (int)get_option('home_posts_count', 5);
}

/**
 * 获取首页背景图片
 */
function timeless_get_home_bg(): string {
    return get_option('home_background', '');
}

/**
 * 获取首页文字
 */
function timeless_get_home_text(): string {
    return get_option('home_text', '将你所想写在这里，发布在博客上，被记录，被他人浏览。');
}

/**
 * 获取是否显示置顶文章
 */
function timeless_show_sticky_posts(): bool {
    return get_option('show_sticky_posts', true);
}