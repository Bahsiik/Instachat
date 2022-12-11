document.addEventListener('DOMContentLoaded', () => {
    const defaultAnchor = window.location.hash;
    if (defaultAnchor) {
        const defaultAnchorElement = document.querySelector(defaultAnchor);
        if (defaultAnchorElement) {
            defaultAnchorElement.scrollIntoView({
                behavior: 'smooth', block: 'end',
            });
        }
    }
});
