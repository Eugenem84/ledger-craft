<x-layout>
    <x-slot name="title">Редактор Каталога</x-slot>

    <div class="container">
        <div class="row">

            <div class="col-md-6">
                <select class="form-control" name="specialization" id="specialization">
                    @foreach($specializations as $specialization)
                        <option value="{{ $specialization->id }}">{{ $specialization->specializationName }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2">
                <button class="btn btn-primary" id="editSpecializationButton">Изменить</button>
            </div>

            <div class="col-md-2">
                <button class="btn btn-primary" id="addNewSpecializationButton">Добавить</button>
            </div>

            <div class="col-md-2">
                <button class="btn btn-primary" id="deleteSpecializationButton">Удалить</button>
            </div>

        </div>
        <br>
        <div class="row">

            <div class="col-md-6">
                <select class="form-control" name="client" id="client">
                    @foreach($clients as $client)
                        <option value="{{ $client->id }}">{{ $client->name }} - {{ $client->phone }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2">
                <button class="btn btn-primary" id="editClientButton">Изменить</button>
            </div>

            <div class="col-md-2">
                <button class="btn btn-primary" id="showAddClientForm">Добавить</button>
            </div>

            <div class="col-md-2">
                <button class="btn btn-primary" id="deleteClientButton">Удалить</button>
            </div>

        </div>
        <br>
        <div class="row">
            <div class="col-md-6">
                <select class="form-control" name="category" id="category">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2">
                <button class="btn btn-primary" id="editCategoryButton">Изменить</button>
            </div>

            <div class="col-md-2">
                <button class="btn btn-primary" id="showAddCategoryForm">Добавить</button>
            </div>

            <div class="col-md-2">
                <button class="btn btn-primary" id="deleteCategory">Удалить</button>
            </div>


        </div>

        <br>
        <div id="servicesDiv" class="card-deck">

        </div>
    </div>

    <br><br>



    <div id="addSpecializationDiv" style="display: none">
        <form id="addSpecializationForm">
            <br>
            <input type="text" name="specializationName" placeholder="название специализации">
            <button type="submit" name="saveSpecializationButton">сохранить</button>
        </form>
    </div>

    <div id="editSpecializationDiv" style="display: none">
        <form id="editSpecializationForm">
            <br>
            <input type="text" id="editSpecializationNameInput" name="name">
            <button type="submit" name="saveNewNameCategoryButton">Сохранить</button>
        </form>
    </div>

    <div id="addClientDiv" style="display: none">
        <form id="addClientForm">
            <br>
            <input type="text" name="clientName" placeholder="Имя клиента">
            <input type="text" name="clientPhone" placeholder="Телефон">
            <button type="submit" name="saveClient">Сохранить</button>
        </form>
    </div>

    <div id="editClientDiv" style="display: none">
        <form id="editClientForm">
            <br>
            <input type="text" id="editClientNameInput" name="name">
            <input type="text" id="editClientPhoneInput" name="phone">
            <button type="submit" name="saveNewClientButton">Сохранить</button>
        </form>
    </div>

    <br><br>

    <div id="addCategoryDiv" style="display: none">
        <form id="addCategoryForm>">
            <br>
            <input type="text" name="categoryName" placeholder="название категории">
            <button type="submit" name="saveCategoryButton">Сохранить</button>
        </form>
        <br>
    </div>

    <div id="editCategoryDiv" style="display: none">
        <form id="editCategoryForm" style="display: block">
            <br>
            <input type="text" id="editCategoryNameInput" name="name">
            <button type="submit" name="saveNewNameCategoryButton">Сохранить</button>
        </form>
    </div>

    <br>
{{--    <div id="servicesDiv">--}}
{{--        @foreach($services as $service)--}}
{{--            <div class="serviceForEdit" data-id="{{$service->id}}">{{$service->service}} - {{$service->price}}</div>--}}
{{--        @endforeach--}}
{{--    </div>--}}

    <br>
    <button id="editService">Изменить услугу</button>
    <button id="showAddForm">Добавить новую услугу</button>
    <button id="deleteService">Удалить услугу</button>
    <br>

    <div id="serviceForm" style="display: none">
        <form id="addServiceForm">
            <input type="text" name="name" placeholder="Название услуги">
            <input type="text" name="price" placeholder="цена">
            <button type="submit" name="addButton">Добавить</button>
        </form>
    </div>

    <div id="editServiceDiv" style="display: none">
        <form id="editServiceForm" style="display: block">
            <input type="text" id="editServiceName" name="name">
            <input type="text" id="editServicePrice" name="price">
            <button type="submit" name="saveButton">Сохранить</button>
        </form>
    </div>

    <script src="{{ asset('script.js') }}"></script>
</x-layout>
