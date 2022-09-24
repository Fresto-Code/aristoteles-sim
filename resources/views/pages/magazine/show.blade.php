@extends('layouts.app')

@section('content')
@include('pages.magazine.header', [
'title' => __($magazine->title),
'description' => __($magazine->description),
'cover' => $magazine->cover,
'status' => $magazine->moderation_status,
'class' => 'col-lg-7',
])

<div class="container-fluid mt--7">
    <div class="row">
        <div class="col-xl-4 order-xl-2 mb-5 mb-xl-0">
            <div class="card card-profile shadow ">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <div class="card-profile-stats d-flex justify-content-center">
                                <div>
                                    <span class="heading">{{ $magazine->name }}</span>
                                    <span class="description">{{ __('Penulis') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if (Auth::user()->role == 'admin' || Auth::user()->role == 'teacher' || Auth::user()->role == 'osis')
                    <div class="row">
                        <div class="col">
                            <div class="card-profile-stats d-flex justify-content-center">
                                @if ($magazine->moderation_status == 'draft')
                                <form class="m-1" action="/magazine/{{ $magazine->id }}/approve" method="post">
                                    @method('PATCH')
                                    @csrf
                                    <button type="submit" class="btn btn-success">Setujui</button>
                                </form>
                                @else
                                <form class="m-1" action="/magazine/{{ $magazine->id }}/cancel" method="post">
                                    @method('PATCH')
                                    @csrf
                                    <button type="submit" class="btn btn-yellow">Ubah ke Draft</button>
                                </form>
                                @endif
                                <form class="m-1" action="/magazine/{{ $magazine->id }}" method="post">
                                    @method('delete')
                                    @csrf
                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endif
                    <div id="accordion">
                        <div class="card border-1">
                            <div class="card-header" id="headingOne">
                                <h5 class="mb-0">
                                    <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        Lihat Komentar
                                    </button>
                                </h5>
                            </div>

                            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                                @if (count($comments) === 0)
                                <div class="card-body">
                                    <p class="text-center">Belum ada komentar</p>
                                </div>
                                @else
                                <div class="card-body">
                                    @foreach ($comments as $comment)
                                    <div class="row mb-3">
                                        <div class="card p-3 w-100 border-0 shadow-sm">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="user d-flex flex-row align-items-center">
                                                    <img src="{{ asset('assets/img/icons/common/profile.png') }}" width="30" class="user-img rounded-circle mr-2">
                                                    <span>
                                                        <small class="font-weight-bold text-primary">{{ $comment->name }}:
                                                        </small>
                                                    </span>
                                                </div>
                                                <small>{{ $comment->created_at }}</small>
                                            </div>
                                            <div class="post-description mt-2">
                                                <p>{{ $comment->comment }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3 m-1">
                        <!--comment form-->
                        <form action="/moderation-comment/{{ $magazine->id }}" method="post" style="display:block; width:100%;">
                            @csrf
                            <div class="form-group">
                                <label for="comment">Beri komentar</label>
                                <textarea class="form-control border-1" style="resize: none;" name="comment" id="comment" rows="3"></textarea>
                            </div>
                            <button type="submit" class="btn btn-success  float-right">Kirim</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-8 order-xl-1">
            <div class="card bg-secondary shadow">
                <div class="card-body">
                    <object data="your_url_to_pdf" type="application/pdf">
                        <iframe src="{{ $magazine->url }}" height="1000px" style=" display:block;
                                width:100%;"></iframe>
                    </object>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.footers.auth')
</div>
@endsection

@push('js')
<script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
<script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
@endpush