<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ingresar - SISCAP</title>
    @include('partials.styles')
</head>
<body class="bg-light">
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="col-md-5 col-lg-4">
            
            <div class="text-center mb-4">
                <a href="{{ url('/') }}" class="text-decoration-none text-dark">
                    <h4 class="mb-0" style="font-family: 'Outfit', sans-serif; font-weight: 700;">
                         SISCAP
                    </h4>
                </a>
            </div>

            <div class="card card-corporate">
                <div class="card-header py-3 text-center">
                    <h6 class="w-100 mb-0 font-weight-bold" style="font-size: 1.1rem">
                        Ingresar al Sistema
                    </h6>
                </div>
                <div class="card-body p-4">

                    <form action="{{ route('login') }}" method="post">
                        @csrf

                        <!-- Campo de ficha -->
                        <div class="input-group mb-3">
                            <input type="text" id="ficha" name="ficha" class="form-control @error('ficha') is-invalid @enderror"
                                value="{{ old('ficha') }}" placeholder="Ficha de trabajador" autofocus style="height: 45px;">
                            <div class="input-group-append">
                                <div class="input-group-text bg-white">
                                    <span class="fas fa-id-badge text-muted"></span>
                                </div>
                            </div>
                            @error('ficha')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Campo de contraseña -->
                        <div class="input-group mb-4">
                            <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror"
                                    placeholder="Contraseña" style="height: 45px;">
                            <div class="input-group-append">
                                <div class="input-group-text bg-white">
                                    <span class="fas fa-lock text-muted"></span>
                                </div>
                            </div>
                        </div>        

                        <div class="row mt-4">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary btn-block font-weight-bold" style="height: 45px; border-radius: 6px;">
                                    <span class="fas fa-sign-in-alt mr-2"></span> Entrar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="text-center mt-4">
                <small class="text-muted">VENPRECAR, C.A. - @2026</small>
            </div>
        </div>
    </div>
</body>
</html>