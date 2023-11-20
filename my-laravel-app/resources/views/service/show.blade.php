<x-layout>
    <x-slot name="title">Заказ наряд</x-slot>
    <lable for="specialization">специализация</lable>
    <select name="specialization" id="specialization">
        @foreach($specializations as $specialization)
            <option value="{{ $specialization->id }}">{{ $specialization->specializationName  }}</option>
        @endforeach
    </select>

    <lable for="clients">Клиент</lable>
    <select name="clients" id="clients">
        @foreach($clients as $client)
            <option value="{{ $client->id }}">{{ $client->name }} - {{ $client->phone }}</option>
        @endforeach
    </select>

    <lable for="category">категория</lable>
    <select name="category" id="category">
        @foreach($categories as $category)
            <option value="{{ $category->id }}">{{ $category->category_name }}</option>
        @endforeach
    </select>
    <h3>Выберите вид работ: </h3>
    <div id="services">
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
        <span id="totalText">Общая сумма: </span> <span id="totalAmount"></span>
    </div>
    <br>
    <h3>Материалы:</h3>
    <textarea id="materials" rows="1" cols="30"> </textarea>
    <br>
    <h3>Коментарии:</h3>
    <textarea id="comments" rows="1" cols="30"></textarea>
    <br><br>

    <button id="saveOrderButton">Сохранить заказ наряд</button>
    <script src="{{ asset('script.js') }}"></script>
</x-layout>


