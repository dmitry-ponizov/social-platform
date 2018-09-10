<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" id="_token" content="{{ csrf_token() }}">

    <title>Dobro</title>

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.3.1/semantic.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet" type="text/css">
    <link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.1.8/components/icon.min.css'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noty/3.1.4/noty.css">
    <link href="https://cdn.jsdelivr.net/npm/animate.css@3.5.1" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/0.11.2/trix.css">

    <style>
        [v-cloak] {
            display: none !important;
        }
        body{
            margin: 0px;
            padding: 0px;
            overflow-x: hidden;
            min-width: 320px;
            background: #FFFFFF;
            font-family: 'Lato', 'Helvetica Neue', Arial, Helvetica, sans-serif;
            font-size: 14px;
            line-height: 1.4285em;
            color: rgba(0, 0, 0, 0.87);
        }
        html{
            overflow-x: hidden;
        }
    </style>
</head>
<body>
<div id="app"
     data-user="{{json_encode($user)}}"
     data-lang="{{json_encode($messages)}}"
     data-settings="{{json_encode($settings)}}"
     data-groups="{{json_encode($user_data)}}"
     data-accepted="{{json_encode($accepted_categories)}}"
     data-categories="{{json_encode($categories)}}"
     data-routes="{{json_encode($routes)}}"
     data-locale="{{ json_encode(\App::getLocale()) }}"
     v-cloak
>
    <Vbase :locale="{{ json_encode(\App::getLocale()) }}"
           :userId="{{ auth()->id() }}"
           :unreads="{{auth()->user()->unreadNotifications}}" />
</div>

<!-- Scripts -->
<script src="{{ mix('js/app.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/noty/3.1.4/noty.js"></script>

</body>
</html>
