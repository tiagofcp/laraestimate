<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Plataforma de orçamentos</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 1.4rem;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
                font-size: 1.4rem;
            }

            .footer {
                display: block;
                width: 100%;
                position: fixed;
                bottom: 0;
                left: 0;
                font-size: 1.4rem;
                text-align: center;
            }

            .heart {
                fill: #e74c3c;
                position: relative;
                top: 5px;
                width: 15px;
                animation: pulse 1s ease infinite;
            }

            @keyframes  pulse {
                0% { transform: scale(1); }
                50% { transform: scale(1.3); }
                100% { transform: scale(1); }
            }
        </style>
    </head>
    <body>
        <a href="https://setup.technology/contactos-setup-tech" style="position: fixed;z-index: 9999;"><img width="500" height="500" src="/images/bannerHome.png" class="attachment-full size-full" alt="Precisas de ajuda?" data-recalc-dims="1"></a>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ route('estimates.index') }}">@lang('app.my_estimates')</a>
                    @else
                        <a href="{{ route('login') }}">@lang('app.login')</a>
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="m-b-md">
                    <img src="{{ asset('/images/logo.png') }}" alt="LaraEstimate Logo Image" height="250px">
                </div>

                <div class="m-b-md">
                    Orçamentos para prodtos digitais
                </div>

                <div class="footer">
                    Desenvolvido com
                    <svg class="heart" viewBox="0 0 32 29.6">
                        <path d="M23.6,0c-3.4,0-6.3,2.7-7.6,5.6C14.7,2.7,11.8,0,8.4,0C3.8,0,0,3.8,0,8.4c0,9.4,9.5,11.9,16,21.2
                        c6.1-9.3,16-12.1,16-21.2C32,3.8,28.2,0,23.6,0z"></path>
                    </svg> 
                    pela <a href="www.setup.technology" target="_blank">Setup Tech Development Team</a> <b>*</b> <br><br>
                </div>
            </div>
        </div>
    </body>
</html>
