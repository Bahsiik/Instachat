document.addEventListener('DOMContentLoaded', () => {
    const tabbedMenues = document.querySelectorAll('.tabbed-menu');

    tabbedMenues.forEach(tabbedMenu => {
        const tabs = tabbedMenu.querySelectorAll('.tab');
        const contents = tabbedMenu.querySelectorAll('.content > div');

        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                const tabId = tab.dataset.tab;
                const content = tabbedMenu.querySelector(`.content > div[data-tab="${tabId}"]`);

                tabs.forEach(tab => tab.classList.remove('selected'));
                contents.forEach(content => content.classList.remove('selected'));

                tab.classList.add('selected');
                content.classList.add('selected');
            });
        });
    });
});