document.addEventListener('DOMContentLoaded', () => {
  // 菜单切换功能
  const menuToggle = document.getElementById('menu-toggle');
  const pixelMenu = document.getElementById('pixel-menu');
  
  menuToggle.addEventListener('click', () => {
    pixelMenu.classList.toggle('mdui-drawer-open');
    document.body.classList.toggle('menu-open');
  });

  // 瀑布流相关配置
  let page = 1;
  let loading = false;
  const container = document.querySelector('.posts-container');

  // 初始化瀑布流布局
  const initMasonry = () => {
    $(container).find('.mdui-card').css({
      'border-radius': '12px',
      'overflow': 'hidden',
      'margin-bottom': '20px',
      'box-shadow': '0 4px 12px rgba(0,0,0,0.1)',
      'transition': 'transform 0.3s ease, box-shadow 0.3s ease'
    });

    $(container).find('.mdui-card-media img').css({
      'width': '100%',
      'height': 'auto',
      'object-fit': 'cover'
    });

    // 使用Masonry实现瀑布流布局
    $(container).masonry({
      itemSelector: '.mdui-card',
      columnWidth: '.mdui-card',
      percentPosition: true,
      gutter: 20
    });
  };

  // 初始化布局
  initMasonry();

  // 滚动加载逻辑
  window.addEventListener('scroll', () => {
    if (window.innerHeight + window.scrollY >= document.body.offsetHeight - 500 && !loading) {
      loading = true;
      fetchPosts();
    }
  });

  async function fetchPosts() {
    try {
      const response = await wpAjax({
        action: 'load_more_posts',
        page: ++page
      });

      if (response.success && response.data.html) {
        const $newPosts = $(response.data.html);
        $(container).append($newPosts).masonry('appended', $newPosts);
        initMasonry();
      }
    } catch (error) {
      console.error('加载失败:', error);
    } finally {
      loading = false;
    }
  }

  // 文章卡片悬停效果
  $(document).on('mouseenter', '.mdui-card', function() {
    $(this).css({
      'transform': 'translateY(-5px)',
      'box-shadow': '0 8px 16px rgba(0,0,0,0.15)'
    });
  }).on('mouseleave', '.mdui-card', function() {
    $(this).css({
      'transform': 'none',
      'box-shadow': '0 4px 12px rgba(0,0,0,0.1)'
    });
  });
});