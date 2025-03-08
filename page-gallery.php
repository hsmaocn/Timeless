<?php get_header();?>

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
                
                <div class="gallery-container">
                    <?php
                    // 这里可以通过自定义字段或其他方式获取照片数据
                    // 以下为示例数据
                    $photos = array(
                        array(
                            'title' => '风景照片1',
                            'description' => '这是一张美丽的风景照片',
                            'image' => get_template_directory_uri() . '/screenshot.png',
                            'date' => '2023-05-15'
                        ),
                        array(
                            'title' => '风景照片2',
                            'description' => '这是另一张美丽的风景照片',
                            'image' => get_template_directory_uri() . '/screenshot.png',
                            'date' => '2023-06-20'
                        ),
                        array(
                            'title' => '风景照片3',
                            'description' => '这是第三张美丽的风景照片',
                            'image' => get_template_directory_uri() . '/screenshot.png',
                            'date' => '2023-07-10'
                        ),
                        array(
                            'title' => '风景照片4',
                            'description' => '这是第四张美丽的风景照片',
                            'image' => get_template_directory_uri() . '/screenshot.png',
                            'date' => '2023-08-05'
                        ),
                    );
                    ?>
                    
                    <div class="mdui-row-xs-1 mdui-row-sm-2 mdui-row-md-3 mdui-row-lg-4 mdui-grid-list">
                        <?php foreach ($photos as $photo) : ?>
                            <div class="mdui-col">
                                <div class="mdui-grid-tile photo-item">
                                    <a class="mdui-ripple" href="<?php echo esc_url($photo['image']); ?>" data-fancybox="gallery" data-caption="<?php echo esc_attr($photo['title']); ?>: <?php echo esc_attr($photo['description']); ?>">
                                        <img src="<?php echo esc_url($photo['image']); ?>" alt="<?php echo esc_attr($photo['title']); ?>">
                                        <div class="mdui-grid-tile-actions mdui-grid-tile-actions-gradient">
                                            <div class="mdui-grid-tile-text">
                                                <div class="mdui-grid-tile-title"><?php echo esc_html($photo['title']); ?></div>
                                                <div class="mdui-grid-tile-subtitle"><?php echo esc_html($photo['date']); ?></div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                
                <!-- 照片上传表单（仅管理员可见） -->
                <?php if (current_user_can('manage_options')) : ?>
                <div class="photo-upload mdui-m-t-4">
                    <h3 class="mdui-text-color-theme">上传新照片</h3>
                    <form id="photo-upload-form" class="mdui-p-a-2">
                        <div class="mdui-textfield">
                            <label class="mdui-textfield-label">照片标题</label>
                            <input class="mdui-textfield-input" type="text" name="photo_title" required/>
                        </div>
                        
                        <div class="mdui-textfield">
                            <label class="mdui-textfield-label">照片描述</label>
                            <textarea class="mdui-textfield-input" name="photo_description" rows="3"></textarea>
                        </div>
                        
                        <div class="mdui-textfield">
                            <label class="mdui-textfield-label">选择照片</label>
                            <input type="file" name="photo_file" accept="image/*" required/>
                        </div>
                        
                        <button class="mdui-btn mdui-btn-raised mdui-ripple mdui-color-theme" type="submit">上传照片</button>
                    </form>
                </div>
                <?php endif; ?>
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

<!-- 添加Fancybox脚本用于照片查看 -->
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css">

<script>
    // 初始化Fancybox
    document.addEventListener('DOMContentLoaded', function() {
        Fancybox.bind('[data-fancybox="gallery"]', {
            caption: function (fancybox, carousel, slide) {
                return slide.caption;
            }
        });
    });
</script>

<style>
    /* 照片展览页面样式 */
    .gallery-container {
        margin: 2rem 0;
    }
    
    .photo-item {
        margin-bottom: 1.5rem;
        transition: transform 0.3s ease;
        overflow: hidden;
        border-radius: 4px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }
    
    .photo-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }
    
    .photo-item img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    
    .photo-item:hover img {
        transform: scale(1.05);
    }
    
    .photo-upload {
        background-color: rgba(0, 0, 0, 0.02);
        border-radius: 4px;
        padding: 1rem;
    }
    
    /* 深色模式适配 */
    body.mdui-theme-layout-dark .photo-upload {
        background-color: rgba(255, 255, 255, 0.05);
    }
</style>

<?php get_footer(); ?>