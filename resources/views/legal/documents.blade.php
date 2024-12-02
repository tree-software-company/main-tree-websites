@extends('layouts.app')

@section('content')
<div class="legal-document">
    <h1>{{ $data['title'] }}</h1>
    <span>
        {{ $data['legal_document'] }}
    </span>
</div>
@endsection