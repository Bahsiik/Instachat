document.addEventListener('DOMContentLoaded', () =>
    document.addEventListener('click', async e => {
        const target = e.target;
        if (target.closest('.comment-share')) {
            const link = target.closest('.comment-share').dataset.link;
            await copyToClipboard(window.location.origin + link);
        }
    }));

async function copyToClipboard(text) {
    await navigator.clipboard.writeText(text);
    showPopup("Lien copié !");
}
