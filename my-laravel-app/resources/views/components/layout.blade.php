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
        {{$slot}}
        <nav>
            <ul>
                <li><a href="/">главная</a> </li>
                <li><a href="/orders/create">заказ наряд</a> </li>
                <li><a href="/orders/edit">редактор заказов</a> </li>
                <li><a href="/orders/history">история заказов</a> </li>
                <li><a href="/statistics">статистика</a> </li>
            </ul>
        </nav>
    </body>
</html>
