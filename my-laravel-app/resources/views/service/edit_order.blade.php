<x-layout>
    <x-slot name="title">Редактирование заказ наряда</x-slot>

    <div id="editOldOrder" class="container">

        <h3>Редактирование заказ-наряда: {{ $order->id }} </h3>
        <div id="orderId">{{ $order->id }}</div>

        <div class="row">
            <div class="col-md-7">
                <div class="form-group">
                    <select class="form-control" name="clients" id="clients">
                        @foreach($clients as $client)
                            <option value="{{ $client->id }}">{{ $client->name }} - {{ $client->phone }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-5">
                <div class="form-group">
                    <span id="specializationSpan" data-specialization-id="{{ $order->specialization->id }}"> специализация: {{$order->specialization->specializationName}}  </span>
                </div>
            </div>

            <div class="col-md-6 text-center">
                <div class="form-group">
                    <label for="category">Категории:</label>
                    <select class="form-control" name="category" id="category">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

        </div>

        @if($order)

{{--                <span id="specializationSpan" data-specialization-id="{{ $order->specialization->id }}"> специализация: {{$order->specialization->specializationName}} | </span>--}}


{{--            <lable for="clients">Клиент</lable>--}}
{{--            <select name="clients" id="clients">--}}
{{--                @foreach($clients as $client)--}}
{{--                    <option value="{{ $client->id }}" {{ $order->client_id === $client->id ? 'selected' : '' }}>--}}
{{--                        {{ $client->name }} - {{ $client->phone }}--}}
{{--                    </option>--}}
{{--                @endforeach--}}
{{--            </select>--}}
            <br>
{{--            <lable for="category">категория</lable>--}}
{{--            <select name="category" id="category">--}}
{{--                @foreach($categories as $category)--}}
{{--                    <option value="{{ $category->id }}">{{ $category->category_name }}</option>--}}
{{--                @endforeach--}}
{{--            </select>--}}
            <h3>Выберите вид работ: </h3>

            <div id="services">
            </div>

            <br>
            <button id="addToServiceList" data-id="addToServiceList" class="btn btn-primary">добавить в заказ наряд</button>

            <br>
            <br>
            <h3>Заказ наряд: </h3>

            <div class="oldOrder">
            </div>

            <br>

            <script>
                let services = {!! json_encode($order->services) !!};
            </script>


            <div id="displayOldSelectedWorks"></div>
            <br>

            <h4>Выполненные услуги</h4>

            <div id="serviceDoneDiv" class="card mb-3">
                @if(count($order->services) > 0)
                    <ul>
                        @foreach($order->services as $service)
                            <div class="serviceItem" data-service-id="{{ $service->id }}">
                                <div class="row">
                                    <div class="col-md-9">{{ $service->service }}</div>
                                    <div class="col-md-2">{{ $service->price }}</div>
                                    <div class="col-md-1">
                                        <button class="removeServiceButton btn bi-trash primary"></button>
                                    </div>

{{--                                    {{ $service->service }} - {{ $service->price }}--}}
{{--                                    <button class="removeServiceButton btn bi-trash primary "></button>--}}
                                </div>
                            </div>
                        @endforeach
                    </ul>
                @else
                    <p>нет выполненных услуг</p>
                @endif
            </div>

{{--            <div class="card mb-3">--}}
{{--                <ul class="list-group list-group-flush">--}}
{{--                    @foreach($order->services as $service)--}}
{{--                        <li class="list-group-item">--}}
{{--                            <div class="row">--}}
{{--                                <div class="col-md-9">{{ $service->service }}</div>--}}
{{--                                <div class="col-md-2">{{ $service->price }}</div>--}}
{{--                                <div class="col-md-1">--}}
{{--                                    <button class="removeServiceButton btn bi-trash primary"></button>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </li>--}}
{{--                    @endforeach--}}
{{--                </ul>--}}
{{--            </div>--}}

            <br>
            <div id="totalDiv">
                <span id="totalText">Общая сумма: </span> <span id="totalAmount"> {{ $order->total_amount }} </span>
            </div>

            <p>Материалы:
                @if($order->materials) {{ $order->materials }}
                @else нет материалов
                @endif
            </p>
            <p>Коментарии:
                @if( ! $order->comments ) нет коментариев
                @endif{{ $order->comments }}</p>

        @else
            <p>нет заказ нарядов</p>
        @endif

    </div>

    <button id="saveOrderButton">Сохранить</button>

    <script src="{{ asset('script.js') }}"></script>
</x-layout>
