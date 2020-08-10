<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>RyCsoft</title>
    
        <!-- Script -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/2.2.0/anime.min.js"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <script src="{{ asset('./public/js/login.js') }}" defer></script>

        <!-- Style -->
        <link rel="icon" href="{{ asset('./public/icon/favicon.ico') }}"/>
        <link rel="stylesheet" href="{{ asset('./public/css/login.css') }}" media="all" rel="stylesheet">

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <script>
            // Funcion para mostrar mensaje de validacion
            function message(){
                var message = document.getElementById('validation_message').value;
                swal({
                    title: message,
                    text: 'Verifica que la contraseña o el usuario esten bien escritos.',
                    icon: "error",
                    buttons: "Aceptar!",
                });
            }
        </script>

    </head>
    <body>

        <!-- Condicional mensaje de login -->

        @if(session()->has('status'))
        <input type="hidden" id="validation_message" value="{{ session()->get('status') }}">
        <?php
        echo "<script>";
        echo "message();";
        echo "</script>";
        ?>
        @endif

        <!-- fin condicional -->
        
        <!-- Estructura de login -->

        <div class="page">
            <div class="container">
                <div class="left">
                <div class="login">Login</div>
                <div class="eula">By logging in you agree to the ridiculously long terms that you didn't bother to read</div>
                </div>
                <div class="right">

                    <!-- Animacion de movimiento -->

                    <svg viewBox="0 0 320 300">
                        <defs>
                        <linearGradient
                                        inkscape:collect="always"
                                        id="linearGradient"
                                        x1="13"
                                        y1="193.49992"
                                        x2="307"
                                        y2="193.49992"
                                        gradientUnits="userSpaceOnUse">
                            <stop
                                style="stop-color:#ff00ff;"
                                offset="0"
                                id="stop876" />
                            <stop
                                style="stop-color:#ff0000;"
                                offset="1"
                                id="stop878" />
                        </linearGradient>
                        </defs>
                        <path d="m 40,120.00016 239.99984,-3.2e-4 c 0,0 24.99263,0.79932 25.00016,35.00016 0.008,34.20084 -25.00016,35 -25.00016,35 h -239.99984 c 0,-0.0205 -25,4.01348 -25,38.5 0,34.48652 25,38.5 25,38.5 h 215 c 0,0 20,-0.99604 20,-25 0,-24.00396 -20,-25 -20,-25 h -190 c 0,0 -20,1.71033 -20,25 0,24.00396 20,25 20,25 h 168.57143" />
                    </svg>

                    <!-- fin animacion -->

                    <!-- Inicio formulario de logueo -->

                    <div class="form">
                        <form action="{{ url('login') }}" method="post">
                        @csrf
                            <label for="email">Usuario</label>
                            <input type="text" id="email" name="usuario" required="required" autocomplete="off">
                            <label for="password">Contraseña</label>
                            <input type="password" id="password" name="contraseña" required="required">
                            <input type="submit" id="submit" value="Ingresar">
                        </form>
                    </div>

                    <!-- fin formulario -->

                </div>
            </div>
        </div>

        <!-- fin estructura -->

    </body>
</html>
