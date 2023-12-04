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

        <br>
        <button type="button" class="btn btn-primary" id="openEditServiceModalButton">Изменить</button>
        <button type="button" class="btn btn-primary" id="showAddNewServiceModalButton">Добавить</button>
        <button type="button" class="btn btn-primary" id="deleteServiceButton">Удалить</button>
        <br>

    </div>

    <br><br>

    <div id="addSpecializationDiv" style="display: none">
        <form id="addSpecializationForm">
            <br>
            <input type="text" name="specializationName" placeholder="название специализации">
            <button type="submit" name="saveSpecializationButton">сохранить</button>
        </form>
    </div>

    <div class="modal fade" id="addSpecializationModal" tabindex="-1" aria-labelledby="addSpecializationModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addSpecializationModalLabel">Добавление специализации</h5>
                    <button class="btn-close" data-bs-dismiss="modal" aria-label="close"></button>
                </div>
                <div class="modal-body">
                    <form id="addSpecializationModalForm">
                        <div class="mb-3">
                            <input type="text" class="form-control" id="addSpecializationInput">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">закрыть</button>
                    <button class="btn btn-primary" type="button" data-bs-dismiss="modal">сохранить</button>
                </div>
            </div>
        </div>
    </div>

    <div id="editSpecializationDiv" style="display: none">
        <form id="editSpecializationForm">
            <br>
            <input type="text" id="editSpecializationNameInput" name="name">
            <button type="submit" name="saveNewNameCategoryButton">Сохранить</button>
        </form>
    </div>

    <div class="model fade" id="editSpecializationModal" tabindex="-1" aria-labelledby="addSpecializationModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editSpecializationModalLabel">Изменить специализацию</h5>
                    <button class="btn-close" data-bs-dismiss="modal" aria-label="close"></button>
                </div>
                <div class="modal-body">
                    <form id="editSpecializationModalForm">
                        <div class="mb-3">
                            <input type="text" class="form-control" id="editSpecializationInput">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">закрыть</button>
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal" id="saveNewNameSpecializationButton">сохранить</button>
                </div>
            </div>
        </div>
    </div>

    <div id="addClientDiv" style="display: none">
        <form id="addClientForm">
            <br>
            <input type="text" name="clientName" placeholder="Имя клиента">
            <input type="text" name="clientPhone" placeholder="Телефон">
            <button type="submit" name="saveClient">Сохранить</button>
        </form>
    </div>

    <div class="modal fade" id="addClientModal" tabindex="-1" aria-labelledby="addClientModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addClientModalLabel"> Добавить нового клиента </h5>
                    <button class="btn-close" data-bs-dismiss="modal" aria-label="close"></button>
                </div>
                <div class="modal-body">
                    <form id="addCategoryModalForm">
                        <div class="mb-3">
                            <input type="text" class="form-control" id="nameClientInput">
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control" id="phoneClientInput">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">закрыть</button>
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal" id="saveNewClientButton">сохранить</button>
                </div>
            </div>
        </div>
    </div>

    <div id="editClientDiv" style="display: none">
        <form id="editClientForm">
            <br>
            <input type="text" id="editClientNameInput" name="name">
            <input type="text" id="editClientPhoneInput" name="phone">
            <button type="submit" name="saveNewClientButton">Сохранить</button>
        </form>
    </div>

    <div class="modal fade" id="editClientModal" tabindex="-1" aria-labelledby="editClientModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editClientModalLabel">Редактировать клиента</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="close"></button>
                </div>
                <div class="modal-body">
                    <form id="editCategoryModalForm">
                        <div class="mb-3">
                            <input type="text" class="form-control" id="newNameClientInput">
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control" id="newPhoneClientInput">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">закрыть</button>
                    <button type="button" class="btn ntb-primary" data-bs-dismiss="modal" id="saveNewNameSpecializationButton">сохранить</button>
                </div>
            </div>
        </div>
    </div>

{{--    <div id="addCategoryDiv" style="display: none">--}}
{{--        <form id="addCategoryForm>">--}}
{{--            <br>--}}
{{--            <input type="text" name="categoryName" placeholder="название категории">--}}
{{--            <button type="submit" name="saveCategoryButton">Сохранить</button>--}}
{{--        </form>--}}
{{--        <br>--}}
{{--    </div>--}}

    <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCategoryModalLabel">Добавить новую категорию</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="close"></button>
                </div>
                <div class="modal-body">
                    <form id="addCategoryModalForm">
                        <div class="mb-3">
                            <input type="text" class="form-control" id="addCategoryNameInput" placeholder="введите название категории">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">закрыть</button>
                    <button type="button" class="btn btn-primary" id="saveNewCategoryButton" data-bs-dismiss="modal">Сохранить</button>
                </div>
            </div>
        </div>
    </div>

{{--    <div id="editCategoryDiv" style="display: none">--}}
{{--        <form id="editCategoryForm" style="display: block">--}}
{{--            <br>--}}
{{--            <input type="text" id="editCategoryNameInput" name="name">--}}
{{--            <button type="submit" name="saveNewNameCategoryButton">Сохранить</button>--}}
{{--        </form>--}}
{{--    </div>--}}

    <div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCategoryModalLabel">Изменить категорию</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="close"></button>
                </div>
                <div class="modal-body">
                    <form id="editCategoryModalForm">
                        <div class="mb-3">
                            <input type="text" class="form-control" id="editCategoryNameInput">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">закрыть</button>
                    <button type="button" class="btn btn-primary" id="saveNewNameCategoryButton" data-bs-dismiss="modal">Сохранить</button>
                </div>
            </div>
        </div>
    </div>

    <div id="serviceForm" style="display: none">
        <form id="addServiceForm">
            <input type="text" name="name" placeholder="Название услуги">
            <input type="text" name="price" placeholder="цена">
            <button type="submit" name="addButton">Добавить</button>
        </form>
    </div>

    <div class="modal fade" id="newServiceModal" tabindex="-1" aria-labelledby="newServiceModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="newServiceModalLabel">Добавить новую услугу</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="close"></button>
                </div>
                <div class="modal-body">
                    <form id="newServiceModalForm">
                        <div class="mb-3">
                            <input type="text" class="form-control" id="serviceNameInput" name="name" placeholder="введите название услуги">
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control" id="servicePriceInput" name="price" placeholder="введите цену">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">закрыть</button>
                    <button type="button" class="btn btn-primary" id="saveNewServiceButton" data-bs-dismiss="modal">Сохранить</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editServiceModal" tabindex="-1" aria-labelledby="editServiceModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editServiceModalLabel">Редактировать услугу</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editServiceModalForm">
                        <div class="mb-3">
                            <input type="text" class="form-control" id="editServiceName" name="name" placeholder="название услуги">
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control" id="editServicePrice" name="price" placeholder="цена">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                    <button type="button" class="btn btn-primary" id="saveEditServiceButton" data-bs-dismiss="modal" >Сохранить</button>
                </div>
            </div>
        </div>
    </div>

{{--    <div id="editServiceDiv" style="display: none">--}}
{{--        <form id="editServiceForm" style="display: block">--}}
{{--            <input type="text" id="editServiceName" name="name">--}}
{{--            <input type="text" id="editServicePrice" name="price">--}}
{{--            <button type="submit" name="saveButton">Сохранить</button>--}}
{{--        </form>--}}
{{--    </div>--}}

    <script src="{{ asset('script.js') }}"></script>
</x-layout>
