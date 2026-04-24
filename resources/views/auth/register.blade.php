<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="d-flex justify-content-center align-items-center vh-100">

    <div class="card p-4 shadow" style="width:400px;">
        <h4 class="text-center mb-3">Register</h4>

        {{-- ✅ ERROR VALIDATION --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- ✅ SUCCESS --}}
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Nama -->
            <input type="text" name="name" value="{{ old('name') }}" class="form-control mb-2" placeholder="Nama" required>

            <!-- Email -->
            <input type="email" name="email" value="{{ old('email') }}" class="form-control mb-2" placeholder="Email" required>

            <!-- No Telepon -->
            <input type="text" name="phone" value="{{ old('phone') }}" class="form-control mb-2" placeholder="No Telepon" required>

            <!-- Divisi (readonly, tidak dikirim ke backend) -->
            <input type="text" class="form-control mb-2" value="Divisi Keuangan" readonly style="background-color:#e9ecef;">

            <!-- Jabatan -->
            <input type="text" name="jabatan" value="{{ old('jabatan') }}" class="form-control mb-2" placeholder="Jabatan" required>

            <!-- Password -->
            <div class="input-group mb-2">
                <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
                <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('password')">👁</button>
            </div>

            <!-- Konfirmasi Password -->
            <div class="input-group mb-3">
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Konfirmasi Password" required>
                <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('password_confirmation')">👁</button>
            </div>

            <button class="btn btn-dark w-100">Daftar</button>

            <p class="text-center mt-2">
                Sudah punya akun? <a href="{{ route('login') }}">Login</a>
            </p>
        </form>
    </div>

</div>

<script>
function togglePassword(id) {
    const input = document.getElementById(id);
    input.type = input.type === "password" ? "text" : "password";
}
</script>

</body>
</html>