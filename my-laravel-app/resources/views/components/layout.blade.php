<!DOCTYPE html>

<html>
    <head>
        <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
        <title>{{$title}}</title>
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
