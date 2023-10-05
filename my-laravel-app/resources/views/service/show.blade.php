<x-layout>
    <x-slot name="title">Services</x-slot>
    <h1>Выберите вид работ: </h1>
    <div id="services">
        @foreach($services as $service)
            <div class="service" data-id="{{ $service->id }}">{{$service->service}} - {{$service->price}}</div>
        @endforeach
    </div>

    <script>
        const services = {!! json_encode($services) !!}; // Преобразование данных в JavaScript объект
    </script>


    <button id="addToServiceList" data-id="addToServiceList">добавить</button>
    <button id="deleteFromServiceList"> удалить </button>
    <button id="editService"> редактировать</button>
    <button id="saveOrder">сохранить</button>
    <h3>Заказ наряд:</h3>
    <br>
    <div class="order">

    </div>

    <div id="displaySelectedWorks"></div>
    <br>
    <p>Общая сумма: </p>
    <div id="totalDiv"></div>
    <script src="{{ asset('script.js') }}"></script>
</x-layout>


