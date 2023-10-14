<x-layout>
    <x-slot name="title">Редактор Каталога</x-slot>
    <button id="editService">Изменить</button>
    <button id="addNewService">Добавить</button>
    <button id="deleteService">Удалить</button>
    <br>
    <div id="servicesDiv">
        @foreach($services as $service)
            <div class="serviceForEdit" data-id="{{$service->id}}">{{$service->service}} - {{$service->price}}</div>
        @endforeach
    </div>
    <script src="{{ asset('script.js') }}"></script>
</x-layout>
