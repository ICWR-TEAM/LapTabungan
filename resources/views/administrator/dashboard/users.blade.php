@extends("Layout.root")
@section("title", "Users")
@section("content")
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Tambah User</h6>
    </div>
    <div class="card-body">
        <form method="post">
            @csrf
            <label for="name"><strong>Nama:</strong></label>
            <input type="text" name="name" id="name" placeholder="Nama..." class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
            @error("name")
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
            <label for="email" class="mt-3"><strong>Email:</strong></label>
            <input type="email" name="email" id="email" placeholder="email..." class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
            @error("email")
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
            <label for="password" class="mt-3"><strong>Password:</strong></label>
            <input type="text" name="password" id="password" placeholder="Nama..." class="form-control @error('password') is-invalid @enderror" value="{{ old('password') }}">
            @error("password")
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
            <input type="submit" name="submit" value="Tambah User" class="btn btn-primary mt-3 col-md-12">
        </form>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Users</h6>
    </div>
    <div class="card-body">
        <pre>
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <td>No</td>
                        <td>Nama</td>
                        <td>Email</td>
                        <td width="150px">Terakhir Login</td>
                        <td width="100px">Aksi</td>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    @foreach($view_user as $user)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->updated_at }}</td>
                        <td><a href="{{ route('hapus_user', ['id'=>$user->id])}}" class="badge badge-danger">Hapus</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </pre>
    </div>
</div>

@endsection