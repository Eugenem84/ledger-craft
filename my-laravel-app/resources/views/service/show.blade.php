<x-layout>
    <x-slot name="title">Заказ наряд</x-slot>
    <h1>Выберите вид работ: </h1>
    <div id="services">
        @foreach($services as $service)
            <div class="service" data-id="{{ $service->id }}">{{$service->service}} - {{$service->price}}</div>
        @endforeach
    </div>

    <script>
        const services = {!! json_encode($services) !!}; // Преобразование данных в JavaScript объект
    </script>

    <button id="editService">редактировать работу</button>
    <button id="deleteFromServiceList">удалить из каталога</button>
    <button id="addNewService">добавить новую работу</button>
    <br>
    <br>
    <button id="addToServiceList" data-id="addToServiceList">добавить в заказ наряд</button>
    <h3>Заказ наряд:</h3>
    <br>
    <div class="order">

    </div>

    <div id="displaySelectedWorks"></div>
    <br>
    <p>Общая сумма: </p>
    <div id="totalDiv"></div>
    <button id="saveOrderButton">Сохранить заказ наряд</button>
    <script src="{{ asset('script.js') }}"></script>
</x-layout>


