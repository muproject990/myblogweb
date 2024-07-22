<!doctype html>
<html lang="en">
<meta name="csrf-token" content="{{ csrf_token() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Blogs-|Website</title>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    @vite('resources/css/app.css')
</head>

<body class="bg-slate-100 dark:bg-slate-800">
    <x-navbar></x-navbar>
    <div class="max-w-6xl mx-auto">
        {{ $slot }}

    </div>

</body>

</html>
