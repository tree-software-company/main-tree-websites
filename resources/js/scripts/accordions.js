document.addEventListener('DOMContentLoaded', () => {
    const headers = document.querySelectorAll('.accordion-header');

    headers.forEach(header => {
        header.addEventListener('click', () => {
            const content = header.nextElementSibling;

            // Close other open accordions (optional)
            document.querySelectorAll('.accordion-content').forEach(acc => {
                if (acc !== content) acc.classList.remove('active');
            });

            // Toggle current accordion
            content.classList.toggle('active');
        });
    });
});
