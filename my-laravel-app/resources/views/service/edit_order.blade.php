<x-layout>
    <x-slot name="title">Редактирование заказ наряда</x-slot>

    <div id="editOrder">
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

            <p>Общая сумма: {{ $order->total_amount }}</p>


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
