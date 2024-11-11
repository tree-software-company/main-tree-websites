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

document.querySelector('.search-button-mobile').addEventListener('click', () => {
    document.querySelector('.search-dropdown-mobile').classList.add('activeFlex');
});

document.querySelector('.account-button-mobile').addEventListener('click', () => {
    document.querySelector('.account-dropdown-mobile').classList.add('activeFlex');
});

document.querySelector('.menu-button-mobile').addEventListener('click', () => {
    document.querySelector('.menu-dropdown-mobile').classList.add('activeFlex');
});

document.querySelectorAll('.close').forEach(button => {
    button.addEventListener('click', () => {
      document.querySelectorAll('.activeFlex').forEach(element => {
        element.classList.remove('activeFlex');
        console.log('close');
      });
    });
});
  



