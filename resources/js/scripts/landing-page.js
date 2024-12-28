document.addEventListener('DOMContentLoaded', function () {
    const otaButton = document.querySelector('.btn-ota');
    const registrationForm = document.querySelector('.registration-form');
    const closeIcon = document.querySelector('.close-form');
  
    if (otaButton) {
        otaButton.addEventListener('click', function () {
            registrationForm.style.display = 'block';
        });
    }
  
    if (closeIcon) {
        closeIcon.addEventListener('click', function () {
            registrationForm.style.display = 'none';
        });
    }
  
    const accordionQuestions = document.querySelectorAll('.accordion-question');
  
    accordionQuestions.forEach(question => {
        question.addEventListener('click', function () {
            const item = question.parentNode;
            item.classList.toggle('active');
  
            accordionQuestions.forEach(q => {
                if (q !== question) {
                    q.parentNode.classList.remove('active');
                }
            });
        });
    });
});