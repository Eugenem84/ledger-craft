<x-layout>
    <x-slot name="title">Редактор Каталога</x-slot>

    <button id="editService">Изменить</button>
    <button id="showAddForm">Добавить новую услугу</button>
    <button id="deleteService">Удалить</button>
    <button id="showAddCategoryForm">Добавить новую категорию</button>
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

    <div id="addCategoryDiv" style="display: none">
        <form id="addCategoryForm>">
            <br>
            <input type="text" name="categoryName" placeholder="название категории">
            <button type="submit" name="saveCategoryButton">Сохранить</button>
        </form>
    </div>

    <br>

    <select name="category" id="category">
        @foreach($categories as $category)
            <option value="{{ $category->id }}">{{ $category->category_name }}</option>
        @endforeach
    </select>
    <lable for="category">выберите категорию</lable>
    <br>
    <br>
    <div id="servicesDiv">
        @foreach($services as $service)
            <div class="serviceForEdit" data-id="{{$service->id}}">{{$service->service}} - {{$service->price}}</div>
        @endforeach
    </div>
    <script src="{{ asset('script.js') }}"></script>
</x-layout>
