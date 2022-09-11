@extends('layouts.app')

@section('content')
    @include('layouts.headers.cards_basic')
        <div class="container-fluid mt--6">
            <div class="row">
            <div class="col">
                <div class="card">
                <!-- Card header -->
                <div class="card-header border-0">
                    <h3 class="mb-0">Daftar E-Magazine</h3>
                </div>
                <!-- List E-Magazine -->
                <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                    <thead class="thead-light">
                        <tr>
                        <th scope="col" class="sort" data-sort="title">Judul</th>
                        <th scope="col" class="sort" data-sort="author">Penulis</th>
                        <th scope="col" class="sort" data-sort="author">Deskripsi</th>
                        <th scope="col" class="sort" data-sort="moderation_status">Moderation Status</th>
                        <th scope="col" class="sort" data-sort="completion">Di Buat Pada</th>
                        <th scope="col" class="sort" data-sort="completion">Terakhir Diperbaharui Pada</th>
                        <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody class="list">
                        <tr>
                        <td>
                            Kebangkitan surya
                        </td>
                        <th scope="row">
                            <div class="media align-items-center">
                            <a href="#" class="avatar avatar-sm rounded-circle mr-3" data-toggle="tooltip" data-original-title="Ryan Tompson">
                                <img alt="Image placeholder" src="../assets/img/theme/team-1.jpg">
                            </a>
                            <div class="media-body">
                                <span class="name mb-0 text-sm">Alex Jaya</span>
                            </div>
                            </div>
                        </th>
                        <td>
                            Cerita rakyat
                        </td>
                        <td>
                            <span class="badge badge-dot mr-4">
                            <i class="bg-warning"></i>
                            <span class="status">pending</span>
                            </span>
                        </td>
                        <td>
                            17 April 2022
                        </td>
                        <td>
                            19 April 2022
                        </td>
                        </tr>
                        
                    </tbody>
                    </table>
                </div>
                <!-- Card footer -->
                <div class="card-footer py-4">
                    <nav aria-label="...">
                    <ul class="pagination justify-content-end mb-0">
                        <li class="page-item disabled">
                        <a class="page-link" href="#" tabindex="-1">
                            <i class="fas fa-angle-left"></i>
                            <span class="sr-only">Previous</span>
                        </a>
                        </li>
                        <li class="page-item active">
                        <a class="page-link" href="#">1</a>
                        </li>
                        <li class="page-item">
                        <a class="page-link" href="#">2 <span class="sr-only">(current)</span></a>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                        <a class="page-link" href="#">
                            <i class="fas fa-angle-right"></i>
                            <span class="sr-only">Next</span>
                        </a>
                        </li>
                    </ul>
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