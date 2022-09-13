@extends('layouts.app_magazine', ['class' => 'bg-default'])

@section('content')
    <div class="header bg-gradient-primary py-7 py-lg-8">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                  <div class="card">
                    <div class="card-body">
                      <h5 class="card-title">Unggah PDF</h5>
                      <p class="card-text">Sebarkan E-Magazine mu yang sudah berbentuk PDF</p>
                      <a href="{{ url('magazine/create') }}" class="btn btn-primary">Pilih</a>
                    </div>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="card">
                    <div class="card-body">
                      <h5 class="card-title">Tulis E-Magazine</h5>
                      <p class="card-text">Tulis sendiri beritamu dan sebarkan sebagai PDF</p>
                      <a href="{{ url('magazine/inline/editor')}}" class="btn btn-primary">Pilih</a>
                    </div>
                  </div>
                </div>
              </div>
        </div>
        <div class="separator separator-bottom separator-skew zindex-100">
            <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1"
                xmlns="http://www.w3.org/2000/svg">
                <polygon class="fill-default" points="2560 0 2560 100 0 100"></polygon>
            </svg>
        </div>
    </div>

    <div class="container mt--10 pb-5"></div>
@endsection
