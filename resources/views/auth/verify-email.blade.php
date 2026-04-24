<!DOCTYPE html>
<html>
<head>
    <title>Verifikasi Email</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="d-flex justify-content-center align-items-center vh-100">

    <div class="card p-4 shadow text-center" style="width:400px;">
        <h5 class="mb-3">Verifikasi Email</h5>

        <p>Silakan cek email kamu dan klik link verifikasi.</p>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button class="btn btn-dark w-100">
                Kirim Ulang Email
            </button>
        </form>

        <a href="{{ route('login') }}" class="d-block mt-2">Ke Login</a>
        
        
    </div>

</div>

</body>
</html>