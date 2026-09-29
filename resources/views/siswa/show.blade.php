@extends('adminlte::page')

@section('title', 'Detail Siswa')

@section('content_header')
    <h1>Detail Siswa</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                {{-- KOLOM KIRI: FOTO --}}
                <div class="col-md-4 d-flex justify-content-center align-items-start">
                    @if($siswa->foto)
                        {{-- Menampilkan foto jika ada --}}
                        <img src="{{ asset('storage/' . $siswa->foto) }}" 
                             alt="Foto {{ $siswa->nama_siswa }}" 
                             class="img-fluid rounded shadow-sm" 
                             style="max-width: 100%; max-height: 400px;">
                    @else
                        {{-- Placeholder jika tidak ada foto --}}
                        <div class="text-center">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($siswa->nama_siswa) }}&background=random" 
                                 class="img-fluid rounded-circle mb-3" 
                                 style="width: 150px;">
                            <p class="text-muted">Tidak ada foto</p>
                        </div>
                    @endif
                </div>

                {{-- KOLOM KANAN: DATA --}}
                <div class="col-md-8">
                    <table class="table table-striped table-bordered">
                        <tr>
                            <th style="width: 200px">Nama Siswa</th>
                            <td>{{ $siswa->nama_siswa }}</td>
                        </tr>
                        <tr>
                            <th>NIS</th>
                            <td>{{ $siswa->nis }}</td>
                        </tr>
                        <tr>
                            <th>Jurusan</th>
                            <td>{{ $siswa->jurusan }}</td>
                        </tr>
                        <tr>
                            <th>Kelas</th>
                            <td>{{ $siswa->kelas }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $siswa->email ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Terdaftar Pada</th>
                            <td>{{ $siswa->created_at->format('d F Y') }}</td>
                        </tr>
                    </table>

                    <div class="mt-4">
                        <a href="{{ route('siswa.edit', $siswa->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('siswa.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop