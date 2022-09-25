@extends('layouts.app')

@section('content')
    @include('layouts.headers.cards_basic')
    <div class="container-fluid mt--6">
        <div class="row">
            <div class="col">
                <div class="card">
                    <!-- Card header -->
                    <div class="card-header border-0">
                        <div class="row">
                            <div class="col-sm">
                                <h2>Daftar E-Magazine</h2>
                            </div>
                            <div class="col-sm">
                                <a href="{{ url('magazine/browse/dashboard') }}" class="btn btn-success float-right">Jelajahi
                                    PDF</a>
                            </div>
                        </div>


                    </div>
                    <!-- List E-Magazine -->
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col" class="sort" data-sort="action">Aksi</th>
                                    <th scope="col" class="sort" data-sort="title">Judul</th>
                                    <th scope="col" class="sort" data-sort="author">Penulis</th>
                                    <th scope="col" class="sort" data-sort="moderation_status">Moderation Status</th>
                                    <th scope="col" class="sort" data-sort="description">Deskripsi</th>
                                    <th scope="col" class="sort" data-sort="completion">Di Buat Pada</th>
                                    <th scope="col" class="sort" data-sort="completion">Terakhir Diperbaharui Pada</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                @foreach ($magazines as $magazine)
                                    <tr>
                                        <td>
                                            <button class="border-0 btn-white shadow-none">
                                                <a href="/magazine/{{ $magazine->id }}"
                                                    class="btn btn-sm btn-primary">Lihat</a>
                                            </button>
                                            @if (Auth::user()->role == 'admin' ||
                                                Auth::user()->role == 'teacher' ||
                                                Auth::user()->role == 'osis' ||
                                                Auth::user()->role == 'principal' ||
                                                (Auth::user()->role == 'student' && $magazine->moderation_status == 'draft'))
                                                <button class="border-0 btn-white shadow-none">
                                                    <form action="/magazine/{{ $magazine->id }}" method="post">
                                                        @method('delete')
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                                </button>
                                            @endif
                                            @if ($magazine->moderation_status == 'draft')
                                                @if (Auth::user()->role == 'admin' ||
                                                    Auth::user()->role == 'teacher' ||
                                                    Auth::user()->role == 'osis' ||
                                                    Auth::user()->role == 'principal')
                                                    <button class="border-0 btn-white shadow-none">
                                                        <form action="/magazine/{{ $magazine->id }}/approve" method="post">
                                                            @method('PATCH')
                                                            @csrf
                                                            <button type="submit"
                                                                class="btn btn-sm btn-success">Setujui</button>
                                                        </form>
                                                    </button>
                                                @endif
                                            @endif
                                        <td>
                                            {{ $magazine->title }}
                                        </td>
                                        <th scope="row">
                                            <div class="media align-items-center">
                                                <a href="#" class="avatar avatar-sm rounded-circle mr-3"
                                                    data-toggle="tooltip" data-original-title="Ryan Tompson">
                                                    <img alt="Image placeholder" src="{{ env('SPACES_URL') . $magazine->avatar }}">
                                                </a>
                                                <div class="media-body">
                                                    <span class="name mb-0 text-sm">{{ $magazine->name }}</span>
                                                </div>
                                            </div>
                                        </th>
                                        <td>
                                            <span class="badge badge-dot mr-4">
                                                @if ($magazine->moderation_status == 'draft')
                                                    <i class="bg-warning"></i>
                                                    <span class="status">{{ $magazine->moderation_status }}</span>
                                                @else
                                                    <i class="bg-success"></i>
                                                    <span class="status">{{ $magazine->moderation_status }}</span>
                                                @endif
                                            </span>
                                        </td>
                                        <td class="w-25">
                                            {{ $magazine->description }}
                                        </td>
                                        <td>
                                            {{ $magazine->created_at }}
                                        </td>
                                        <td>
                                            {{ $magazine->updated_at }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- Card footer -->
                    <div class="card-footer py-4">
                        <nav>
                            <ul class="pagination justify-content-end mb-0">
                                

                            </ul>
                            <div class="d-flex justify-content-end">
                                {{ $magazines->links("pagination::bootstrap-4") }}
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->

    </div>
@endsection

@push('js')
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
@endpush
