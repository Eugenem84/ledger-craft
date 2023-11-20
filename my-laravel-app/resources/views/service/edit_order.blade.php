<x-layout>
    <x-slot name="title">Редактирование заказ наряда</x-slot>

    <div id="editOrder">
        <h3>Редактирование - Заказ наряда: </h3>

        @if($order)
            <p>ID: <span id="orderId"> {{ $order->id }} </span></p>
            <p>специализация: {{$order->specialization->specializationName}}</p>

{{--            <lable for="specialization">специализация</lable>--}}
{{--            <select name="specialization" id="specialization">--}}
{{--                @foreach($specializations as $specialization)--}}
{{--                    <option value="{{ $specialization->id }}">{{ $specialization->specializationName  }}</option>--}}
{{--                @endforeach--}}
{{--            </select>--}}

            <lable for="clients">Клиент</lable>
            <select name="clients" id="clients">
                @foreach($clients as $client)
                    <option value="{{ $client->id }}" {{ $order->client_id === $client->id ? 'selected' : '' }}>
                        {{ $client->name }} - {{ $client->phone }}
                    </option>
                @endforeach
            </select>

{{--            <lable for="category">категория</lable>--}}
{{--            <select name="category" id="category">--}}
{{--                @foreach($categories as $category)--}}
{{--                    <option value="{{ $category->id }}">{{ $category->category_name }}</option>--}}
{{--                @endforeach--}}
{{--            </select>--}}
{{--            <h3>Выберите вид работ: </h3>--}}
{{--            <div id="services">--}}
{{--            </div>--}}

            <p>Время выполнения: {{ $order->hours }} часов {{ $order->minutes }} минут</p>
            <p>Общая сумма: {{ $order->total_amount }}</p>

            <h4>Выполненные услуги</h4>
            @if(count($order->services) > 0)
                <ul>
                    @foreach($order->services as $service)
                        <li>{{ $service->service }} - {{ $service->price }} </li>
                    @endforeach
                </ul>
            @else
                <p>нет выполненных услуг</p>
            @endif

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
