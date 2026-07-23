<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root{
            --card-bg: rgba(255, 255, 255, 0.18);
            --card-border: rgba(255, 255, 255, 0.35);
            --text-dark: #1f2937;
            --input-bg: rgba(255, 255, 255, 0.92);
            --input-border: rgba(0,0,0,0.08);
            --primary: #dc2626;
            --primary-hover: #b91c1c;
        }

        * { box-sizing: border-box; }

        body{
            margin: 0;
            min-height: 100vh;
            font-family: 'Figtree', sans-serif;
            color: var(--text-dark);

            /* URL dari CSS variable inline di body (lihat tag <body>) */
            background-image: var(--login-bg);
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            position: relative;
        }

        body::before{
            content: "";
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.18);
            z-index: 0;
        }

        .auth-wrapper{
            position: relative;
            z-index: 1;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        .auth-card{
            width: 100%;
            max-width: 440px;
            padding: 28px 24px;
            border-radius: 18px;
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            box-shadow: 0 10px 35px rgba(0,0,0,0.22);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
        }

        .auth-title{
            margin: 0 0 6px;
            font-size: 28px;
            font-weight: 700;
            text-align: center;
            color: #ffffff;
        }

        .auth-subtitle{
            margin: 0 0 20px;
            text-align: center;
            color: rgba(255,255,255,0.92);
            font-size: 14px;
        }

        .form-label{
            display: block;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 8px;
            color: #ffffff;
        }

        .form-input{
            width: 100%;
            height: 44px;
            border-radius: 10px;
            border: 1px solid var(--input-border);
            background: var(--input-bg);
            padding: 0 12px;
            font-size: 14px;
            outline: none;
            transition: .2s ease;
        }

        .form-input:focus{
            border-color: #93c5fd;
            box-shadow: 0 0 0 3px rgba(147,197,253,.35);
        }

        .form-group{ margin-bottom: 14px; }

        .row-between{
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-top: 8px;
            margin-bottom: 16px;
        }

        .remember-wrap{
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #fff;
            font-size: 14px;
        }

        .remember-wrap input{ accent-color: var(--primary); }

        .link{
            color: #fff;
            font-size: 13px;
            text-decoration: none;
            opacity: .95;
        }

        .link:hover{ text-decoration: underline; }

        .btn-login{
            width: 100%;
            height: 44px;
            border: 0;
            border-radius: 10px;
            background: var(--primary);
            color: white;
            font-size: 14px;
            font-weight: 700;
            letter-spacing: .5px;
            cursor: pointer;
            transition: .2s ease;
        }

        .btn-login:hover{
            background: var(--primary-hover);
            transform: translateY(-1px);
        }

        .error-text{
            color: #fee2e2;
            font-size: 12px;
            margin-top: 6px;
        }

        @media (max-width: 480px){
            .auth-card{
                padding: 22px 18px;
                border-radius: 14px;
            }
            .auth-title{ font-size: 24px; }
        }
    </style>
</head>
<body style="--login-bg: url('{{ asset('images/banner-web.jpg') }}');">
    <div class="auth-wrapper">
        <div class="auth-card">
            {{ $slot }}
        </div>
    </div>
</body>
</html>