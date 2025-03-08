<?php
// 初始化MDUI组件
add_action('admin_footer', function() {
?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        mdui.mutation();
        mdui.updateComponents();
    });
</script>
<?php
});

/**
 * Timeless主题设置页面
 */

// 防止直接访问
if (!defined('ABSPATH')) {
    exit;
}

// 添加主题设置菜单
function timeless_add_theme_menu() {
    add_menu_page(
        'Timeless主题设置', // 页面标题
        'Timeless设置',     // 菜单标题
        'manage_options',    // 权限
        'timeless-settings', // 菜单slug
        'timeless_settings_page', // 回调函数
        'dashicons-admin-customizer', // 图标
        60 // 位置
    );
}
add_action('admin_menu', 'timeless_add_theme_menu');

// 注册设置
function timeless_register_settings() {
    register_setting('timeless_options', 'background_type', 'sanitize_text_field');
    register_setting('timeless_options', 'home_background', 'esc_url_raw');
    register_setting('timeless_options', 'home_video', 'esc_url_raw');
    register_setting('timeless_options', 'site_favicon', 'esc_url_raw');
    register_setting('timeless_options', 'theme_color', 'sanitize_text_field');
    register_setting('timeless_options', 'loading_animation_duration', 'absint');
    register_setting('timeless_options', 'show_sticky_posts', 'rest_sanitize_boolean');
    register_setting('timeless_options', 'home_posts_count', 'absint');
    register_setting('timeless_options', 'home_text', 'sanitize_text_field');
    register_setting('timeless_options', 'icp_number', 'sanitize_text_field');
    // 社交媒体设置
    register_setting('timeless_options', 'social_wechat', 'sanitize_text_field');
    register_setting('timeless_options', 'social_qq', 'sanitize_text_field');
    register_setting('timeless_options', 'social_bilibili', 'esc_url_raw');
    register_setting('timeless_options', 'social_netease', 'esc_url_raw');
    register_setting('timeless_options', 'social_zhihu', 'esc_url_raw');
    register_setting('timeless_options', 'social_github', 'esc_url_raw');
    register_setting('timeless_options', 'social_telegram', 'sanitize_text_field');
    register_setting('timeless_options', 'social_email', 'sanitize_email');
}
add_action('admin_init', 'timeless_register_settings');

