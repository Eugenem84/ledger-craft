<x-layout>
    <x-slot name="title">Заказ наряд</x-slot>

    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <div class="form-group">
                    <lable for="clients">Клиент</lable>
                    <select class="form-control" name="clients" id="clients">
                        @foreach($clients as $client)
                            <option value="{{ $client->id }}">{{ $client->name }} - {{ $client->phone }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <lable for="specialization">специализация:</lable>
                    <select class="form-control" name="specialization" id="specialization">
                        @foreach($specializations as $specialization)
                            <option value="{{ $specialization->id }}">{{ $specialization->specializationName  }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 text-center">
                <div class="form-group">
                    <label for="category">Категории:</label>
                    <select class="form-control" name="category" id="category">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-2"></div>

            <div class="col-md-4 ml-auto">
                <br>
                <button id="addToServiceList" data-id="addToServiceList" class="btn btn-primary">добавить в заказ наряд</button>
            </div>

        </div>

        <div id="services">
        </div>
        <script>
        const services = {!! json_encode($services) !!}; // Преобразование данных в JavaScript объект
        </script>
        <br>
        <h3>Заказ наряд:</h3>
        <div class="order">
        </div>

        <div id="displaySelectedWorks"></div>
        <br>
        <div id="totalDiv" class="mt-3">
            <div class="row">
                <div class="col-md-7"></div>
                <div class="col-md-5">
                    <span id="totalText" class="mr-2 display-7">Общая сумма: </span>
                    <span id="totalAmount" class="text-primary font-weigh-bold display-6">0</span>
                </div>
            </div>
        </div>
        <br>
        <div class="form-group">
            <label for="materials">материалы: </label>
            <textarea id="materials" class="form-control" rows="3" style="resize: none; overflow-y: hidden "> </textarea>
        </div>
        <br>
        <div class="form-group">
            <label for="comments">комментарии: </label>
            <textarea id="comments" class="form-control" rows="2" style="resize: none; overflow-y: hidden" ></textarea>
        </div>
        <br>
        <div class="row">
            <div class="col-md-8"></div>
            <div class="col-md-4">
                <button id="saveOrderButton" class="btn btn-primary">Сохранить заказ наряд</button>
            </div>
        </div>
    </div>
    <script src="{{ asset('script.js') }}"></script>
</x-layout>


