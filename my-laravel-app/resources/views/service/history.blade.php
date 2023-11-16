<x-layout>
    <x-slot name="title">История Заказов</x-slot>
    <h3>список заказ-нарядов</h3>

    @if(count($orders) > 0)
        <div class="order-list">
            @foreach($orders as $order)
                <div class="order-item">
                    <p>заказ : {{ $order->client_id}} - {{ $order->total_amount }}</p>
                </div>
            @endforeach
        </div>
    @else
        <p>нет заказов</p>
    @endif



</x-layout>
