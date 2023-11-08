<x-layout>
    <x-slot name="title">Заказ наряд</x-slot>
    <lable for="category">Выберите категорию</lable>
    <br>
    <h2>Выберите специализацию:</h2>
    <select name="specialization" id="specialization">
        @foreach($specializations as $specialization)
            <option value="{{ $specialization->id }}">{{ $specialization->specializationName  }}</option>
        @endforeach
    </select>

    <br><br>

    <select name="category" id="category">
        @foreach($categories as $category)
            <option value="{{ $category->id }}">{{ $category->category_name }}</option>
        @endforeach
    </select>
    <h2>Выберите вид работ: </h2>
    <div id="services">
        @foreach($services as $service)
            <div class="service" data-id="{{ $service->id }}">{{$service->service}} - {{$service->price}}</div>
        @endforeach
    </div>

    <script>
        const services = {!! json_encode($services) !!}; // Преобразование данных в JavaScript объект
    </script>

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


