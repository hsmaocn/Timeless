<footer class="site-footer">
    <div class="footer-content">
        <?php if (is_active_sidebar('footer-widgets')) : ?>
            <div class="footer-widgets">
                <?php dynamic_sidebar('footer-widgets'); ?>
            </div>
        <?php endif; ?>
        <!-- 社交媒体图标 -->
        <div class="social-icons">
            <?php if (get_option('social_wechat')) : ?>
                <a href="javascript:void(0);" class="social-icon wechat" title="微信: <?php echo esc_attr(get_option('social_wechat')); ?>">
                    <i class="mdui-icon material-icons">chat</i>
                </a>
            <?php endif; ?>
            
            <?php if (get_option('social_qq')) : ?>
                <a href="tencent://message/?uin=<?php echo esc_attr(get_option('social_qq')); ?>" class="social-icon qq" title="QQ: <?php echo esc_attr(get_option('social_qq')); ?>">
                    <i class="mdui-icon material-icons">forum</i>
                </a>
            <?php endif; ?>
            
            <?php if (get_option('social_bilibili')) : ?>
                <a href="<?php echo esc_url(get_option('social_bilibili')); ?>" class="social-icon bilibili" target="_blank" rel="noopener noreferrer" title="哔哩哔哩">
                    <i class="mdui-icon material-icons">play_circle_outline</i>
                </a>
            <?php endif; ?>
            
            <?php if (get_option('social_netease')) : ?>
                <a href="<?php echo esc_url(get_option('social_netease')); ?>" class="social-icon netease" target="_blank" rel="noopener noreferrer" title="网易云音乐">
                    <i class="mdui-icon material-icons">music_note</i>
                </a>
            <?php endif; ?>
            
            <?php if (get_option('social_zhihu')) : ?>
                <a href="<?php echo esc_url(get_option('social_zhihu')); ?>" class="social-icon zhihu" target="_blank" rel="noopener noreferrer" title="知乎">
                    <i class="mdui-icon material-icons">question_answer</i>
                </a>
            <?php endif; ?>
            
            <?php if (get_option('social_github')) : ?>
                <a href="<?php echo esc_url(get_option('social_github')); ?>" class="social-icon github" target="_blank" rel="noopener noreferrer" title="GitHub">
                    <i class="mdui-icon material-icons">code</i>
                </a>
            <?php endif; ?>
            
            <?php if (get_option('social_telegram')) : ?>
                <a href="https://t.me/<?php echo esc_attr(get_option('social_telegram')); ?>" class="social-icon telegram" target="_blank" rel="noopener noreferrer" title="Telegram">
                    <i class="mdui-icon material-icons">send</i>
                </a>
            <?php endif; ?>
            
            <?php if (get_option('social_email')) : ?>
                <a href="mailto:<?php echo esc_attr(get_option('social_email')); ?>" class="social-icon email" title="Email">
                    <i class="mdui-icon material-icons">email</i>
                </a>
            <?php endif; ?>
        </div>
        
        <div class="footer-bottom">
            <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. All rights reserved.</p>
            <?php if (get_option('icp_number')) : ?>
                <p class="icp-info"><?php echo esc_html(get_option('icp_number')); ?></p>
            <?php endif; ?>
        </div>
    </div>
</footer>

<!-- 返回顶部按钮 -->
<div class="back-to-top" id="backToTop">
    <i class="mdui-icon material-icons">arrow_upward</i>
</div>

<script src="https://lf6-cdn-tos.bytecdntp.com/cdn/expire-1-M/mdui/1.0.1/js/mdui.min.js"></script>

<!-- 主题自定义脚本 -->
<script>
    // 主题功能初始化
    document.addEventListener('DOMContentLoaded', function() {
        var backToTopBtn = document.getElementById('backToTop');
        var appbar = document.getElementById('site-header-appbar');
        var toolbar = document.getElementById('site-header-toolbar');
        var body = document.getElementById('timeless-body');
        var isHomePage = document.body.classList.contains('home');
        
        // 显示/隐藏返回顶部按钮和导航栏透明效果
        window.addEventListener('scroll', function() {
            // 返回顶部按钮
            if (window.pageYOffset > 300) {
                backToTopBtn.classList.add('visible');
            } else {
                backToTopBtn.classList.remove('visible');
            }
            
            // 首页导航栏透明效果
            if (isHomePage) {
                if (window.pageYOffset > 100) {
                    appbar.classList.add('scrolled');
                    toolbar.classList.add('scrolled');
                } else {
                    appbar.classList.remove('scrolled');
                    toolbar.classList.remove('scrolled');
                }
            }
        });
        
        // 点击返回顶部
        backToTopBtn.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
        
        // 初始化MDUI组件
        mdui.mutation();
    });
</script>
<?php wp_footer(); ?>
</body>
</html>