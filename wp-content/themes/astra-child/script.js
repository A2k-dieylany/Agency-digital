document.addEventListener('DOMContentLoaded', function() {
    // Flag that JS is enabled (so CSS can hide elements safely)
    document.body.classList.add('sds-js-enabled');

    // 1. SCROLL REVEAL ANIMATIONS
    // Define elements to animate automatically
    const selectorsToAnimate = [
        '.wp-block-heading',
        '.wp-block-paragraph',
        '.wp-block-image',
        '.wp-block-button',
        '.wp-block-column',
        '.ast-article-post',
        '.sds-animate-group',
        '.sds-scroll-animate' // Catch any elements where we manually added this class
    ];

    const elements = document.querySelectorAll(selectorsToAnimate.join(', '));
    
    // Add base class to all selected elements
    elements.forEach(el => {
        el.classList.add('sds-scroll-animate');
    });

    const observerOptions = {
        root: null,
        rootMargin: '0px',
        threshold: 0.15
    };

    const observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('sds-animated');
                observer.unobserve(entry.target); // Only animate once
            }
        });
    }, observerOptions);

    elements.forEach(el => {
        observer.observe(el);
    });

    // 2. STAGGERED COLUMNS
    // Add slight delays to columns so they don't appear all at once
    const columnContainers = document.querySelectorAll('.wp-block-columns');
    columnContainers.forEach(container => {
        const columns = container.querySelectorAll('.wp-block-column');
        columns.forEach((col, index) => {
            col.style.transitionDelay = `${index * 150}ms`;
        });
    });
});
