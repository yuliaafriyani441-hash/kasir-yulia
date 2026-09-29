
@extends('adminlte::page')

@section('title', 'Edit Guru')

@section('content_header')
    <h1>Edit Guru</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('guru.update', $guru->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="nama_guru">Nama Guru</label>
                    <input type="text" name="nama_guru" class="form-control" id="nama_guru" value="{{ $guru->nama_guru }}" required>
                </div>

                <div class="form-group">
                    <label for="nip">Nip</label>
                    <input type="text" name="nip" class="form-control" id="nip" value="{{ $guru->nip }}" required>
                </div>

                <div class="form-group">
                    <label for="mata_pelajaran">Mata_pelajaran</label>
                    <input type="text" name="mata_pelajaran" class="form-control" id="mata_pelajaran" value="{{ $guru->mata_pelajaran }}">
                </div>

                <div class="form-group">
                    <label for="jenis_kelamin">Jenis_kelamin</label>
                    <input type="text" name="jenis_kelamin" class="form-control" id="jenis_kelamin" value="{{ $guru->jenis_kelamin }}">
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" class="form-control" id="email" value="{{ $guru->email }}">
                </div>
                <div class="form-group">
                    <label for="foto">Foto Guru</label>
                                        
                        @if($guru->foto)
                    <div class="mb-2">
                            <p class="text-muted">Foto saat ini:</p>
                                <img src="{{ asset('storage/' . $guru->foto) }}" alt="Foto Lama" class="img-thumbnail" style="width: 150px;">
                    </div>
                        @endif

                    <input type="file" name="foto" class="form-control-file @error('foto') is-invalid @enderror" id="foto" accept="image/*">
                        <small class="form-text text-muted">
                            Biarkan kosong jika tidak ingin mengubah foto. Format: JPG, PNG. Max 2MB.
                        </small>
                                        
                        @error('foto')
                        <span class="text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('guru.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
@stop