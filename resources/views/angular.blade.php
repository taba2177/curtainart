<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Angular on Laravel</title>

    <!-- Laravel Vite integration -->
    @vite(['resources/angular/main.ts'])

</head>
<body>
    <app-root></app-root>
</body>
</html>
