@extends('layouts.app')

@section('content')

<div class="landing-page">
  <div class="content">
    <div class="hero">
      <h1>Welcome to Our Amazing Service</h1>
      <p class="tagline">Experience the best in class with our all-in-one solution.</p>
    </div>

    <div class="product-description">
      <h2>Our Product Features</h2>
      <p>Our service offers you top-tier features that will help you streamline your process and achieve incredible results.</p>
      <ul>
        <li>Feature 1: High-quality performance</li>
        <li>Feature 2: Easy to use</li>
        <li>Feature 3: Flexible and customizable</li>
        <li>Feature 4: 24/7 customer support</li>
      </ul>
    </div>

    <div class="photo-ads">
      <h2>Why Choose Us?</h2>
      <div class="ads-container">
        <div class="ad">
          <img src="path_to_image1.jpg" alt="Ad 1">
          <p>Ad 1 - A brief description of what this ad represents.</p>
        </div>
        <div class="ad">
          <img src="path_to_image2.jpg" alt="Ad 2">
          <p>Ad 2 - A brief description of what this ad represents.</p>
        </div>
      </div>
    </div>

    <div class="faq">
      <h2>Frequently Asked Questions</h2>
      <div class="accordion">
        <div class="accordion-item">
          <button class="accordion-question">What is our service about?</button>
          <div class="accordion-answer">
            <p>Our service offers an all-in-one solution designed to streamline your tasks and improve productivity.</p>
          </div>
        </div>
        <div class="accordion-item">
          <button class="accordion-question">How can I register?</button>
          <div class="accordion-answer">
            <p>Click on the "Register Now" button to access the registration form and fill in your details.</p>
          </div>
        </div>
        <div class="accordion-item">
          <button class="accordion-question">Is customer support available?</button>
          <div class="accordion-answer">
            <p>Yes, our customer support team is available 24/7 to assist you with any questions.</p>
          </div>
        </div>
      </div>
    </div>

    <button class="btn-ota">Register Now</button>

    <div class="registration-form">
      <span class="icon-cross close-form"></span> 
      <h2>Registration</h2>
      <form action="#" method="POST">
        @csrf
        <div class="form-group">
          <label for="name">Full Name</label>
          <input type="text" name="name" id="name" required>
        </div>
        <div class="form-group">
          <label for="email">Email Address</label>
          <input type="email" name="email" id="email" required>
        </div>
        <button type="submit" class="btn-submit">Register</button>
      </form>
    </div>
  </div>
</div>

@endsection
    
