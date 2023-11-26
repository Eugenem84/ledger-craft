<!DOCTYPE html>

<html>
    <head>
        <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <title>{{$title}}</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    </head>
    <body>
        <header>
            <div class="header">
                РЕМОНТ
            </div>
        </header>
        <nav>
            <ul>
                <li><a href="/service/show">заказ наряд</a> </li>
                <li><a href="/service/edit">редактор каталога</a> </li>
                <li><a href="/service/history">история заказов</a> </li>
                <li><a href="/service/statistic">статистика</a> </li>
            </ul>
        </nav>
        {{$slot}}

    </body>
</html>
