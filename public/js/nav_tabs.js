    document.addEventListener('DOMContentLoaded', function () {
        const tabLinks = document.querySelectorAll('.nav-link[role="tab"]');

        tabLinks.forEach(tabLink => {
            tabLink.addEventListener('keydown', function (event) {
                if (event.key === 'Enter' || event.key === ' ') {
                    event.preventDefault();
                    tabLink.click();
                }
            });
        });
    });
