@extends('layouts.app')

@section('content')
    <div class="support-youth">
        <div class="container">
            <h1>{{ $data['title'] }}</h1>
            <p>
                {{ $data['short_description_1'] }}
            </p>
            <ul class="initiatives">
                @if($data['list_section_1'])
                    @foreach($data['list_section_1'] as $list)
                        <li>{{ $list }}</li>
                    @endforeach
                @endif
            </ul>
        </div>
    </div>
@endsection