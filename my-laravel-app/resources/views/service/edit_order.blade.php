<x-layout>
    <x-slot name="title">Редактирование заказ наряда</x-slot>

    <div id="editOldOrder">
        <h3>Редактирование заказ-наряда: </h3>

        @if($order)

                ID: <span id="orderId"> {{ $order->id }} | </span>
                <span id="specializationSpan"> специализация: {{$order->specialization->specializationName}} | </span>


            <lable for="clients">Клиент</lable>
            <select name="clients" id="clients">
                @foreach($clients as $client)
                    <option value="{{ $client->id }}" {{ $order->client_id === $client->id ? 'selected' : '' }}>
                        {{ $client->name }} - {{ $client->phone }}
                    </option>
                @endforeach
            </select>
            <br>
            <lable for="category">категория</lable>
            <select name="category" id="category">
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                @endforeach
            </select>
            <h3>Выберите вид работ: </h3>

            <div id="services">
            </div>

            <br>
            <h3>Заказ наряд: </h3>
            <div class="oldOrder">
            </div>

            <br>
            <button id="addToServiceList" data-id="addToServiceList">добавить в заказ наряд</button>

            <script>
                const services = {!! json_encode($order->services) !!};
            </script>


            <div id="displayOldSelectedWorks"></div>
            <br>
            <div id="totalDiv">
                <span id="totalText">Общая сумма: </span> <span id="totalAmount"> {{ $order->total_amount }} </span>
            </div>

            <h4>Выполненные услуги</h4>
            <div id="serviceDoneDiv">
                @if(count($order->services) > 0)
                    <ul>
                        @foreach($order->services as $service)
                            <div class="serviceItem" data-service-id="{{ $service->id }}">
                                {{ $service->service }} - {{ $service->price }}
                                <button class="removeServiceButton">Удалить</button>
                            </div>
                        @endforeach
                    </ul>
                @else
                    <p>нет выполненных услуг</p>
               @endif
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


    <script src="{{ asset('script.js') }}"></script>
</x-layout>
