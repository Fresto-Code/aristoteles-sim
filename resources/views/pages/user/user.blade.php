@extends('layouts.app')

@section('content')
@include('layouts.headers.cards_basic')
<div class="container-fluid mt--6">
    <!-- session create -->
    @if (session('create'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <span class="alert-text"><strong>Success!</strong> {{ session('create') }}</span>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <!-- session update -->
    @elseif (session('update'))
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        <span class="alert-text"><strong>Success!</strong> {{ session('update') }}</span>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <!-- session delete -->
    @elseif (session('delete'))
    <div class="alert alert-secondary alert-dismissible fade show" role="alert">
        <span class="alert-text"><strong>Success!</strong> {{ session('delete') }}</span>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <!-- session error -->
    @elseif (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <span class="alert-text"><strong>Error!</strong> {{ session('error') }}</span>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif
    <div class="row">
        <div class="col">
            <div class="card">
                <!-- Card header -->
                <div class="card-header border-0">
                    <div class="row">
                        <div class="col-xl-10 col-lg-6 col-md-5 col-sm-4">
                            <h2>Daftar User</h2>
                        </div>
                        <div class="col-xl-2 col-lg-6 col-md-7 col-sm-8">

                            <a href="{{ route('user.create') }}" class="btn btn-success float-left">Tambah User Baru</a>

                        </div>
                        <!-- search bar and filter with form-->
                        <form action="/search-user" class="col-xl-12 col-lg-12 col-md-12 col-sm-12" enctype="multipart/form-data">
                            <!-- filter -->
                            <div class="row">
                                <!-- role filter -->
                                <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2">
                                    <div class="form-group">
                                        <label for="role">Filter</label>
                                        <select class="form-control" id="role" name="role">
                                            <option value="all">-- Jenis User --</option>
                                            <option value="admin" @if(request('role')=='admin' ) selected @endif>Admin</option>
                                            <option value="teacher" @if(request('role')=='teacher' ) selected @endif>Teacher</option>
                                            <option value="student" @if(request('role')=='student' ) selected @endif>Student</option>
                                            <option value="osis" @if(request('role')=='osis' ) selected @endif>Osis</option>
                                            <option value="principal" @if(request('role')=='principal' ) selected @endif>Principal</option>
                                        </select>
                                    </div>
                                </div>
                                <!-- start date filter -->
                                <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2">
                                    <div class="form-group">
                                        <label for="start_date">Awal</label>
                                        <input type="date" class="form-control" id="start_date" name="start_date" value="{{ request('start_date') }}">
                                    </div>
                                </div>
                                <!-- end date filter -->
                                <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2">
                                    <div class="form-group">
                                        <label for="end_date">Akhir</label>
                                        <input type="date" class="form-control" id="end_date" name="end_date" value="{{ request('end_date') }}">
                                    </div>
                                </div>

                                <!-- search -->
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="search">Cari</label>
                                        <input type="search" class="form-control" id="search" placeholder="Cari User" name="search" value="{{request('search')}}">
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!-- List User -->
                        <div class="table-responsive">
                            <table class="table align-items-center table-flush">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col" class="sort" data-sort="action">Aksi</th>
                                        <th scope="col" class="sort" data-sort="title">Nama</th>
                                        <th scope="col" class="sort" data-sort="author">Role</th>
                                        <th scope="col" class="sort" data-sort="completion">Di Buat Pada</th>
                                        <th scope="col" class="sort" data-sort="completion">Terakhir Diperbaharui Pada</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody class="list">
                                    @foreach ($users as $user)
                                    <tr>
                                        <td>
                                            <!-- <button class="border-0 btn-white shadow-none">
                                                <a href="/user/{{ $user->id }}" class="btn btn-sm btn-primary">Lihat</a>
                                            </button> -->

                                            <!-- edit -->
                                            <button class="border-0 btn-white shadow-none">
                                                <a href="{{route('user.edit', $user->id)}}" class="btn btn-sm btn-warning">Edit</a>
                                            </button>
                                            <button class="border-0 btn-white shadow-none">
                                                <form action="{{route('user.softDelete', $user->id)}}" method="post">
                                                    @method('delete')
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                                </form>
                                            </button>
                                            <!-- change password -->
                                            <button class="border-0 btn-white shadow-none">
                                                <a href="{{route('user.changePassword', $user->id)}}" class="btn btn-sm btn-info">Ubah Password</a>
                                            </button>

                                        <th scope="row">
                                            <div class="media align-items-center">
                                                <a href="#" class="avatar avatar-sm rounded-circle mr-3" data-toggle="tooltip" data-original-title="{{$user->name}}">
                                                    <img alt="Image placeholder" src="{{ env('SPACES_URL') . $user->avatar }}">
                                                </a>
                                                <div class="media-body">
                                                    <span class="name mb-0 text-sm">{{ ucwords($user->name) }}</span>
                                                </div>
                                            </div>
                                        </th>
                                        <td>
                                            {{ ucwords($user->role) }}
                                        </td>
                                        <!-- format date -->
                                        <td>
                                            {{ date('d F Y', strtotime($user->created_at)) }}
                                        </td>
                                        <td>
                                            {{ date('d F Y', strtotime($user->updated_at)) }}
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
                                    {{ $users->links() }}
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