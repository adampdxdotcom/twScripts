window.addEventListener('load', function() {
    setTimeout(function() {
        const fixedNav = document.querySelector('.hero-sticky-nav');
        const heroInner = document.querySelector('.hero-background-image .wp-block-cover__inner-container');

        if (fixedNav && heroInner) {
            const adjustHeroPadding = () => {
                const navHeight = fixedNav.offsetHeight;
                heroInner.style.paddingTop = `${navHeight}px`;
            };
            adjustHeroPadding();
            window.addEventListener('resize', adjustHeroPadding);
        }
    }, 100);

    const navForScroll = document.querySelector('.hero-sticky-nav');
    if (navForScroll) {
        window.addEventListener('scroll', function() {
            if (window.scrollY > 50) {
                navForScroll.classList.add('scrolled');
            } else {
                navForScroll.classList.remove('scrolled');
            }
        });
    }
});