// 设置页面回调函数
function timeless_settings_page() {
    if (!current_user_can('manage_options')) {
        return;
    }
    
    if (isset($_GET['settings-updated'])) {
        add_settings_error('timeless_messages', 'timeless_message', '设置已保存', 'updated');
    }
    
    settings_errors('timeless_messages');
    ?>
    <div class="mdui-container mdui-p-b-5 timeless-settings-page">
        <h1 class="mdui-text-color-theme-accent"><?php echo esc_html(get_admin_page_title()); ?></h1>
        <form action="options.php" method="post" enctype="multipart/form-data">
            <?php
            settings_fields('timeless_options');
            ?>
            <div class="mdui-tab" mdui-tab>
                <a href="#basic-settings" class="mdui-ripple mdui-tab-active">
                    <i class="mdui-icon material-icons">&#xe8b8;</i>基础设置
                </a>
                <a href="#style-settings" class="mdui-ripple">
                    <i class="mdui-icon material-icons">&#xe40a;</i>样式设置
                </a>
                <a href="#advanced-settings" class="mdui-ripple">
                    <i class="mdui-icon material-icons">&#xe869;</i>高级设置
                </a>
            </div>
            
            <div id="general" class="tab-content active">
                <table class="form-table">
                    <tr>
                        <th scope="row">Favicon图标</th>
                        <td>
                            <input type="text" name="site_favicon" value="<?php echo esc_attr(get_option('site_favicon')); ?>" class="regular-text">
                            <button type="button" class="button upload-image">选择图片</button>
                            <p class="description">网站图标，建议尺寸32x32像素</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">ICP备案号</th>
                        <td>
                            <input type="text" name="icp_number" value="<?php echo esc_attr(get_option('icp_number')); ?>" class="regular-text">
                            <p class="description">请输入网站的ICP备案号，如：京ICP备XXXXXXXX号</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">加载动画时间</th>
                        <td>
                            <input type="number" name="loading_animation_duration" value="<?php echo esc_attr(get_option('loading_animation_duration', 3)); ?>" class="small-text" min="1" max="10" step="1">
                            <p class="description">设置加载动画的持续时间（单位：秒），建议设置在1-10秒之间</p>
                        </td>
                    </tr>
                </table>
            </div>
            
            <div id="appearance" class="tab-content">
                <table class="form-table">
                    <tr>
                        <th scope="row">主题颜色</th>
                        <td>
                            <select name="theme_color">
                                <?php
                                $current_color = get_option('theme_color', 'teal');
                                $colors = array(
                                    'teal' => '青色',
                                    'red' => '红色',
                                    'pink' => '粉色',
                                    'purple' => '紫色',
                                    'deep-purple' => '深紫色',
                                    'indigo' => '靛蓝色',
                                    'blue' => '蓝色',
                                    'light-blue' => '浅蓝色',
                                    'cyan' => '青色',
                                    'green' => '绿色',
                                    'light-green' => '浅绿色',
                                    'lime' => '青柠色',
                                    'yellow' => '黄色',
                                    'amber' => '琥珀色',
                                    'orange' => '橙色',
                                    'deep-orange' => '深橙色',
                                    'brown' => '棕色',
                                    'grey' => '灰色',
                                    'blue-grey' => '蓝灰色'
                                );
                                foreach ($colors as $value => $label) {
                                    printf(
                                        '<option value="%s"%s>%s</option>',
                                        esc_attr($value),
                                        selected($current_color, $value, false),
                                        esc_html($label)
                                    );
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">加载动画时间</th>
                        <td>
                            <input type="number" name="loading_animation_duration" value="<?php echo esc_attr(get_option('loading_animation_duration', 3)); ?>" class="small-text" min="1" max="10" step="1">
                            <p class="description">设置加载动画的持续时间（单位：秒），建议设置在1-10秒之间</p>
                        </td>
                    </tr>
                </table>
            </div>
            
            <div id="homepage" class="tab-content">
                <table class="form-table">

            <div id="social" class="tab-content">
                <table class="form-table">
                    <tr>
                        <th scope="row">微信号</th>
                        <td>
                            <input type="text" name="social_wechat" value="<?php echo esc_attr(get_option('social_wechat')); ?>" class="regular-text">
                            <p class="description">输入您的微信号</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">QQ号</th>
                        <td>
                            <input type="text" name="social_qq" value="<?php echo esc_attr(get_option('social_qq')); ?>" class="regular-text">
                            <p class="description">输入您的QQ号</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">哔哩哔哩主页</th>
                        <td>
                            <input type="url" name="social_bilibili" value="<?php echo esc_url(get_option('social_bilibili')); ?>" class="regular-text">
                            <p class="description">输入您的哔哩哔哩主页链接</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">网易云音乐</th>
                        <td>
                            <input type="url" name="social_netease" value="<?php echo esc_url(get_option('social_netease')); ?>" class="regular-text">
                            <p class="description">输入您的网易云音乐主页链接</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">知乎主页</th>
                        <td>
                            <input type="url" name="social_zhihu" value="<?php echo esc_url(get_option('social_zhihu')); ?>" class="regular-text">
                            <p class="description">输入您的知乎主页链接</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">GitHub</th>
                        <td>
                            <input type="url" name="social_github" value="<?php echo esc_url(get_option('social_github')); ?>" class="regular-text">
                            <p class="description">输入您的GitHub主页链接</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Telegram</th>
                        <td>
                            <input type="text" name="social_telegram" value="<?php echo esc_attr(get_option('social_telegram')); ?>" class="regular-text">
                            <p class="description">输入您的Telegram用户名（不含@）</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">电子邮箱</th>
                        <td>
                            <input type="email" name="social_email" value="<?php echo esc_attr(get_option('social_email')); ?>" class="regular-text">
                            <p class="description">输入您的电子邮箱地址</p>
                        </td>
                    </tr>
                </table>
            </div>
                    <tr>
                        <th scope="row">首页背景类型</th>
                        <td>
                            <fieldset>
                                <label>
                                    <input type="radio" name="background_type" value="image" <?php checked(get_option('background_type', 'image'), 'image'); ?>>
                                    图片背景
                                </label>
                                <br>
                                <label>
                                    <input type="radio" name="background_type" value="video" <?php checked(get_option('background_type', 'image'), 'video'); ?>>
                                    视频背景
                                </label>
                            </fieldset>
                        </td>
                    </tr>
                    <tr class="background-image-option" style="display: <?php echo get_option('background_type', 'image') === 'image' ? 'table-row' : 'none'; ?>">
                        <th scope="row">背景图片</th>
                        <td>
                            <input type="text" name="home_background" value="<?php echo esc_attr(get_option('home_background')); ?>" class="regular-text">
                            <button type="button" class="button upload-image">选择图片</button>
                            <p class="description">选择一张图片作为首页背景</p>
                        </td>
                    </tr>
                    <tr class="background-video-option" style="display: <?php echo get_option('background_type', 'image') === 'video' ? 'table-row' : 'none'; ?>">
                        <th scope="row">背景视频</th>
                        <td>
                            <input type="text" name="home_video" value="<?php echo esc_attr(get_option('home_video')); ?>" class="regular-text">
                            <button type="button" class="button upload-video">选择视频</button>
                            <p class="description">选择一个视频作为首页背景</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">首页显示文字</th>
                        <td>
                            <textarea name="home_text" rows="3" class="regular-text"><?php echo esc_textarea(get_option('home_text', '将你所想写在这里，发布在博客上，被记录，被他人浏览。')); ?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">显示置顶文章</th>
                        <td>
                            <label>
                                <input type="checkbox" name="show_sticky_posts" value="1" <?php checked(get_option('show_sticky_posts', true)); ?>>
                                在首页显示置顶文章
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">首页文章数量</th>
                        <td>
                            <input type="number" name="home_posts_count" value="<?php echo esc_attr(get_option('home_posts_count', 5)); ?>" class="small-text" min="1" max="20" step="1">
                            <p class="description">设置首页显示的文章数量（1-20）</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">加载动画时间</th>
                        <td>
                            <input type="number" name="loading_animation_duration" value="<?php echo esc_attr(get_option('loading_animation_duration', 3)); ?>" class="small-text" min="1" max="10" step="1">
                            <p class="description">设置加载动画的持续时间（单位：秒），建议设置在1-10秒之间</p>
                        </td>
                    </tr>
                </table>
            </div>
            
            <?php submit_button(); ?>
        </form>
    </div>
    
    <script>
    jQuery(document).ready(function($) {
        // 标签页切换
        $('.nav-tab').click(function(e) {
            e.preventDefault();
            var target = $(this).attr('href');
            
            $('.nav-tab').removeClass('nav-tab-active');
            $(this).addClass('nav-tab-active');
            
            $('.tab-content').removeClass('active');
            $(target).addClass('active');
        });
        
        // 背景类型切换
        $('input[name="background_type"]').change(function() {
            var type = $(this).val();
            if (type === 'image') {
                $('.background-image-option').show();
                $('.background-video-option').hide();
            } else {
                $('.background-image-option').hide();
                $('.background-video-option').show();
            }
        });

        // 图片上传
        $('.upload-image').click(function(e) {
            e.preventDefault();
            var button = $(this);
            var input = button.prev();
            
            var custom_uploader = wp.media({
                title: '选择图片',
                button: {
                    text: '使用此图片'
                },
                multiple: false
            });
            
            custom_uploader.on('select', function() {
                var attachment = custom_uploader.state().get('selection').first().toJSON();
                input.val(attachment.url);
            });
            
            custom_uploader.open();
        });

        // 视频上传
        $('.upload-video').click(function(e) {
            e.preventDefault();
            var button = $(this);
            var input = button.prev();
            
            var custom_uploader = wp.media({
                title: '选择视频',
                button: {
                    text: '使用此视频'
                },
                library: {
                    type: 'video'
                },
                multiple: false
            });
            
            custom_uploader.on('select', function() {
                var attachment = custom_uploader.state().get('selection').first().toJSON();
                input.val(attachment.url);
            });
            
            custom_uploader.open();
        });
    });
    </script>
    <?php
}