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
                        <div class="col-xl-8 col-lg-6 col-md-5 col-sm-4">
                            <h2>Daftar E-Magazine</h2>
                        </div>
                        <div class="col-xl-4 col-lg-6 col-md-7 col-sm-8">

                            <a href="{{ url('magazine/choose/type') }}" class="btn btn-success float-left">Tambah E-Magazine</a>


                            <a href="{{ url('magazine/browse/dashboard') }}" class="btn btn-primary float-right">Jelajahi PDF</a>

                        </div>
                        <!-- search bar and filter with form-->
                        <form action="/search-own" class="col-xl-12 col-lg-12 col-md-12 col-sm-12" enctype="multipart/form-data">
                            <!-- filter -->
                            <div class="row">
                                <!-- status filter -->
                                <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2">
                                    <div class="form-group">
                                        <label for="status">Filter</label>
                                        <select class="form-control" id="status" name="status">
                                            <option value="all">. . .</option>
                                            <option value="draft" @if(request('status')=='draft' ) selected @endif>Draft</option>
                                            <option value="published" @if(request('status')=='published' ) selected @endif>Published</option>
                                        </select>
                                    </div>
                                </div>
                                <!-- start date filter -->
                                <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2">
                                    <div class="form-group">
                                        <label for="start_date">Tanggal Mulai</label>
                                        <input type="date" class="form-control" id="start_date" name="start_date" value="{{ request('start_date') }}">
                                    </div>
                                </div>
                                <!-- end date filter -->
                                <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2">
                                    <div class="form-group">
                                        <label for="end_date">Tanggal Akhir</label>
                                        <input type="date" class="form-control" id="end_date" name="end_date" value="{{ request('end_date') }}">
                                    </div>
                                </div>

                                <!-- search -->
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="search">Cari</label>
                                        <input type="search" class="form-control" id="search" placeholder="Cari E-Magazine" name="search" value="{{request('search')}}">
                                    </div>
                                </div>
                            </div>
                        </form>
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
                                                <a href="/magazine/{{ $magazine->id }}" class="btn btn-sm btn-primary">Lihat</a>
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
                                                </form>
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
                                                    <button type="submit" class="btn btn-sm btn-success">Setujui</button>
                                                </form>
                                            </button>
                                            @endif
                                            @endif
                                        <td>
                                            {{ ucwords($magazine->title) }}
                                        </td>
                                        <th scope="row">
                                            <div class="media align-items-center">
                                                <a href="#" class="avatar avatar-sm rounded-circle mr-3" data-toggle="tooltip" data-original-title="{{$magazine->name}}">
                                                    <img alt="Image placeholder" src="{{ env('SPACES_URL') . $magazine->avatar }}">
                                                </a>
                                                <div class="media-body">
                                                    <span class="name mb-0 text-sm">{{ ucwords($magazine->name) }}</span>
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
                                    {{ $magazines->links() }}
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