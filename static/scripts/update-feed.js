document.addEventListener("DOMContentLoaded", () => {
    const feedContainer = document.querySelector('.feed-container');
    const lastChild = feedContainer.lastElementChild;
    let offset = 5;

    const observer = new IntersectionObserver(async (entries) => {
        if (entries[0].isIntersecting) {
            const url = `${window.location.origin}/getFeed?offset=${offset}`;
            const request = await fetch(url, {
                method: 'GET',
                credentials: 'include',
            });
            const text = await request.text();
            feedContainer.insertAdjacentHTML('beforeend', text);
            offset += 5;
        }
    });
    observer.observe(lastChild);
});
