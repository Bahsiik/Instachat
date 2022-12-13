document.addEventListener('DOMContentLoaded', () => {
    const postId = document.querySelector('article.post-container').dataset.postId;
    const fetchFeed = new FetchFeed(`/comments?post-id=${postId}&offset=`, document.querySelector('.comments'));
    fetchFeed.addScripts(elements => twemoji.parse(elements));

    document.addEventListener('click', async e => {
        const target = e.target;
        if (target.closest('.comment-share')) {
            const link = target.closest('.comment-share').dataset.link;
            await copyToClipboard(window.location.origin + link);
        }
    });
});

async function copyToClipboard(text) {
    await navigator.clipboard.writeText(text);
    showPopup("Lien copié !");
}
