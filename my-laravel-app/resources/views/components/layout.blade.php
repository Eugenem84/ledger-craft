<!DOCTYPE html>

<html>
    <head>
{{--        <link href="{{ asset('css/styles.css') }}" rel="stylesheet">--}}
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
        <title>{{$title}}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>
    <body>
        <header>
            <div class="container-sm sticky-top">
                <div class="row">
                    <div class="col-12 text-center">
                        <h1 class="text-black"> L  E  D  G  E  R   -   C  R  A  F  T </h1>
                    </div>
                </div>

                <div class="row justify-content-center sticky-top">
                    <div class="col-12">
                        <a href="/service/show" class="btn btn-itd btn-lg text-uppercase">заказ-наряд</a>
                        <a href="/service/edit" class="btn btn-itd btn-lg text-uppercase">редактор каталога</a>
                        <a href="/service/history" class="btn btn-itd btn-lg text-uppercase">история заказов</a>
                        <a href="/service/statistic" class="btn btn-itd btn-lg text-uppercase">статистика</a>
                    </div>
                </div>

            </div>
        </header>
        {{$slot}}

        <div id="successMessage" class="alert alert-success mt-3" style="display: none">
            Сохранено
        </div>

        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

    </body>
</html>
