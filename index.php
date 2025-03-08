<?php
declare(strict_types=1);
get_header();
?>

<main class="postList" id="content">
    <?php if (timeless_show_sticky_posts()) : ?>
        <?php 
        // 获取置顶文章
        $sticky_posts = get_option('sticky_posts') ?? [];
        if (!empty($sticky_posts)) : 
            $sticky_query = new WP_Query(array(
                'post__in' => $sticky_posts,
                'ignore_sticky_posts' => 1
            ));
        ?>
        <div class="sticky-posts-container">
            <h2 class="sticky-posts-title mdui-text-color-theme"><i class="mdui-icon material-icons">push_pin</i> 置顶文章</h2>
            <div class="mdui-row-xs-1 mdui-row-sm-2 mdui-row-md-3 mdui-grid-list">
                <?php while ($sticky_query->have_posts()) : $sticky_query->the_post(); ?>
                    <div class="mdui-col">
                        <div class="mdui-card sticky-post-card">
                            <div class="mdui-card-media">
                                <a href="<?php the_permalink(); ?>">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <?php the_post_thumbnail('medium'); ?>
                                    <?php else : ?>
                                        <img src="<?php echo get_template_directory_uri(); ?>/screenshot.png" alt="<?php the_title_attribute(); ?>">
                                    <?php endif; ?>
                                </a>
                                <div class="mdui-card-media-covered mdui-card-media-covered-gradient">
                                    <div class="mdui-card-primary">
                                        <div class="mdui-card-primary-title">
                                            <a href="<?php the_permalink(); ?>" class="mdui-text-color-white"><?php the_title(); ?></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mdui-card-actions">
                                <span class="info">
                                    <i class="mdui-icon material-icons">visibility</i> <?php echo getPostViews(get_the_ID()); ?>
                                    <i class="mdui-icon material-icons">schedule</i> <?php the_time('Y-m-d'); ?>
                                </span>
                                <a class="mdui-btn mdui-ripple mdui-color-theme" href="<?php the_permalink(); ?>">继续阅读</a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
                <?php wp_reset_postdata(); ?>
            </div>
        </div>
        <?php endif; ?>
    <?php endif; ?>
    
    <div class="posts-container">
        <h2 class="latest-posts-title mdui-text-color-theme"><i class="mdui-icon material-icons">article</i> 最新文章</h2>
        <?php 
        // 设置查询参数，初始加载20篇文章
        $args = array(
            'posts_per_page' => 20,
            'paged' => 1,
            'ignore_sticky_posts' => 1 // 忽略置顶文章，因为已经在上面显示了
        );
        $main_query = new WP_Query($args);
        
        if ($main_query->have_posts()) : 
            while ($main_query->have_posts()) : $main_query->the_post(); 
        ?>
                <div class="mdui-card postDiv">
                    <div class="mdui-card-media">
                        <a href="<?php the_permalink(); ?>">
                            <?php if (has_post_thumbnail()) : ?>
                                <?php the_post_thumbnail('large'); ?>
                            <?php else : ?>
                                <img src="<?php echo get_template_directory_uri(); ?>/screenshot.png" alt="<?php the_title_attribute(); ?>">
                            <?php endif; ?>
                        </a>
                        <div class="mdui-card-primary">
                            <h2 class="mdui-card-primary-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h2>
                            <div class="mdui-card-primary-subtitle">
                                <?php
                                if (is_single()): 
                                    the_content();
                                else: 
                                    the_excerpt();
                                endif;
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="mdui-card-actions">
                        <span class="info">
                            <i class="mdui-icon material-icons">visibility</i> <?php echo getPostViews(get_the_ID()); ?>
                            <i class="mdui-icon material-icons">schedule</i> <?php the_time('Y-m-d'); ?>
                            <i class="mdui-icon material-icons">folder</i> <?php the_category(', '); ?>
                        </span>
                        <a class="mdui-btn mdui-ripple mdui-color-theme" href="<?php the_permalink(); ?>">继续阅读</a>
                    </div>
                </div>
            <?php endwhile; ?>
            <?php wp_reset_postdata(); ?>
            
            <div class="nextpage">
                <?php next_posts_link('加载更多', $main_query->max_num_pages); ?>
            </div>
            
        <?php else : ?>
            <div class="mdui-card">
                <div class="mdui-card-content">
                    <p>暂无内容</p>
                </div>
            </div>
        <?php endif; ?>
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
            
            <div class="mdui-card sidebar-widget">
                <div class="mdui-card-primary">
                    <div class="mdui-card-primary-title">最新文章</div>
                </div>
                <div class="mdui-card-content">
                    <ul>
                        <?php
                        $recent_posts = wp_get_recent_posts(array(
                            'numberposts' => 5,
                            'post_status' => 'publish'
                        ));
                        foreach ($recent_posts as $post) :
                        ?>
                            <li>
                                <a href="<?php echo get_permalink($post['ID']); ?>">
                                    <?php echo $post['post_title']; ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php get_footer(); ?>