<?php
/**
 * Template Name: 留言板
 * Description: 用于展示留言板的页面模板
 */

get_header();
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
                
                <div class="guestbook-container">
                    <?php
                    // 设置评论表单参数
                    $commenter = wp_get_current_commenter();
                    $req = get_option('require_name_email');
                    $aria_req = ($req ? " aria-required='true'" : '');
                    
                    $fields = array(
                        'author' => '<div class="mdui-textfield"><label class="mdui-textfield-label">' . __('姓名', 'timeless') . ($req ? ' <span class="required">*</span>' : '') . '</label><input class="mdui-textfield-input" id="author" name="author" type="text" value="' . esc_attr($commenter['comment_author']) . '"' . $aria_req . ' /></div>',
                        'email' => '<div class="mdui-textfield"><label class="mdui-textfield-label">' . __('邮箱', 'timeless') . ($req ? ' <span class="required">*</span>' : '') . '</label><input class="mdui-textfield-input" id="email" name="email" type="email" value="' . esc_attr($commenter['comment_author_email']) . '"' . $aria_req . ' /></div>',
                        'url' => '<div class="mdui-textfield"><label class="mdui-textfield-label">' . __('网站', 'timeless') . '</label><input class="mdui-textfield-input" id="url" name="url" type="url" value="' . esc_attr($commenter['comment_author_url']) . '" /></div>',
                        'cookies' => '<div class="mdui-checkbox"><input type="checkbox" name="wp-comment-cookies-consent" id="wp-comment-cookies-consent" value="yes"' . (empty($commenter['comment_author_email']) ? '' : ' checked="checked"') . ' /><i class="mdui-checkbox-icon"></i><label for="wp-comment-cookies-consent">' . __('保存我的信息，以便下次评论使用。', 'timeless') . '</label></div>',
                    );
                    
                    $comments_args = array(
                        'fields' => $fields,
                        'comment_field' => '<div class="mdui-textfield"><label class="mdui-textfield-label">' . __('留言', 'timeless') . '</label><textarea class="mdui-textfield-input" id="comment" name="comment" rows="8" aria-required="true"></textarea></div>',
                        'class_submit' => 'mdui-btn mdui-btn-raised mdui-ripple mdui-color-theme',
                        'title_reply' => __('留下您的足迹', 'timeless'),
                        'title_reply_before' => '<h3 class="mdui-text-color-theme">',
                        'title_reply_after' => '</h3>',
                        'comment_notes_before' => '<p class="comment-notes">' . __('您的电子邮箱地址不会被公开。', 'timeless') . '</p>',
                        'submit_button' => '<button name="%1$s" type="submit" id="%2$s" class="%3$s" value="%4$s">%4$s</button>',
                    );
                    
                    // 添加验证码功能
                    add_action('comment_form_after_fields', 'timeless_add_captcha_field');
                    add_action('comment_form_logged_in_after', 'timeless_add_captcha_field');
                    
                    function timeless_add_captcha_field() {
                        $rand1 = rand(1, 10);
                        $rand2 = rand(1, 10);
                        $sum = $rand1 + $rand2;
                        
                        echo '<div class="mdui-textfield captcha-field">';
                        echo '<label class="mdui-textfield-label">验证码: ' . $rand1 . ' + ' . $rand2 . ' = ?</label>';
                        echo '<input class="mdui-textfield-input" type="text" name="captcha_answer" required />';
                        echo '<input type="hidden" name="captcha_sum" value="' . $sum . '" />';
                        echo '</div>';
                    }
                    
                    // 显示评论表单
                    comment_form($comments_args);
                    ?>
                    
                    <!-- 显示留言列表 -->
                    <div class="comments-list mdui-m-t-4">
                        <h3 class="mdui-text-color-theme">留言列表</h3>
                        
                        <?php if (have_comments()) : ?>
                            <ul class="mdui-list comment-list">
                                <?php
                                wp_list_comments(array(
                                    'style' => 'ul',
                                    'short_ping' => true,
                                    'avatar_size' => 50,
                                    'callback' => 'timeless_comment_callback',
                                ));
                                ?>
                            </ul>
                            
                            <?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : ?>
                                <nav class="comment-navigation">
                                    <div class="nav-previous"><?php previous_comments_link(__('较早的留言', 'timeless')); ?></div>
                                    <div class="nav-next"><?php next_comments_link(__('较新的留言', 'timeless')); ?></div>
                                </nav>
                            <?php endif; ?>
                            
                        <?php else : ?>
                            <div class="mdui-card">
                                <div class="mdui-card-content">
                                    <p><?php _e('暂无留言，成为第一个留言的人吧！', 'timeless'); ?></p>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
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