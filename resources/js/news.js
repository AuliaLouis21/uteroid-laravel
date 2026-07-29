/* =============================================
   NEWS PAGE - JavaScript
   ============================================= */

document.addEventListener('DOMContentLoaded', function () {

    /* ---------- Fade In on Scroll (Intersection Observer) ---------- */
    const fadeEls = document.querySelectorAll('.news-fade-in');
    if (fadeEls.length && 'IntersectionObserver' in window) {
        const observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });

        fadeEls.forEach(function (el) { observer.observe(el); });
    } else {
        fadeEls.forEach(function (el) { el.classList.add('visible'); });
    }

    /* ---------- Smooth Scroll to Top on Pagination ---------- */
    document.querySelectorAll('.news-pagination .page-link').forEach(function (link) {
        link.addEventListener('click', function () {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    });

    /* ---------- Share Buttons ---------- */
    var currentUrl = encodeURIComponent(window.location.href);
    var currentTitle = encodeURIComponent(document.title);

    document.querySelectorAll('.news-share-btn').forEach(function (btn) {
        var network = btn.dataset.network;
        var shareUrl = '';

        switch (network) {
            case 'facebook':
                shareUrl = 'https://www.facebook.com/sharer/sharer.php?u=' + currentUrl;
                break;
            case 'twitter':
                shareUrl = 'https://twitter.com/intent/tweet?url=' + currentUrl + '&text=' + currentTitle;
                break;
            case 'whatsapp':
                shareUrl = 'https://wa.me/?text=' + currentTitle + '%20' + currentUrl;
                break;
            case 'linkedin':
                shareUrl = 'https://www.linkedin.com/sharing/share-offsite/?url=' + currentUrl;
                break;
        }

        if (shareUrl) {
            btn.setAttribute('href', shareUrl);
            btn.setAttribute('target', '_blank');
            btn.setAttribute('rel', 'noopener noreferrer');
        }
    });

});
