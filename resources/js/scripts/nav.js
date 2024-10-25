document.addEventListener('DOMContentLoaded', function () {
    // Funkcja do zarządzania rozwijanym elementem
    function handleHover(button, dropdown) {
        let timer;

        button.addEventListener('mouseenter', function () {
            clearTimeout(timer);
            dropdown.style.display = 'block'; // Pokazuje rozwinięcie

            // Dostosowanie pozycji, aby nie wychodziła poza prawą krawędź
            const rect = dropdown.getBoundingClientRect();
            const rightEdge = window.innerWidth - rect.right;

            if (rightEdge < 0) {
                dropdown.style.left = 'auto'; // Resetujemy lewą pozycję
                dropdown.style.right = '0'; // Wyrównanie do prawej
            }
        });

        button.addEventListener('mouseleave', function () {
            // Ustal czas na utrzymanie rozwinięcia
            timer = setTimeout(function () {
                dropdown.style.display = 'none'; // Ukrywa rozwinięcie
            }, 0); // Ustawienie na 300 ms
        });

        dropdown.addEventListener('mouseenter', function () {
            clearTimeout(timer); // Anuluje timer, gdy myszka jest nad rozwinięciem
            dropdown.style.display = 'block'; // Zapewnia, że dropdown jest widoczny
        });

        dropdown.addEventListener('mouseleave', function () {
            timer = setTimeout(function () {
                dropdown.style.display = 'none'; // Ukrywa rozwinięcie
            }, 0); // Ustawienie na 300 ms
        });
    }

    // Wybierz elementy rozwijane
    const loginButton = document.querySelector('.account');
    const loginDropdown = document.querySelector('.account-dropdown');

    const searchButton = document.querySelector('.search');
    const searchDropdown = document.querySelector('.search-dropdown');

    // Przypisz funkcje do elementów
    if (loginButton && loginDropdown) {
        handleHover(loginButton, loginDropdown);
    }

    if (searchButton && searchDropdown) {
        handleHover(searchButton, searchDropdown);
    }
});

