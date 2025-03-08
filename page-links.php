<?php
/**
 * Template Name: 友情链接
 * Description: 用于展示友情链接的页面模板
 */

// 检查函数是否存在
if (function_exists('get_header')) {
    get_header();
} else {
    // 如果函数不存在，输出基础HTML头部
    ?>
    <!DOCTYPE html>
    <html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo('charset'); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php wp_title('|', true, 'right'); ?></title>
        <?php wp_head(); ?>
    </head>
    <body <?php body_class(); ?>>
    <?php
}
?>

<main class="page-container" id="content">
    <div class="page-content">
        <div class="mdui-card page-card">
            <div class="mdui-card-primary">
                <h1 class="mdui-card-primary-title"><?php the_title(); ?></h1>
            </div>
            <div class="mdui-card-content">
                <?php
                // 显示页面内容
                while (have_posts()) : the_post();
                    the_content();
                endwhile;
                ?>
                
                <div class="links-container">
                    <?php
                    // 获取友情链接（可以通过自定义字段或分类方式实现）
                    $links = array(
                        // 这里可以通过get_option或自定义字段获取友链数据
                        // 以下为示例数据
                        array(
                            'name' => 'WordPress',
                            'url' => 'https://wordpress.org',
                            'description' => 'WordPress官方网站',
                            'avatar' => 'https://s.w.org/style/images/about/WordPress-logotype-standard.png'
                        ),
                        array(
                            'name' => 'MDUI',
                            'url' => 'https://www.mdui.org',
                            'description' => '一套用于开发 Material Design 网页的前端框架',
                            'avatar' => 'https://www.mdui.org/favicon.ico'
                        ),
                    );
                    
                    // 输出友情链接
                    foreach ($links as $link) :
                    ?>
                    <div class="mdui-card friend-link">
                        <div class="mdui-card-header">
                            <img class="mdui-card-header-avatar" src="<?php echo esc_url($link['avatar']); ?>" alt="<?php echo esc_attr($link['name']); ?>">
                            <div class="mdui-card-header-title">
                                <a href="<?php echo esc_url($link['url']); ?>" target="_blank" rel="noopener">
                                    <?php echo esc_html($link['name']); ?>
                                </a>
                            </div>
                            <div class="mdui-card-header-subtitle"><?php echo esc_html($link['description']); ?></div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                
                <!-- 添加友链申请表单 -->
                <div class="link-application">
                    <h3 class="mdui-text-color-theme">申请友链</h3>
                    <p>如果您想与本站交换友链，请填写以下信息：</p>
                    
                    <form id="link-application-form" class="mdui-p-a-2">
                        <div class="mdui-textfield">
                            <label class="mdui-textfield-label">网站名称</label>
                            <input class="mdui-textfield-input" type="text" name="site_name" required/>
                        </div>
                        
                        <div class="mdui-textfield">
                            <label class="mdui-textfield-label">网站地址</label>
                            <input class="mdui-textfield-input" type="url" name="site_url" required/>
                        </div>
                        
                        <div class="mdui-textfield">
                            <label class="mdui-textfield-label">网站描述</label>
                            <input class="mdui-textfield-input" type="text" name="site_description" required/>
                        </div>
                        
                        <div class="mdui-textfield">
                            <label class="mdui-textfield-label">网站图标</label>
                            <input class="mdui-textfield-input" type="url" name="site_avatar" required/>
                        </div>
                        
                        <div class="mdui-textfield">
                            <label class="mdui-textfield-label">您的邮箱</label>
                            <input class="mdui-textfield-input" type="email" name="email" required/>
                        </div>
                        
                        <button class="mdui-btn mdui-btn-raised mdui-ripple mdui-color-theme" type="submit">提交申请</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <!-- 侧边栏 -->
    <div class="sidebar">
        <?php if (is_active_sidebar('sidebar-1')) : ?>
            <?php dynamic_sidebar('sidebar-1'); ?>
        <?php else : ?>
            <div class="mdui-card sidebar-widget">
                <div class="mdui-card-primary">
                    <div class="mdui-card-primary-title">关于本站</div>
                </div>
                <div class="mdui-card-content">
                    <p><?php echo esc_html(timeless_get_home_text()); ?></p>
                </div>
            </div>
            
            <div class="mdui-card sidebar-widget">
                <div class="mdui-card-primary">
                    <div class="mdui-card-primary-title">搜索</div>
                </div>
                <div class="mdui-card-content">
                    <form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
                        <input type="search" name="s" placeholder="搜索..." value="<?php echo get_search_query(); ?>">
                        <button type="submit"><i class="mdui-icon material-icons">search</i></button>
                    </form>
                </div>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php get_footer(); ?>