document.addEventListener('DOMContentLoaded', function () {
    function handleHover(button, dropdown) {
        let timer;

        button.addEventListener('mouseenter', function () {
            clearTimeout(timer);
            dropdown.style.display = 'block';

            const rect = dropdown.getBoundingClientRect();
            const rightEdge = window.innerWidth - rect.right;

            if (rightEdge < 0) {
                dropdown.style.left = 'auto'; 
                dropdown.style.right = '0'; 
            }
        });

        button.addEventListener('mouseleave', function () {
            timer = setTimeout(function () {
                dropdown.style.display = 'none'; 
            }, 0); 
        });

        dropdown.addEventListener('mouseenter', function () {
            clearTimeout(timer);
            dropdown.style.display = 'block'; 
        });

        dropdown.addEventListener('mouseleave', function () {
            timer = setTimeout(function () {
                dropdown.style.display = 'none'; 
            }, 0); 
        });
    }

    const loginButton = document.querySelector('.account');
    const loginDropdown = document.querySelector('.account-dropdown');

    const searchButton = document.querySelector('.search');
    const searchDropdown = document.querySelector('.search-dropdown');

    const softwareButton = document.querySelector('.software');
    const softwareDropdown = document.querySelector('.software-dropdown');

    if (loginButton && loginDropdown) {
        handleHover(loginButton, loginDropdown);
    }

    if (searchButton && searchDropdown) {
        handleHover(searchButton, searchDropdown);
    }

    if (softwareButton && softwareDropdown) {
        handleHover(softwareButton, softwareDropdown);
    }
});

//mobile nav



