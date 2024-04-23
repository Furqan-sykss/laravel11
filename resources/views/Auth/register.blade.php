<!-- resources/views/auth/register.blade.php -->

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Register Akun</title>
</head>

<body>

    <div class="container" style="margin-top: 50px">
        <div class="row">
            <div class="col-md-5 offset-md-3">
                <div class="card">
                    <div class="card-body">
                        <label>REGISTER</label>
                        <hr>

                        <form method="POST" action="{{ route('register.store') }}">
                            @csrf

                            <div class="form-group">
                                <label>Nama Lengkap</label>
                                <input type="text" class="form-control" name="name"
                                    placeholder="Masukkan Nama Lengkap">
                            </div>

                            <div class="form-group">
                                <label>Alamat Email</label>
                                <input type="email" class="form-control" name="email"
                                    placeholder="Masukkan Alamat Email">
                            </div>

                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" class="form-control" name="password"
                                    placeholder="Masukkan Password">
                            </div>

                            <button type="submit" class="btn btn-register btn-block btn-success">REGISTER</button>
                        </form>

                    </div>
                </div>

                <div class="text-center" style="margin-top: 15px">
                    Sudah punya akun? <a href="{{ route('login') }}">Silahkan Login</a>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/8.11.8/sweetalert2.all.min.js"></script>

    <script>
        $(document).ready(function() {
            // JavaScript code for form validation and AJAX submission remains the same
        });
    </script>

</body>

</html>
