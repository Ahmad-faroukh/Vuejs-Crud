<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta name="csrf-token" content="{{csrf_token()}}">
        <script>window.Laravel={csrfToken:'{{csrf_token()}}'}</script>

        <title>Vuejs Example</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.1/css/bulma.min.css">
    </head>
    <body>
    <section class="section">
        <div id="app">
            <navbar></navbar>
            <div class="container">
                <users></users>
            </div>
        </div>
    </section>

    <script src="{{asset('js/app.js')}}"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
    </body>
</html>
