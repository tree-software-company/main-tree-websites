@extends('layouts.app')

@section('content')
    <div class="banners">
        <div class="banner">Banner 1</div>
        <div class="banner">Banner 2</div>
        <div class="banner">Banner 3</div>
    </div>
    
    <div class="products">
        <div class="row">
            <div class="column">Product 1</div>
            <div class="column">Product 2</div>
        </div>
        <div class="row">
            <div class="column">Product 3</div>
            <div class="column">Product 4</div>
        </div>
        <div class="row">
            <div class="column">Product 5</div>
            <div class="column">Product 6</div>
        </div>
    </div>

    <div class="sliders">
        <div class="slider long-slider">Long Slider</div>
        <div class="slider short-slider">Short Slider</div>
    </div>
@endsection

@section('Footercontent')
    <span class="text">Footer Content</span>
@endsection
