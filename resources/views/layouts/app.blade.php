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
    <link rel='stylesheet prefetch'
          href='https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.1.8/components/icon.min.css'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noty/3.1.4/noty.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
    <style>
        [v-cloak] {
            display: none !important;
        }
    </style>
</head>
<body>
<div id="app_front"
     data-user="{{json_encode(\Auth::user())}}"
     data-lang="{{json_encode(\Lang::get('main.main'))}}"
     data-settings="{{json_encode($settings)}}"
     v-cloak>
    @yield('content')
</div>

<!-- Scripts -->
<script src="{{ mix('js/app_front.js') }}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/noty/3.1.4/noty.js"></script>

</body>
</html>
