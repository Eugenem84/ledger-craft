<x-layout>
    <x-slot name="title">История Заказов</x-slot>

    <div id="order">
        <h3>Заказ наряд: </h3>

        @if($order)
            <p>ID: {{ $order->id }}</p>
            <p>специализация: {{ $order->specialization->name }}</p>
            <p>Клмент: {{ $order->client->name }}</p>
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
        @else
            <p>нет заказ нарядов</p>
        @endif

    </div>


    <script src="{{ asset('script.js') }}"></script>
</x-layout>
