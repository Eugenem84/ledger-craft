<x-layout>
    <x-slot name="title">Заказ наряд</x-slot>
    <br>
    <lable for="specialization">Выберите специализацию:</lable>
    <select name="specialization" id="specialization">
        @foreach($specializations as $specialization)
            <option value="{{ $specialization->id }}">{{ $specialization->specializationName  }}</option>
        @endforeach
    </select>
<br><br>
    <lable for="clients">Выберите клиента</lable>
    <select name="clients" id="clients">
        @foreach($clients as $client)
            <option value="{{ $client->id }}">{{ $client->name }} - {{ $client->phone }}</option>
        @endforeach
    </select>

    <br><br>

    <lable for="category">Выберите категорию</lable>
    <select name="category" id="category">
        @foreach($categories as $category)
            <option value="{{ $category->id }}">{{ $category->category_name }}</option>
        @endforeach
    </select>
    <h3>Выберите вид работ: </h3>
    <div id="services">
        @foreach($services as $service)
            <div class="service" data-id="{{ $service->id }}">{{$service->service}} - {{$service->price}}</div>
        @endforeach
    </div>

    <script>
        const services = {!! json_encode($services) !!}; // Преобразование данных в JavaScript объект
    </script>

    <br>
    <button id="addToServiceList" data-id="addToServiceList">добавить в заказ наряд</button>
    <h3>Заказ наряд:</h3>
    <div class="order">

    </div>

    <div id="displaySelectedWorks"></div>
    <br>
    <div id="totalDiv">
        <span id="totalText">Общая сумма: </span> <span id="totalAmount">0</span>
    </div>

    <button id="saveOrderButton">Сохранить заказ наряд</button>
    <script src="{{ asset('script.js') }}"></script>
</x-layout>


