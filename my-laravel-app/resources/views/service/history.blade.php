<x-layout>
    <x-slot name="title">История Заказов</x-slot>

    <div id="orders">
        <h3>список заказ нарядов</h3>
        @if(count($orders) > 0)
            <div id ="order-list" class="order-list">
                @foreach($orders as $order)
                    <div class="order-item" id="order-item" data-order-id=" {{$order->id}} ">
                        <p>{{$order->created_at}} - {{ $order->specialization->specializationName}} - {{ $order->client->name}} - {{ $order->total_amount }}</p>
                    </div>
                @endforeach
            </div>
        @else
            <p>нет заказов</p>
       @endif
    </div>


    <script src="{{ asset('script.js') }}"></script>

</x-layout>
