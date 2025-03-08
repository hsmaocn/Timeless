<?php
/**
 * 像素风格菜单栏组件
 */
?>
<div class="pixel-menu mdui-drawer" id="pixel-menu">
    <div class="pixel-menu-header">
        <div class="pixel-menu-logo">
            <?php if (timeless_get_site_favicon()) : ?>
            <img src="<?php echo esc_url(timeless_get_site_favicon()); ?>" alt="Logo">
            <?php endif; ?>
            <span class="pixel-menu-title"><?php bloginfo('name'); ?></span>
        </div>
    </div>
    
    <div class="pixel-menu-content">
        <?php
        wp_nav_menu(array(
            'theme_location' => 'primary',
            'container' => 'nav',
            'container_class' => 'pixel-menu-nav',
            'menu_class' => 'pixel-menu-list',
            'fallback_cb' => false,
            'walker' => new Pixel_Menu_Walker()
        ));
        ?>
    </div>
    
    <div class="pixel-menu-footer">
        <div class="pixel-menu-social">
            <!-- 可以在这里添加社交媒体链接 -->
        </div>
    </div>
</div>

<style>
/* 像素风格菜单栏样式 */
.pixel-menu {
    background: #1a1a1a;
    border-right: 2px solid #333;
    font-family: monospace;
    image-rendering: pixelated;
}

.pixel-menu-header {
    padding: 20px;
    border-bottom: 2px solid #333;
}

.pixel-menu-logo {
    display: flex;
    align-items: center;
    gap: 10px;
}

.pixel-menu-logo img {
    width: 32px;
    height: 32px;
    image-rendering: pixelated;
}

.pixel-menu-title {
    color: #fff;
    font-size: 16px;
    text-transform: uppercase;
}

.pixel-menu-content {
    padding: 20px 0;
}

.pixel-menu-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.pixel-menu-list li {
    margin: 0;
    padding: 0;
}

.pixel-menu-list a {
    display: block;
    padding: 10px 20px;
    color: #fff;
    text-decoration: none;
    font-size: 14px;
    transition: all 0.3s ease;
}

.pixel-menu-list a:hover {
    background: #333;
    transform: translateX(5px);
}

.pixel-menu-list .current-menu-item > a {
    background: #444;
    border-left: 4px solid #fff;
}

/* 地下动画效果 */
.mdui-drawer {
    transform: translateY(100%);
    transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.mdui-drawer.mdui-drawer-open {
    transform: translateY(0);
}
</style>

<?php
/**
 * 自定义菜单Walker类，用于生成像素风格的菜单HTML结构
 */
class Pixel_Menu_Walker extends Walker_Nav_Menu {
    public function start_lvl(&$output, $depth = 0, $args = array()) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class=\"pixel-submenu\">\n";
    }
    
    public function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
        $indent = ($depth) ? str_repeat("\t", $depth) : '';
        
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $classes[] = 'pixel-menu-item';
        
        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';
        
        $output .= $indent . '<li' . $class_names . '>';
        
        $attributes = !empty($item->attr_title) ? ' title="' . esc_attr($item->attr_title) . '"' : '';
        $attributes .= !empty($item->target) ? ' target="' . esc_attr($item->target) . '"' : '';
        $attributes .= !empty($item->xfn) ? ' rel="' . esc_attr($item->xfn) . '"' : '';
        $attributes .= !empty($item->url) ? ' href="' . esc_attr($item->url) . '"' : '';
        
        $item_output = $args->before;
        $item_output .= '<a' . $attributes . '>';
        $item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
        $item_output .= '</a>';
        $item_output .= $args->after;
        
        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }
}