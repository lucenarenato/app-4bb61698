<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" value="{{ csrf_token() }}" />

    <title>Vue JS CRUD - Appmax</title>
    {{-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> --}}
    <link href="{{ mix('css/app.css') }}" type="text/css" rel="stylesheet" />
    
</head>
{{-- bg-dark text-light --}}
<body class="bg-dark text-light">
    <div id="app">
        <a href="#" @click="log($event)">Clique aqui</a>
        <br><hr>
        <footer class=footer>Renato Lucena</footer>
    </div> <!-- THIS TAG HERE -->
    {{-- <script src="https://unpkg.com/vue@2.5.16/dist/vue.js"></script>
    <script src="https://unpkg.com/vue-router@3.0.1/dist/vue-router.js"></script>
    <script src="https://unpkg.com/vue-top-down@0.2.2/dist/vue-top-down.umd.js"></script> --}}
    
    <script src="{{ mix('js/app.js') }}" type="text/javascript"></script>
    <script>console.log('Estou aqui => app blade');</script>
</body>

</html>