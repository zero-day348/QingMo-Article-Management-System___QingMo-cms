// 页面加载完成后执行
document.addEventListener('DOMContentLoaded', function() {
    // 分页链接点击事件（可选：添加加载动画）
    const paginationLinks = document.querySelectorAll('.pagination a');
    paginationLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            // 可添加加载动画逻辑
            document.body.style.cursor = 'wait';
        });
    });

    // 导航栏滚动效果
    const navbar = document.querySelector('.navbar');
    window.addEventListener('scroll', function() {
        if (window.scrollY > 50) {
            navbar.classList.add('shadow-lg');
        } else {
            navbar.classList.remove('shadow-lg');
        }
    });
});