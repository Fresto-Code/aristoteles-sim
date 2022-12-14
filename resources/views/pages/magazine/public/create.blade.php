@extends('layouts.app_magazine', ['class' => 'bg-default'])

@section('content')
<div class="header bg-gradient-primary py-7 py-lg-8">
    <div class="container">
        <!--Create form-->

        <!-- Table -->
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                <div class="card bg-secondary shadow border-0">
                    <div class="card-body px-lg-5 py-lg-5">
                        <h2 class="card-title text-center">Tambah Magazine</h2>
                        <form role="form" method="POST" action="{{ route('magazine') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group{{ $errors->has('title') ? ' has-danger' : '' }}">
                                <div class="input-group input-group-alternative mb-3">
                                    <input class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" placeholder="{{ __('judul') }}" type="text" name="title" value="{{ old('title') }}" required autofocus>
                                </div>
                                @if ($errors->has('title'))
                                <span class="invalid-feedback" style="display: block;" role="alert">
                                    <strong>{{ $errors->first('title') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('description') ? ' has-danger' : '' }}">
                                <div class="input-group input-group-alternative mb-3">
                                    <textarea class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" placeholder="{{ __('deskripsi') }}" name="description" value="{{ old('description') }}" required rows="7"></textarea>
                                </div>
                                @if ($errors->has('description'))
                                <span class="invalid-feedback" style="display: block;" role="alert">
                                    <strong>{{ $errors->first('description') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('cover_file') ? ' has-danger' : '' }}">
                                <label class="form-label" for="customFile">Pilih Cover</label>
                                <input type="file" class="form-control input-group-alternative " name="cover_file">
                                @if ($errors->has('cover_file'))
                                <span class="invalid-feedback" style="display: block;" role="alert">
                                    <strong>{{ $errors->first('cover_file') }}</strong>
                                </span>
                                @endif

                            </div>
                            <div class="form-group{{ $errors->has('magazine_file') ? ' has-danger' : '' }}">

                                <label class="form-label" for="customFile">Pilih Magazine PDF</label>
                                <input type="file" class="form-control input-group-alternative" name="magazine_file">
                                @if ($errors->has('magazine_file'))
                                <span class="invalid-feedback" style="display: block;" role="alert">
                                    <strong>{{ $errors->first('magazine_file') }}</strong>
                                </span>
                                @endif


                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-success mt-4">{{ __('Tambah') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
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