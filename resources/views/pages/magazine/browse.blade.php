@extends('layouts.app_public', ['class' => 'bg-default'])

@section('content')
    <div class="header bg-gradient-primary py-7 py-lg-8">
        <div class="container">
            <div class="card-columns">
                @foreach ($magazines as $magazine)
                    <div class="card">
                        <img class="card-img-top" src="{{asset($magazine->cover)}}" alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title">{{$magazine->title}}</h5>
                            <p class="card-text">{{$magazine->description}}</p>
                            <footer class="blockquote-footer text-right">
                                <small class="text-muted">
                                  <cite title="Source Title">{{$magazine->name}}</cite>
                                </small>
                            </footer>
                        </div>
                    </div>
                @endforeach
              </div>
        </div>
        <div class="separator separator-bottom separator-skew zindex-100">
            <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg">
                <polygon class="fill-default" points="2560 0 2560 100 0 100"></polygon>
            </svg>
        </div>
    </div>

    <div class="container mt--10 pb-5"></div>
@endsection
