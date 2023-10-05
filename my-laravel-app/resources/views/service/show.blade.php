<x-layout>
    <x-slot name="title">Services</x-slot>
    <label for="service">Выберите сервис: </label>
    <select name="service" id="service">
        @foreach($services as $service)
            <option value="{{ $service->id }}">{{$service->service}} - {{$service->price}}</option>
        @endforeach
    </select>
    <button id="addToServiceList" data-id="addToServiceList">добавить</button>
    <button id="deleteFromServiceList"> удалить </button>
    <button id="editService"> редактировать</button>
    <button id="saveOrder">сохранить</button>
    <h3>Заказ наряд:</h3>
    <br>
    <div class="order">

    </div>
    <script src="{{ asset('script.js') }}"></script>
</x-layout>


