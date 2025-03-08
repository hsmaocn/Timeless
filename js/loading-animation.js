document.addEventListener('DOMContentLoaded', function() {
    const loading = document.getElementById('loading');
    if (!loading) return;

    // 从主题设置中获取加载动画时间（秒），默认为3秒
    const animationDuration = (window.timelessSettings && window.timelessSettings.loadingAnimationDuration) || 3;
    // 转换为毫秒
    const maxWaitTime = animationDuration * 1000;

    // 创建一个Promise来检测页面加载状态
    const pageLoaded = new Promise((resolve) => {
        if (document.readyState === 'complete') {
            resolve();
        } else {
            window.addEventListener('load', resolve);
        }
    });

    // 使用Promise.race来确保不会无限等待
    Promise.race([
        pageLoaded,
        new Promise(resolve => setTimeout(resolve, maxWaitTime))
    ]).then(() => {
        // 添加淡出动画
        loading.style.opacity = '0';
        setTimeout(() => {
            loading.style.display = 'none';
        }, 500); // 等待淡出动画完成
    });
});