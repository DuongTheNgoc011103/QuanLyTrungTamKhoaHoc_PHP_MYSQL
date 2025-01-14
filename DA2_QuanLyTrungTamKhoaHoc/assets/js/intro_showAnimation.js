const contents = document.querySelectorAll(".content");

window.addEventListener('scroll', function() {
    const triggerBottom = window.innerHeight / 5 * 4;
    
    contents.forEach(content => {
        const contentTop = content.getBoundingClientRect().top;
        
        if (contentTop < triggerBottom) {
            content.classList.add('show-animation');
        } else {
            content.classList.remove('show-animation');
        }
    });
});

// Initial check in case content is already in view
window.dispatchEvent(new Event('scroll'));
