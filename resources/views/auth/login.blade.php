<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="d-flex justify-content-center align-items-center vh-100">

    <div class="card p-4 shadow" style="width:350px;">
        <h4 class="text-center mb-3">Login</h4>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <input type="email" name="email" class="form-control mb-2" placeholder="Email" required>
            <input type="password" name="password" class="form-control mb-2" placeholder="Password" required>

            <button class="btn btn-dark w-100">Login</button>

            <p class="text-center mt-2">
                Belum punya akun? <a href="{{ route('register') }}">Daftar</a>
            </p>
        </form>
    </div>

</div>

</body>
</html>