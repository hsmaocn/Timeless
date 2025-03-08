<?php
/**
 * Template Name: 外链跳转页面
 * Description: 用于外部链接跳转的中间页面
 */

// 获取网站名称
// 检查是否存在 get_bloginfo 函数
if (function_exists('get_bloginfo')) {
    $site_name = get_bloginfo('name');
} else {
    $site_name = 'Website'; // 默认站点名称
}

// 获取跳转链接
if (isset($_GET['link'])) {
    $link = base64_decode($_GET['link']);
    $redirect_url = esc_url($link);
} else {
    // 如果没有链接参数，重定向到首页
// 检查是否存在 wp_redirect 和 home_url 函数
if (function_exists('wp_redirect') && function_exists('home_url')) {
    wp_redirect(home_url());
} else {
    header('Location: /');
}
    exit;
}
?>
<!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>即将离开<?php echo htmlspecialchars($site_name, ENT_QUOTES, 'UTF-8'); ?></title>
    <!-- MDUI CSS -->
    <link rel="stylesheet" href="https://lf9-cdn-tos.bytecdntp.com/cdn/expire-1-M/mdui/1.0.2/css/mdui.min.css">
    <style>
        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Roboto', sans-serif;
            overflow: hidden;
        }
        body {
            background-image: url('https://image.hsmao.cn/blog/img/4e47c17f37bb8c8c.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
        .glassmorphism {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            display: flex;
            justify-content: center;
            align-items: center;
            transition: backdrop-filter 0.3s ease;
        }
        #box {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
            max-width: 500px;
            width: 90%;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        #box:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 40px 0 rgba(31, 38, 135, 0.45);
        }
        .note {
            font-size: 24px;
            font-weight: 500;
            color: #333;
            margin-bottom: 20px;
        }
        .link {
            padding: 16px 0;
            border-bottom: 2px solid #e0e0e0;
            color: #666;
            font-size: 16px;
            word-break: break-all;
            margin-bottom: 20px;
        }
        .btn-plane {
           text-align: right;
        }
        .mdui-btn {
            text-transform: none;
            font-weight: 500;
        }
    </style>
</head>
<body class="mdui-theme-primary-indigo mdui-theme-accent-pink">
    <div class="glassmorphism">
        <div id="box" class="mdui-card mdui-card-raised">
            <div class="mdui-card-content">
                <p class="note mdui-typo-headline-opacity">即将离开<?php echo esc_html($site_name); ?>，请注意您的设备安全！</p>
                <p class="link mdui-typo-subheading-opacity"><?php echo esc_html($link ?? ''); ?></p>
                <div class="btn-plane">
                    <a href="<?php echo esc_url($redirect_url ?? ''); ?>" rel="nofollow" class="mdui-btn mdui-btn-raised mdui-ripple mdui-color-theme-accent">继续访问</a>
                </div>
            </div>
        </div>
    </div>

    <!-- MDUI JavaScript -->
    <script src="https://lf9-cdn-tos.bytecdntp.com/cdn/expire-1-M/mdui/1.0.2/js/mdui.min.js"></script>
    <script>
    document.addEventListener('mousemove', function(e) {
        const glassmorphism = document.querySelector('.glassmorphism');
        const box = document.getElementById('box');
        const rect = box.getBoundingClientRect();
        const x = e.clientX;
        const y = e.clientY;
        
        if (x >= rect.left && x <= rect.right && y >= rect.top && y <= rect.bottom) {
            glassmorphism.style.backdropFilter = 'blur(0px)';
            glassmorphism.style.webkitBackdropFilter = 'blur(0px)';
        } else {
            glassmorphism.style.backdropFilter = 'blur(10px)';
            glassmorphism.style.webkitBackdropFilter = 'blur(10px)';
        }
    });
    </script>
</body>
</html>