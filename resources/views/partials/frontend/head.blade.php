<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f0f0f0;
        }

        .container {
            display: flex;
            justify-content: center;
            padding-left: 0;
            padding-right: 0;
        }


        .clouds {
            position: fixed;
            top: -24px;
            left: 50%;
            transform: translateX(-50%);
        }

        .mobile-screen {
            margin-top: 0;
            background-color: hsl(189.1deg 100% 34.9% / 96%);
            width: 100%;
            /* max-width: 400px; */
            height: 100vh;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, .1);
            font-size: small;
            padding-bottom: 10%;
            overflow-y: auto;
            padding-top: 17px;
            /* text-align: center; */
        }

        .mobile-screen .row {
            margin-right:0;
        }

        .btn {
            background: #5ce1e6 !important;
            border-radius: 21px !important;
            color: white !important;
            height: fit-content;
        }


        @media only screen and (min-width:300px){

        }
    </style>
    @yield('styles')
</head>
