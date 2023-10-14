<x-layout>
    <x-slot name="title">Редактор Каталога</x-slot>
    <button id="editService">Изменить</button>
    <button id="addNewService">Добавить</button>
    <button id="deleteService">Удалить</button>
    <br>
    @foreach($services as $service)
        <div class="service" data-id="{{$service->id}}">{{$service->service}} - {{$service->price}}</div>
    @endforeach

</x-layout>
