// resources/js/landing.js

document.addEventListener('DOMContentLoaded', function () {
    const otaButton = document.querySelector('.btn-ota');
    const registrationForm = document.querySelector('.registration-form');
    const closeIcon = document.querySelector('.close-form');
  
    // Show the registration form on button click
    otaButton.addEventListener('click', function () {
      registrationForm.style.display = 'block';
    });
  
    // Hide the registration form on close icon click
    closeIcon.addEventListener('click', function () {
      registrationForm.style.display = 'none';
    });
  
    // Accordion functionality
    const accordionQuestions = document.querySelectorAll('.accordion-question');
  
    accordionQuestions.forEach(question => {
      question.addEventListener('click', function () {
        const item = question.parentNode;
        item.classList.toggle('active');
  
        // Close other accordion items
        accordionQuestions.forEach(q => {
          if (q !== question) {
            q.parentNode.classList.remove('active');
          }
        });
      });
    });
  });
  