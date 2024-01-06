<x-layout>
    <x-slot name="title">Просмотр заказа</x-slot>

    <div id="order" class="container mt-4">

        @if($order)
            <div class="mb-3">
                <div class="row">

                    <div class="col-md-4">
                        <p><strong>Заказ наряд номер: </strong> {{ $order->id }}</p>
                    </div>

                    <div class="col-md-4">
                        <p><strong>Специализация:   </strong> {{ $order->specialization->specializationName }}</p>
                    </div>

                    <div class="col-md-4">
                        <p><strong>Клиент:    </strong> {{ $order->client->name }}</p>
                    </div>

                </div>
            </div>

            <div class="mb-3 text-center">
                <h5>Выполненные услуги</h5>
            </div>

            <div class="card mb-3">
                <ul class="list-group list-group-flush">
                    @foreach($order->services as $service)
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-md-10">{{ $service->service }}</div>
                                <div class="col-md-2">{{ $service->price }}</div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="mb-3">

                <div class="row">
                    <div class="col-md-9"></div>
                </div>
                <div class="col-md-10 text-md-end">
                    <p><strong>Общая сумма: {{ $order->total_amount }}</strong></p>
                </div>

                <div class="mb-3">
                    <p><strong>Материалы: </strong>
                        <input type="text" value="
                            @if($order->materials)
                                {{ $order->materials }}
                                @else нет материалов
                            @endif"
                            class="form-control" readonly>
                    </p>
                </div>

                <div class="mb-3">
                    <p><strong>Коментарии: </strong>
                        <input type="text" value="
                           @if( ! $order->comments) нет коментариев
                           @endif
                           {{ $order->comments }}"
                           class="form-control" readonly>
                    </p>
                </div>
                <p><strong>Коментарии: </strong>
                    @if( ! $order->comments ) нет коментариев
                   @endif{{ $order->comments }}</p>
            </div>

            <div class="row">
                <div class="col-md-10">
                    <a href="/edit_order/ {{ $order->id }}" class="btn btn-primary bi-pencil"> Редактировать</a>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger bi-trash" onclick="openConfirmDeleteModal()"> Удалить</button>
                </div>
            </div>

        @else
            <p>нет заказ нарядов</p>
        @endif


            <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Подтверждение удаления</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="deleteOrder({{ $order->id }})">Удалить</button>
                        </div>
                    </div>
                </div>
            </div>

    </div>


    <script src="{{ asset('script.js') }}"></script>
</x-layout>
