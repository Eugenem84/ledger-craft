<x-layout>
    <x-slot name="title">Редактор Каталога</x-slot>
    <button id="editService">Изменить</button>
    <button id="showAddForm">Добавить новую услугу</button>
    <button id="deleteService">Удалить</button>
    <div id="serviceForm" style="display: none">
        <form id="addServiceForm">
            <input type="text" name="name" placeholder="Название услуги">
            <input type="text" name="price" placeholder="цена">
            <button type="submit">Добавить</button>
        </form>
    </div>
    <br>
    <div id="servicesDiv">
        @foreach($services as $service)
            <div class="serviceForEdit" data-id="{{$service->id}}">{{$service->service}} - {{$service->price}}</div>
        @endforeach
    </div>
    <script src="{{ asset('script.js') }}"></script>
</x-layout>
