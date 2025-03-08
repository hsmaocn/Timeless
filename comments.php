<?php
if (post_password_required()) {
    return;
}
?>

<div id="comments" class="comments-area mdui-card mdui-shadow-2">
    <?php if (have_comments()) : ?>
        <div class="mdui-card-primary mdui-color-theme-50">
            <h3 class="mdui-card-primary-title comments-title">
                <i class="mdui-icon material-icons">forum</i>
                <?php
                $comments_number = get_comments_number();
                printf(
                    _nx(
                        '%1$s 条评论',
                        '%1$s 条评论',
                        $comments_number,
                        'comments title',
                        'timeless'
                    ),
                    number_format_i18n($comments_number)
                );
                ?>
            </h3>
        </div>

        <div class="mdui-card-content comment-list">
            <div class="mdui-list mdui-list-dense">
                <?php
                wp_list_comments(array(
                    'style'       => 'div',
                    'short_ping'  => true,
                    'avatar_size' => 50,
                    'callback'    => 'timeless_comment',
                ));
                ?>
            </div>

            <?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : ?>
                <nav class="comment-navigation mdui-m-t-2">
                    <div class="nav-previous mdui-btn mdui-btn-raised mdui-ripple mdui-color-theme-accent"><?php previous_comments_link('<i class="mdui-icon material-icons">arrow_back</i> ' . __('较早的评论', 'timeless')); ?></div>
                    <div class="nav-next mdui-btn mdui-btn-raised mdui-ripple mdui-color-theme-accent"><?php next_comments_link(__('较新的评论', 'timeless') . ' <i class="mdui-icon material-icons">arrow_forward</i>'); ?></div>
                </nav>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <?php if (!comments_open() && get_comments_number() && post_type_supports(get_post_type(), 'comments')) : ?>
        <div class="mdui-card-content no-comments">
            <?php _e('评论已关闭。', 'timeless'); ?>
        </div>
    <?php endif; ?>

    <?php
    comment_form(array(
        'title_reply'          => __('发表评论', 'timeless'),
        'title_reply_to'       => __('回复 %s', 'timeless'),
        'cancel_reply_link'    => __('取消回复', 'timeless'),
        'label_submit'         => __('发表评论', 'timeless'),
        'comment_field'        => '<div class="mdui-textfield mdui-textfield-floating-label"><label class="mdui-textfield-label">' . _x('评论内容', 'noun') . '</label><textarea id="comment" name="comment" class="mdui-textfield-input" aria-required="true"></textarea></div>',
        'class_container'      => 'comment-respond mdui-card mdui-shadow-2 mdui-m-t-4',
        'class_form'           => 'comment-form mdui-p-a-2',
        'class_submit'         => 'mdui-btn mdui-btn-raised mdui-ripple mdui-color-theme mdui-m-t-2',
        'submit_button'        => '<button name="%1$s" type="submit" id="%2$s" class="%3$s" value="%4$s"><i class="mdui-icon material-icons">send</i> %4$s</button>',
        'format'               => 'html5',
        'comment_notes_before' => '<p class="comment-notes mdui-typo-caption-opacity">' . __('您的电子邮箱地址不会被公开。', 'timeless') . '</p>',
        'fields'               => array(
            'author' => '<div class="mdui-textfield mdui-textfield-floating-label"><label class="mdui-textfield-label">' . __('姓名', 'timeless') . '</label><input id="author" name="author" type="text" class="mdui-textfield-input" value="' . esc_attr($commenter['comment_author']) . '" /></div>',
            'email'  => '<div class="mdui-textfield mdui-textfield-floating-label"><label class="mdui-textfield-label">' . __('电子邮箱', 'timeless') . '</label><input id="email" name="email" type="email" class="mdui-textfield-input" value="' . esc_attr($commenter['comment_author_email']) . '" /></div>',
            'url'    => '<div class="mdui-textfield mdui-textfield-floating-label"><label class="mdui-textfield-label">' . __('网站', 'timeless') . '</label><input id="url" name="url" type="url" class="mdui-textfield-input" value="' . esc_attr($commenter['comment_author_url']) . '" /></div>',
        )
    ));
    ?>
</div>