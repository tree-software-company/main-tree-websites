@extends('layouts.app')

@section('content')
    <!-- resources/views/landing.blade.php -->

<div class="landing-page">
    <div class="content">
      <!-- Hero Section with Title and Description -->
      <div class="hero">
        <h1>Welcome to Our Amazing Service</h1>
        <p class="tagline">Experience the best in class with our all-in-one solution.</p>
      </div>
  
      <!-- Product Description Section -->
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
  
      <!-- Product Advertisement Section with Images -->
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
  
      <!-- Registration Button -->
      <button class="btn-ota">Register Now</button>
  
      <!-- Registration Form (Initially hidden) -->
      <div class="registration-form">
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
          <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" required>
          </div>
          <button type="submit" class="btn-submit">Register</button>
        </form>
      </div>
    </div>
  </div>  
@endsection
    
