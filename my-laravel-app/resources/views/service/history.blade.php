<x-layout>
    <x-slot name="title">История Заказов</x-slot>

    <div id="orders" class="text-center">
        <h3>Список заказ-нарядов</h3>
        @if(count($orders) > 0)
            <div id="order-list">
                @foreach($orders as $order)
                    <a href="/order/{{ $order->id }}" class="card mb-3 order-item" data-order-id="{{ $order->id }}">
                        <div class="card mb-3 order-item" data-order-id="{{ $order->id }}">
                            <div class="card-body bg-light">
                                <div class="order-detail">
                                    <div class="row">
                                        <div class="col-md-1">
                                            {{ $order->id }}
                                        </div>

                                        <div class="col-md-3">
                                            {{ $order->created_at }}
                                        </div>
                                        <div class="col-md-3">
                                            {{ $order->specialization->specializationName }}
                                        </div>
                                        <div class="col-md-4">
                                            {{ $order->client->name }}
                                        </div>
                                        <div class="col-md-1">
                                            {{ $order->total_amount }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <a/>
                @endforeach
            </div>
        @else
            <p> нет заказов </p>
        @endif
    </div>


    <script src="{{ asset('script.js') }}"></script>

</x-layout>
