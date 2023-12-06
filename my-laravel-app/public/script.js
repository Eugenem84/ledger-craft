let csrfToken = document.querySelector('meta[name="csrf-token"]').content

let selectedServices = []

//вспомогательная для  editOldOrder
let loadedServices = []


if(document.querySelector('#displaySelectedWorks')){
    console.log('order script')
    order()
}

if (document.getElementById('servicesDiv')){
    console.log('edit script')
    edit()
}

if (document.querySelector('#orders')){
    history()
}

// if (document.querySelector('#order')) {
//     oldOrder()
// }

if (document.querySelector('#editOldOrder')){
    editOldOrder()
}


function loadCategoryBySpecialization(specializationId){
    console.log('Выбрана специализация: ', specializationId)
    let xhr = new XMLHttpRequest()
    xhr.open('GET', `/get_categories/${specializationId}`, true)
    xhr.onload = function (){
        if (xhr.status >= 200 && xhr.status < 400) {
            let categories = JSON.parse(xhr.responseText)
            let categorySelect = document.getElementById('category')
            categorySelect.innerHTML = ''
            console.log('очистка')
            console.log('categories: ',categories)
            categories.forEach(function (category){
                console.log(category)
                let option = document.createElement('option')
                option.value = category.id
                option.textContent = category.category_name
                categorySelect.appendChild(option)
            })

            //обновление услуг при смене специализации
            let selectedServiceId = document.getElementById('category').value
            console.log('выбрана категория: ', selectedServiceId)
            loadServicesByCategory(selectedServiceId)

        } else {
            console.error('Ошибка: ' + xhr.statusText)
        }
    }
    xhr.onerror = function (){
        console.error('Ошибка сети')
    }
    xhr.send()

}

function loadServicesByCategory(categoryId){
    let xhr = new XMLHttpRequest()
    xhr.open('GET', `/get_service/${categoryId}`, true)
    xhr.onload = function (){
        if (xhr.status >= 200 && xhr.status < 400) {
            let services = JSON.parse(xhr.responseText)
            services.forEach(service => {
                if (!loadedServices.includes(service)){
                    loadedServices.push(service)
                }
            })
            loadedServices.push(...services)
            console.log('loadedServices', loadedServices)
            console.log('Категория Id: ', categoryId, ' сервисы: ', services)
            let servicesDiv = document.getElementById('services')
            servicesDiv.innerHTML = ''
            services.forEach(function (service){
                let serviceDiv = document.createElement('div')
                serviceDiv.innerHTML = `
                    <div class="card border-3" style="margin: 10px">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <h5 class="card-title">${service.service}</h5>
                            <p class="card-text ml-auto">${service.price}</p>
                        </div>
                    </div>
                `
                // serviceDiv.textContent = `${service.service} - ${service.price}`
                serviceDiv.classList.add('selectable')
                serviceDiv.dataset.id = service.id
                servicesDiv.appendChild(serviceDiv)
            })
            addClickHandlers()
        } else {
            console.error('Ошибка: ' + xhr.statusText)
        }
    }
    xhr.onerror = function (){
        console.error('Ошибка сети')
    }
    xhr.send()
}

function loadClientsBySpecialization(specializationId){
    console.log('ok')
    let xhr = new XMLHttpRequest()
    xhr.open('GET', `/get_clients/${specializationId}`, true)
    xhr.onload = function (){
        if (xhr.status >= 200 && xhr.status < 400) {
            let clients = JSON.parse(xhr.responseText)
            let clientSelect = document.getElementById('clients')
            clientSelect.innerHTML = ''
            clients.forEach(function (client){
                let option = document.createElement('option')
                option.value = client.id
                option.textContent = client.name + " - " + client.phone
                clientSelect.appendChild(option)
            })
        } else {
            console.log('Ошибка: ' + xhr.statusText)
        }
    }
    xhr.send()
}

function addClickHandlers(){
    const serviceDivs = document.querySelectorAll('.selectable')

    serviceDivs.forEach(function (serviceDiv){
        serviceDiv.addEventListener('click', function (){
            const serviceId = parseInt(this.dataset.id);
            const index = selectedServices.indexOf(serviceId)
            let cardBorder = this.querySelector('.card')
            //let divToStyle = this
            if (!selectedServices.includes(serviceId)){
                selectedServices.push(serviceId)
                cardBorder.classList.add('border-danger')
                //this.style.background = 'red'
            } else {
                selectedServices.splice(selectedServices.indexOf(serviceId), 1)
                cardBorder.classList.remove('border-danger')
                //this.style.background = ''

            }
            console.log('выбран сервис с id:', selectedServices)
        })
    })
}

function removeHighlight() {
    let cardBorderDivs = document.querySelectorAll('.card')
     cardBorderDivs.forEach(function (cardBorderDiv){
         cardBorderDiv.classList.remove('border-danger')
     })
     console.log('снятие выделения')
}

function order(){
    document.addEventListener('DOMContentLoaded', function (){
        let defaultCategoryId = document.getElementById('category').value
        console.log('выбранная категория: ', defaultCategoryId)

        let defaultSpecializationId = document.getElementById('specialization').value
        loadCategoryBySpecialization(defaultSpecializationId)

        //загрузка клиента при обновлении страницы
        loadClientsBySpecialization(defaultSpecializationId)

        //обработчик события выбора специализации
        document.getElementById('specialization').addEventListener('change', function (){
            let specializationId = this.value
            loadCategoryBySpecialization(specializationId)
            loadClientsBySpecialization(specializationId)
        })

        //обработчик события выбора категории
        document.getElementById('category').addEventListener('change', function (){
            let categoryId = this.value
            loadServicesByCategory(categoryId)
        })

        // массив для хранения добавленных сервисов
        let addedService = []

        // элемент, в котором будут выводиться выбранные сервисы
        const displaySelectedWorks = document.getElementById('displaySelectedWorks')

        // выводим в консоль переменную service
        console.log(services)

        // Получаем кнопку с id 'addToService'
        const addButton = document.getElementById('addToServiceList')

        // Функция для обновления списка добавленных сервисов
        function updateAddedServiceList() {
            displaySelectedWorks.innerHTML = ''
            let total = 0

            addedService.forEach(function (serviceId) {
                const serviceCh = services.find(service => service.id === parseInt(serviceId, 10));

                if (serviceCh) {
                    let serviceDiv = document.createElement('div')
                    serviceDiv.classList.add('card', 'mb-2')
                    serviceDiv.dataset.id = serviceCh.id

                    let cardBody = document.createElement('div')
                    cardBody.classList.add('card-body', 'd-flex', 'justify-content-between', 'align-items-center')

                    let cardTitle = document.createElement('h5')
                    cardTitle.classList.add('card-title')
                    cardTitle.textContent = serviceCh.service

                    let cardText = document.createElement('p')
                    cardText.classList.add('card-text', 'ml-auto')
                    cardText.textContent = `${serviceCh.price} p.`

                    //serviceDiv.textContent = `${serviceCh.service} - ${serviceCh.price}`
                    //serviceDiv.classList.add('selectable')

                    let deleteButton = document.createElement('button')
                    deleteButton.classList.add('btn', 'btn-danger')
                    deleteButton.textContent = 'удалить'
                    deleteButton.addEventListener('click', function (event) {
                        event.preventDefault()
                        let idToRemove = parseInt(this.parentElement.parentElement.dataset.id, 10)
                        console.log('удаляем услугу с id: ', idToRemove)
                        let indexToRemove = addedService.indexOf(idToRemove)

                        if (indexToRemove !== -1) {
                            addedService.splice(indexToRemove, 1)
                            this.parentElement.parentElement.remove()
                            updateTotalPrice()
                        }
                    });

                    cardBody.appendChild(cardTitle)
                    cardBody.appendChild(cardText)
                    cardBody.appendChild(deleteButton)

                    serviceDiv.appendChild(cardBody)
                    displaySelectedWorks.appendChild(serviceDiv)
                    total += parseInt(serviceCh.price, 10)
                }
            });
            updateTotalPrice()
        }

        // Добавляем обработчик клика для кнопки 'addToService'
        addButton.addEventListener('click', function (){
            console.log('добавление в заказ наряд')
            selectedServices.forEach(function (serviceId){
                //проверяем наличие такого id
                if (!addedService.includes(serviceId)) {
                    addedService.push(serviceId)
                }
            })
            selectedServices.length = 0
            updateAddedServiceList()
            removeHighlight()
            console.log('addedService:',addedService)
        })

        //обработчик кнопки "сохранить заказ наряд"
        let saveOrderButton = document.getElementById('saveOrderButton')
        saveOrderButton.addEventListener('click', function (){
           console.log('сохраняем заказ наряд')
            saveOrder()
            //location.reload()настроил подгрузку клиентов с установкой по умолчанию текущего
            })

        //функция сохранения заказа
        function saveOrder(){
            let specializationId = document.getElementById('specialization').value
            console.log('specializationId: ', specializationId)
            let clientId = document.getElementById('clients').value
            console.log('addedServices: ', addedService)
            let totalAmount = document.getElementById('totalAmount').textContent
            console.log('totalAmount',totalAmount)
            let materials = document.getElementById('materials').value
            console.log('materials: ', materials)
            let comments = document.getElementById('comments').value
            let orderData = {
                specializationId: specializationId,
                clientId: clientId,
                services: addedService,
                totalAmount: totalAmount,
                materials: materials,
                comments: comments,
            }
            let xhr = new XMLHttpRequest()
            xhr.open('POST', '/save_order', true)
            xhr.setRequestHeader('Content-Type', 'application/json')
            xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').getAttribute('content'))
            xhr.onload = function (){
                if (xhr.status >= 200 && xhr.status < 400) {
                    console.log('Заказ успешно сохранен')
                } else {
                    console.error('Ошибка при сохранении')
                }
            }
            xhr.send(JSON.stringify(orderData))
            console.log(orderData)
        }

        // Функция для обновления общей суммы
        function updateTotalPrice(){
            let total = 0;
            addedService.forEach(function (serviceId){
                const serviceCh = services.find(service => service.id === serviceId)
                if (serviceCh){
                    total += parseInt(serviceCh.price)
                }
            })
            const totalAmount = document.getElementById('totalAmount')
            totalAmount.textContent = total
        }
    })
}

function edit(){

//тут пишу для редактирования каталога

    let selectedServiceId
    let selectedCategoryId
    let selectedSpecialization

    document.addEventListener('DOMContentLoaded', function (){
        console.log('listener is started')
        let defaultCategory = document.getElementById('category').value
        let defaultSpecialization = document.getElementById('specialization').value
        console.log('Выбрана категория с id: ', defaultCategory)
        loadCategoryBySpecialization(defaultSpecialization)
        loadServicesByCategory(defaultCategory)
        loadClientsBySpecialization(defaultSpecialization)

        //подгружаем всех клиентов
        function loadClientsBySpecialization(specializationId){
            console.log('подгружаем всех клиентов');

            // Создаем объект XMLHttpRequest
            let xhr = new XMLHttpRequest();

            // Открываем GET запрос на сервер
            xhr.open('GET', `/get_clients/${specializationId}`, true);

            // Обработчик загрузки данных
            xhr.onload = function () {
                // Проверяем, успешен ли запрос
                if (xhr.status >= 200 && xhr.status < 400) {
                    // Парсим полученный ответ в формате JSON
                    let clients = JSON.parse(xhr.responseText);

                    // Получаем элемент select для клиентов
                    let clientSelect = document.getElementById('client');

                    // Очищаем список клиентов перед добавлением новых данных
                    clientSelect.innerHTML = '';

                    // Проверяем, есть ли клиенты для данной специализации
                    if (Array.isArray(clients) && clients.length > 0) {
                        // Если есть клиенты, добавляем каждого в выпадающий список
                        clients.forEach(function (client) {
                            let option = document.createElement('option');
                            option.value = client.id;
                            option.textContent = client.name + " - " + client.phone;
                            clientSelect.appendChild(option);
                        });
                    } else {
                        // Если клиентов нет, добавляем соответствующий вариант в выпадающий список
                        let option = document.createElement('option');
                        option.value = '';
                        option.textContent = 'клиентов нет';
                        clientSelect.appendChild(option);
                    }
                } else {
                    // Если сервер вернул ошибку, выводим сообщение об ошибке в консоль
                    console.error('Не удалось получить данные о клиентах: ' + xhr.statusText);
                }
            };

            // Обработчик ошибки сети
            xhr.onerror = function () {
                console.error('Ошибка сети');
            };

            // Отправляем запрос на сервер
            xhr.send();
        }

        //обработчик селектора изменение специализации
        document.getElementById('specialization').addEventListener('change', function (){
            let specializationID = this.value
            loadCategoryBySpecialization(specializationID)
            loadClientsBySpecialization(specializationID)
        })

        //обработчик селектора изменение категории
        document.getElementById('category').addEventListener('change', function (){
            let categoryId = this.value
            loadServicesByCategory(categoryId)
        })

        //подгружаем категории по специализации
        function loadCategoryBySpecialization(specializationId){
            console.log('выбрана специализация: ', specializationId)
            let xhr = new XMLHttpRequest()
            xhr.open('GET', `/get_categories/${specializationId}`, true)
            xhr.onload = function (){
                if (xhr.status >= 200 && xhr.status < 400) {
                    let categories = JSON.parse(xhr.responseText)
                    console.log(categories)
                    let categorySelect = document.getElementById('category')
                    categorySelect.innerHTML = ''
                    console.log('очистка')
                    console.log('categories: ', categories)
                    if (categories.length === 0) {
                        let option = document.createElement('option')
                        option.value = ''
                        option.textContent = 'нет категорий в данной сспециализации'
                        categorySelect.appendChild(option)
                        clearServicesList()
                        selectedCategoryId = ''
                    } else {
                        categories.forEach(function (category) {
                            console.log(category)
                            let option = document.createElement('option')
                            option.value = category.id
                            option.textContent = category.category_name
                            categorySelect.appendChild(option)
                        })
                        let currentCategoryId = document.getElementById('category').value
                        loadServicesByCategory(currentCategoryId)
                    }
                }
            }
            xhr.onerror = function (){
                console.log('Ошибка сети')
            }
            xhr.send()
        }

        //подгружаем услуги по категориям
        function loadServicesByCategory(categoryId){
            let servicesDiv = document.getElementById('servicesDiv')
            selectedCategoryId = categoryId
            console.log('выбрана категория: ', selectedCategoryId)

            let xhr = new XMLHttpRequest()
            xhr.open('GET', `/get_service/${categoryId}`, true)
            xhr.onload = function (){
                if (xhr.status >= 200 && xhr.status < 400) {

                    // парсим полученный ответ
                    let services = JSON.parse(xhr.responseText)
                    console.log('Категория Id: ', categoryId, ' сервисы: ', services)
                    servicesDiv.innerHTML = ''

                    let cardDeck = document.createElement('div')
                    cardDeck.classList.add('card-deck')

                    services.forEach(function (service) {
                        let serviceCard = document.createElement('div')
                        serviceCard.classList.add('card', 'mb-2')

                        let cardBody = document.createElement('div')
                        cardBody.classList.add('card-body', 'd-flex', 'justify-content-between', 'align-items-center')

                        let cardTitle = document.createElement('h5')
                        cardTitle.classList.add('card-title')
                        cardTitle.textContent = service.service

                        let cardText = document.createElement('p')
                        cardText.classList.add('card-text', 'ml-auto')
                        cardText.textContent = `${service.price}`

                        cardBody.appendChild(cardTitle)
                        cardBody.appendChild(cardText)
                        serviceCard.appendChild(cardBody)

                        //Добавляем обработчик клика
                        serviceCard.addEventListener('click', function (){
                            let serviceId = parseInt(serviceCard.dataset.id)
                            console.log('Выбран сервис с id: ', serviceId)
                            selectedServiceId = serviceId

                            //Убираем подсветку всех сервисов
                            servicesDiv.querySelectorAll('.card').forEach(function (card){
                                card.classList.remove('border-danger')
                            })

                            //подсвечиваем выбранный
                            serviceCard.classList.add('border-danger')
                        })

                        serviceCard.dataset.id = service.id
                        cardDeck.appendChild(serviceCard)
                    })

                    servicesDiv.appendChild(cardDeck)

                } else {
                    servicesDiv.innerHTML = ''
                    console.log('Не найдено в базе: ' + xhr.statusText)

                }
            }
            xhr.onerror = function (){
                console.error('Ошибка сети')
            }
            xhr.send()
        }

        //обработчик кнопки "Добавить новую специализацию"
        let showAddSpecializationModalButton = document.getElementById('showAddNewSpecializationModalButton')
        //let newSpecializationForm = document.getElementById('addSpecializationDiv')
        showAddSpecializationModalButton.addEventListener('click', function (){
            let modal = new bootstrap.Modal(document.getElementById('addSpecializationModal'))
            modal.show()
        })

        //обработчик кнопки "Добавить клиента"
        let showAddClientModalFormButton = document.getElementById('showAddClientModalForm')
        showAddClientModalFormButton.addEventListener('click', function (){
            let modal = new bootstrap.Modal(document.getElementById('addClientModal'))
            modal.show()
        })

        //обработчик кнопки добавить новую категорию
        let showModalNewCategory = document.getElementById('showAddCategoryForm')
        showModalNewCategory.addEventListener('click', function (){
            let modal = new bootstrap.Modal(document.getElementById('addCategoryModal'))
            modal.show()
        })

        //обработчик кнопки "добавить новую услугу"
        let showModalNewService = document.getElementById('showAddNewServiceModalButton')
        showModalNewService.addEventListener('click', function (){
            let modal = new bootstrap.Modal(document.getElementById('newServiceModal'))
            modal.show()
            let saveServiceButton = document.getElementById('saveNewServiceButton')
            saveServiceButton.addEventListener('click', function (){
                let serviceName = document.getElementById('serviceNameInput').value
                let servicePrice = document.getElementById('servicePriceInput').value
                console.log('название сервиса: ', serviceName, 'цена: ', servicePrice)
                let formData = new FormData()
                formData.append('service', serviceName)
                formData.append('price', servicePrice)
                formData.append('category_id', selectedCategoryId)
                let xhr = new XMLHttpRequest()
                xhr.open('POST', '/add_service', true)
                xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken)
                xhr.onload = function (){
                    if (xhr.status === 200){
                        console.log('Услуга успешно добавлена')
                        clearServicesList()
                        loadServicesByCategory(selectedCategoryId)
                        //location.reload()
                    } else {
                        console.error(xhr.statusText)
                    }
                }
                xhr.onerror = function (){
                    console.log('Ошибка сети')
                }
                xhr.send(formData)
            })
        })

        //обработчик формы "добавление новой специализации"
        document.getElementById('saveNewSpecialization').addEventListener('click', function (){
            let specializationName = document.getElementById('addSpecializationInput').value
            console.log(specializationName)
            let formData = new FormData()
            formData.append('specializationName', specializationName)
            let xhr = new XMLHttpRequest()
            xhr.open('POST', '/add_specialization', true)
            xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').getAttribute('content'))
            xhr.onload = function (){
                if (xhr.status === 200){
                    console.log('Специализация успешно добавлена')
                    location.reload()
                } else {
                    console.error(xhr.statusText)
                }
            }
            xhr.onerror = function (){
                console.log('Ошибка сети')
            }
            xhr.send(formData)
        })

        //обработчик формы "добавить клиента"
        document.getElementById('saveNewClientButton').addEventListener('click', function (){
            let clientName = document.getElementById('nameClientInput').value
            let clientPhone = document.getElementById('phoneClientInput').value
            let currentSpecializationId = document.getElementById('specialization').value
            let formData = new FormData()
            formData.append('name', clientName)
            formData.append('phone', clientPhone)
            formData.append('specialization_id', currentSpecializationId)
            let xhr = new XMLHttpRequest()
            xhr.open('POST', '/add_client', true)
            xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').getAttribute('content'))
            xhr.onload = function (){
                if (xhr.status === 200) {
                    console.log('Клиент успешно добавлен')
                    document.getElementById('addClientDiv').style.display = 'none'
                    loadClientsBySpecialization(currentSpecializationId)
                } else {
                    console.error(xhr.statusText)
                }
            }
            xhr.onerror = function (){
                console.log('Ошибка сети')
            }
            xhr.send(formData)
        })

        //обработчик формы "добавить новую категорию"
        document.getElementById('saveNewCategoryButton').addEventListener('click', function (){
            const newNameCategory = document.getElementById('addCategoryNameInput').value
            console.log(newNameCategory)
            let formData = new FormData()
            formData.append('category_name', newNameCategory)
            let currentSpecialization = document.getElementById('specialization').value
            console.log('выбрана специализация: ', currentSpecialization)
            formData.append('specialization_id', currentSpecialization)
            let xhr = new XMLHttpRequest()
            xhr.open('POST', '/add_category', true)
            xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').getAttribute('content'))
            xhr.onload = function (){
                if (xhr.status === 200) {
                    console.log('категория успешно добавлена')
                    location.reload()
                } else {
                    console.error(xhr.statusText)
                }
            }
            xhr.onerror = function (){
                console.log('Ошибка сети')
            }
            xhr.send(formData)
        })

        // Удаление специализации
        function deleteSpecialization(specializationId){
            console.log('Удаляем специализацию с Id: ', specializationId)
            let xhr = new XMLHttpRequest()
            xhr.open('POST', '/delete_specialization')
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
            xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').getAttribute('content'))
            xhr.onload = function (){
                if (xhr.status === 200) {
                    console.log('Специализация успешно удалена')
                    location.reload()
                } else {
                    console.log('Ощибка сети')
                }
            }
            xhr.onerror = function (){
                console.log('Ошибка сети')
            }
            xhr.send('specializationId=' + encodeURIComponent(specializationId))
        }

        function deleteClient(clientId){
            let currentSpecialization = document.getElementById('specialization').value
            let xhr = new XMLHttpRequest()
            xhr.open('POST', '/delete_client')
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
            xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').getAttribute('content'))
            xhr.onload = function (){
                if (xhr.status === 200) {
                    console.log('Клиент удален')
                    loadClientsBySpecialization(currentSpecialization)
                } else {
                    console.log('Ошибка сети')
                }
            }
            xhr.send('clientId=' + encodeURIComponent(clientId))
        }

        // Удаление категории
        function deleteCategory(categoryId) {
            console.log('начинается удаление')
            const xhr = new XMLHttpRequest()
            xhr.open('POST', '/delete_category')
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
            xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').getAttribute('content'))
            xhr.onload = function () {
                if (xhr.status === 200) {
                    console.log('Категория успешно удалена')
                    location.reload()
                } else {
                    console.log('Ошибка сети')
                }
            }
            xhr.onerror = function (){
                console.log('Ошибка сети')
            }
            xhr.send('categoryId=' + encodeURIComponent(categoryId))
        }

        //удаление сервиса
        function deleteService(serviceId) {
            const xhr = new XMLHttpRequest()
            xhr.open('POST', '/delete_service', true)
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
            xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').getAttribute('content'))

            xhr.onload = function () {

                if (xhr.status === 200) {
                    console.log('Сервис успешно удален')
                    location.reload()
                } else {
                    console.log(xhr.statusText)
                }
            }
            xhr.onerror = function (){
                console.log('Ошибка сети')
            }
            xhr.send('serviceId=' + encodeURIComponent(serviceId))
        }

        //обработчик кнопки удаления специализации
        document.getElementById('deleteSpecializationButton').addEventListener('click', function (){
            let selectedSpecializationId = document.getElementById('specialization').value
            deleteSpecialization(selectedSpecializationId)
        })

        //обработчик кнопки удаления клиента
        document.getElementById('deleteClientButton').addEventListener('click', function (){
            let selectedClient = document.getElementById('client').value
            deleteClient(selectedClient)
        })

        //обработчик для удаления выбранной категории
        document.getElementById('deleteCategory').addEventListener('click', function (){
            console.log('нажата кнопка удалить категорию')
            const selectedCategoryId = document.getElementById('category').value
            console.log('удаляю категорию: ', selectedCategoryId)
            deleteCategory(selectedCategoryId)
        })

        // обработчик кнопки для удаления выбранного сервиса
        let deleteServiceButton = document.getElementById('deleteServiceButton')
        deleteServiceButton.addEventListener('click', function (){
        console.log('selectedServiceId: ' ,selectedServiceId)
            if (selectedServiceId) {
                console.log('удаляем сервис: ', selectedServiceId)
                deleteService(selectedServiceId)
            } else {
                console.log('выберите сервис для удаления')
            }
        })

        // обработчик кнопки "изменить специализацию"
        let editSpecializationButton = document.getElementById('showEditSpecializationModalButton')
        editSpecializationButton.addEventListener('click', function (){
            let selectedSpecializationName = document.getElementById('specialization').options[document.getElementById('specialization').selectedIndex].text
            console.log('меняем специализацию: ',selectedSpecializationName)
            document.getElementById('editSpecializationInput').value = selectedSpecializationName
            let modal = new bootstrap.Modal(document.getElementById('editSpecializationModal'))
            modal.show()
        })

        // обработчик кнопки "изменить клиента"
        let editClientButton = document.getElementById('showEditClientModalButton')
        editClientButton.addEventListener('click', function (){
            let modal = new bootstrap.Modal(document.getElementById('editClientModal'))
            modal.show()
            let clientSelect = document.getElementById('client')
            let selectedClientId = clientSelect.value
            let selectClientName = ''
            let selectClientPhone = ''
            if (selectedClientId !== '') {
                let selectedOption = clientSelect.querySelector(`option[value="${selectedClientId}"]`)
                let clientInfoArray = selectedOption.textContent.split('-')
                if (clientInfoArray.length === 2){
                    selectClientName = clientInfoArray[0].trim()
                    selectClientPhone = clientInfoArray[1].trim()
                } else {
                    console.log('не могу отделить имя от телефона')
                }
            } else {
                console.log('тут ничего нет')
            }
            console.log(selectClientName)
            console.log(selectClientPhone)
            document.getElementById('newNameClientInput').value = selectClientName
            document.getElementById('newPhoneClientInput').value = selectClientPhone
        })

        // обработчик для кнопки "изменить услугу"
        let editServiceButton = document.getElementById('openEditServiceModalButton')
        editServiceButton.addEventListener('click', function () {
            console.log('меняем услугу')
            let selectedService = document.querySelector(`[data-id="${selectedServiceId}"]`)
            //console.log(selectedService)

            if (selectedService) {
                //let serviceId = selectedService.dataset.id
                let serviceNameElement = selectedService.querySelector('.card-title')
                let servicePriceElement = selectedService.querySelector('.card-text')

                if (serviceNameElement && servicePriceElement) {
                    let serviceName = serviceNameElement.textContent
                    let servicePrice = servicePriceElement.textContent.trim()
                    console.log('название сервиса: ', serviceName)
                    document.getElementById('editServiceName').value = serviceName
                    document.getElementById('editServicePrice').value = servicePrice

                    //открываем модальное окно
                    let modal = new bootstrap.Modal(document.getElementById('editServiceModal'))
                    modal.show()
                } else {
                    console.log('Не удалось найти информацию о сервисе')
                }
            } else {
                console.log('не удалось найти информацию о сервисе')
            }
        })

        // обработчик для кнопки "изменить категорию"
        let editCategoryButton = document.getElementById('showEditCategoryModalButton')
        editCategoryButton.addEventListener('click', function (){
            let selectedCategoryId = document.getElementById('category').value
            let selectedCategoryName = document.getElementById('category').options[document.getElementById('category').selectedIndex].text
            document.getElementById('editCategoryNameInput').value = selectedCategoryName
            console.log('меняем категорию: ',selectedCategoryName, selectedCategoryId)
            let modal = new bootstrap.Modal(document.getElementById('editCategoryModal'))
            modal.show()
        })

        // обработчик формы редактирования специализации
        document.getElementById('saveNewNameSpecializationButton').addEventListener('click', function (e){
            e.preventDefault()
            let selectedSpecializationId = document.getElementById('specialization').value
            let newSpecializationName = document.getElementById('editSpecializationInput').value
            let formData = new FormData()
            formData.append('id', selectedSpecializationId)
            formData.append('specializationName', newSpecializationName)
            let xhr = new XMLHttpRequest()
            xhr.open('POST', '/edit_specialization', true)
            xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').getAttribute('content'))
            xhr.onload = function (){
                if (xhr.status === 200) {
                    console.log('Специализация успешно изменена')
                    //location.reload()
                } else {
                    console.log(xhr.statusText)
                }
            }
            xhr.onerror = function (){
                console.error('Ошибка сети')
            }
            xhr.send(formData)
            location.reload()
        })

        // обработчик формы редактирования клиента
        document.getElementById('saveNewNameClientButton').addEventListener('click', function (){
            let selectedSpecializationId = document.getElementById('specialization').value
            let selectedClientId = document.getElementById('client').value
            let newClientName = document.getElementById('newNameClientInput').value
            let newClientPhone = document.getElementById('newPhoneClientInput').value
            let formData = new FormData()
            formData.append('id', selectedClientId)
            formData.append('name', newClientName)
            formData.append('phone', newClientPhone)
            let xhr = new XMLHttpRequest()
            xhr.open('POST', '/edit_client', true)
            xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').getAttribute('content'))
            xhr.onload = function (){
                if (xhr.status === 200){
                    console.log('Клиент успешно изменен')
                    loadClientsBySpecialization(selectedSpecializationId)
                } else {
                    console.log(xhr.status)
                }
            }
            xhr.onerror = function (){
                console.error('ошибка сети')
            }
            xhr.send(formData)
            document.getElementById('editClientDiv').style.display = 'none'
        })

        // обработчик формы редактирования категории
        document.getElementById('saveNewNameCategoryButton').addEventListener('click', function (){
            let currentSpecializationId = document.getElementById('specialization').value
            let selectedCategoryId = document.getElementById('category').value
            let editCategoryId = selectedCategoryId
            let newCategoryName = document.getElementById('editCategoryNameInput').value
            console.log('новое имя категории: ', newCategoryName)
            let formData = new FormData()
            formData.append('id', selectedCategoryId)
            formData.append('category_name', newCategoryName)
            let xhr = new XMLHttpRequest()
            xhr.open('POST', '/edit_category', true)
            xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').getAttribute('content'))
            xhr.onload = function (){
                if (xhr.status === 200) {
                    console.log('Категория успешно изменена')
                    loadCategoryBySpecialization(currentSpecializationId)
                    //location.reload()
                } else {
                    console.log(xhr.statusText)
                }
            }
            xhr.onerror = function (){
                console.log('Ошибка сети')
            }
            xhr.send(formData)
        })

        function setCategory(categoryId){
            let categorySelect = document.getElementById('category')
            categorySelect.value = categoryId
        }

        // обработчик модального окна изменения услуги
        let saveButton = document.getElementById('saveEditServiceButton')
        saveButton.addEventListener('click', function (){
            let currentCategory = document.getElementById('category').value
            console.log(currentCategory)
            console.log(selectedServiceId)
            let newServiceName = document.getElementById('editServiceName').value
            console.log(newServiceName)
            let newServicePrice = document.getElementById('editServicePrice').value
            console.log(newServicePrice)
            let formData = new FormData()
            formData.append('id', selectedServiceId)
            formData.append('service', newServiceName)
            formData.append('price', newServicePrice)

            let xhr = new XMLHttpRequest()
            xhr.open('POST', '/edit_service', true)
            xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').getAttribute('content'))

            xhr.onload = function (){
                if (xhr.status === 200){
                    console.log('Услуга изменена')
                    clearServicesList()
                    loadServicesByCategory(currentCategory)
                    // let modal = new bootstrap.Modal(document.getElementById('editServiceModal'))
                    // modal.hide()
                    //location.reload()
                } else {
                    console.error(xhr.statusText)
                }
            }
            xhr.onerror = function (){
                console.log('Ошибка сети')
            }
            xhr.send(formData)
        })

        // очистка сервис листа
        function clearServicesList(){
            let servicesDiv = document.getElementById('servicesDiv')
            servicesDiv.innerHTML = ''
        }

    })
}

function history(){
    console.log('history script')
    //обработчик клика по заказ-нарядам
    document.addEventListener('DOMContentLoaded', function (){
        let orderItems = document.querySelectorAll('.card.mb-3')
        orderItems.forEach(function (orderItem){
            orderItem.addEventListener('mouseover', function (){
                orderItem.style.background = 'blue'
            })

            orderItem.addEventListener('mouseout', function (){
                orderItem.style.background = ''
            })

            orderItem.addEventListener('click', function (){
                orderItem.style.backgroundColor = 'red'
            })
        })
    })
}

function deleteOrder(orderId){
    window.location.href = '/delete_order' + orderId
}

// function oldOrder(){
//     //console.log('oldOrder script')
//
//     //let editOrderButton = document.getElementById('editOrderButton')
//     //editOrderButton.addEventListener('click', function (){
//         //let orderId = document.getElementById('orderId').textContent
//         //console.log('редактируем ордер id: ', orderId)
//         //let editUrl = `/edit_order/${orderId}`
//         //window.location.href = editUrl
//     //})
// }

function editOldOrder(){
    //храним добавленые в заказ наряд id
    let addedServiceList = []
    let totalAmount

    function updateTotalAmount(){

        //НЕ РАБОТАЕТ

        totalAmount = 0
        addedServiceList.forEach(function (serviceId){
            let service = loadedServices.find(s => s.id === serviceId)
            if (service){
                totalAmount += service.price
            }
        })

        document.getElementById('totalAmount').textContent = totalAmount
        console.log('totalAmount: ', totalAmount)
    }

    console.log('editOldOrder script')

    //перебираем имеющиеся дивы и добавляем в addServiceList
    let serviceItems = document.querySelectorAll('.serviceItem')
    serviceItems.forEach(function (serviceItem){
        let serviceId = serviceItem.getAttribute('data-service-id')
        addedServiceList.push(parseInt(serviceId))
    })
    console.log('addedServiceList', addedServiceList)

    loadedServices.push(...services)
    //получение текущей категории
    let currentCategoryId = document.getElementById('category').value

    let addToServiceListButton = document.getElementById('addToServiceList')
    console.log('выбрана категория Id: ', currentCategoryId)

    //загружаем сервисы по категориям
    loadServicesByCategory(currentCategoryId)

    //обработчик изменения категории
    document.getElementById('category').addEventListener('change', function (){
        let categoryId = this.value
        loadServicesByCategory(categoryId)
    })

    //отображаем сервис лист
    function displayAddedServices(addedServiceList) {
        // Див с выполненными услугами
        let serviceDoneDiv = document.getElementById('serviceDoneDiv');

        // Очищаем
        serviceDoneDiv.innerHTML = '';

        console.log('addedServiceList: ', addedServiceList);

        if (addedServiceList.length > 0) {
            addedServiceList.forEach(function (serviceId) {
                // Ищем в массиве услуг serviceId
                let serviceCh = services.find(service => service.id === parseInt(serviceId, 10));

                // Если услуга найдена
                if (serviceCh) {
                    // Создаем новый элемент списка для услуги
                    let newServiceItem = document.createElement('li');
                    newServiceItem.classList.add('list-group-item');

                    // Создаем новую строку Bootstrap
                    let newRow = document.createElement('div');
                    newRow.classList.add('row', 'mb-2');

                    // Создаем новый элемент для названия услуги
                    let serviceNameCol = document.createElement('div');
                    serviceNameCol.classList.add('col-md-9');
                    serviceNameCol.textContent = serviceCh.service;

                    // Создаем новый элемент для цены услуги
                    let servicePriceCol = document.createElement('div');
                    servicePriceCol.classList.add('col-md-2');
                    servicePriceCol.textContent = serviceCh.price;

                    // Создаем новый элемент для кнопки удаления
                    let removeButtonCol = document.createElement('div');
                    removeButtonCol.classList.add('col-md-1');

                    let removeButton = document.createElement('button');
                    removeButton.classList.add('removeServiceButton', 'btn', 'btn-danger', 'bi', 'bi-trash');
                    removeButton.type = 'button';

                    // Добавляем обработчик события для кнопки удаления
                    removeButton.addEventListener('click', function () {
                        console.log('Удаляем услугу с Id: ', serviceCh.id);

                        // Тут логика для удаления
                        let indexToRemove = addedServiceList.indexOf(serviceId);
                        if (indexToRemove !== -1) {
                            addedServiceList.splice(indexToRemove, 1);
                            newRow.remove();
                            console.log('Список добавленных услуг', addedServiceList);
                        }
                        updateTotalAmount()
                    });

                    // Добавляем элементы в строку
                    removeButtonCol.appendChild(removeButton);
                    newRow.appendChild(serviceNameCol);
                    newRow.appendChild(servicePriceCol);
                    newRow.appendChild(removeButtonCol);

                    // Добавляем новую строку в элемент списка
                    newServiceItem.appendChild(newRow);

                    // Добавляем новый элемент списка в блок с услугами
                    serviceDoneDiv.appendChild(newServiceItem);
                }
            });
        } else {
            // Если нет услуг, выводим сообщение
            let noServicesItem = document.createElement('li');
            noServicesItem.classList.add('list-group-item');
            noServicesItem.textContent = 'Нет выполненных услуг';
            serviceDoneDiv.appendChild(noServicesItem);
        }
    }
    function displayNewAddedServices() {
        console.log('addedServiceList', addedServiceList);

        let serviceDoneDiv = document.getElementById('serviceDoneDiv');
        serviceDoneDiv.innerHTML = '';

        if (addedServiceList.length > 0) {
            addedServiceList.forEach(function (serviceId) {
                let loadedService = loadedServices.find(service => service.id === parseInt(serviceId, 10));

                if (loadedService) {
                    // Создаем новый элемент списка
                    let newServiceItem = document.createElement('li');
                    newServiceItem.classList.add('list-group-item');

                    // Создаем новую строку Bootstrap
                    let newRow = document.createElement('div');
                    newRow.classList.add('row', 'mb-2');

                    // Создаем новый элемент для названия услуги
                    let serviceNameCol = document.createElement('div');
                    serviceNameCol.classList.add('col-md-9');
                    serviceNameCol.textContent = loadedService.service;

                    // Создаем новый элемент для цены услуги
                    let servicePriceCol = document.createElement('div');
                    servicePriceCol.classList.add('col-md-2');
                    servicePriceCol.textContent = loadedService.price;

                    // Создаем новый элемент для кнопки удаления
                    let removeButtonCol = document.createElement('div');
                    removeButtonCol.classList.add('col-md-1');

                    let removeButton = document.createElement('button');
                    removeButton.classList.add('removeServiceButton', 'btn', 'btn-danger', 'bi', 'bi-trash');
                    removeButton.type = 'button';

                    // Добавляем обработчик события для кнопки удаления
                    removeButton.addEventListener('click', function () {
                        console.log('Удаляем услугу с Id: ', loadedService.id);

                        // Логика для удаления
                        let indexToRemove = addedServiceList.indexOf(serviceId);
                        if (indexToRemove !== -1) {
                            addedServiceList.splice(indexToRemove, 1);
                            newServiceItem.remove();
                            console.log('Список добавленных услуг', addedServiceList);
                        }
                        updateTotalAmount();
                    });

                    // Добавляем элементы в строку
                    removeButtonCol.appendChild(removeButton);
                    newRow.appendChild(serviceNameCol);
                    newRow.appendChild(servicePriceCol);
                    newRow.appendChild(removeButtonCol);

                    // Добавляем новую строку в элемент списка
                    newServiceItem.appendChild(newRow);

                    // Добавляем новый элемент списка в блок с услугами
                    serviceDoneDiv.appendChild(newServiceItem);
                }
            });
        } else {
            // Если нет услуг, выводим сообщение
            let noServicesItem = document.createElement('li');
            noServicesItem.classList.add('list-group-item');
            noServicesItem.textContent = 'Нет добавленных услуг';
            serviceDoneDiv.appendChild(noServicesItem);
        }

        updateTotalAmount();
    }


    //обработчик кнопки добавления "добавить в заказ наряд"
    addToServiceListButton.addEventListener('click', function (){
        let newServices = selectedServices.filter(serviceId => !addedServiceList.includes(serviceId))
        newServices.forEach(serviceId => {
            if (!addedServiceList.includes(serviceId)){
                addedServiceList.push(parseInt(serviceId))
            } else {
                console.log('такой сервис уже есть: ', serviceId)
            }
        })
        console.log('обновляем список услуг: ', addedServiceList)
        displayNewAddedServices()
        selectedServices.length = 0
        removeHighlight()

    })
    displayAddedServices(addedServiceList)

    function saveOrder(orderData){
        let xhr = new XMLHttpRequest()
        xhr.open('POST', '/update_order', true)
        xhr.setRequestHeader('Content-type', 'application/json')
        xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));        xhr.onreadystatechange = function (){
            if (xhr.readyState === 4) {
                if (xhr.status ===200) {
                    console.log(JSON.parse(xhr.responseText))
                } else {
                    console.log('Ошибка: ', xhr.statusText)
                }
            }
        }
        xhr.send(JSON.stringify(orderData))
    }

    let saveOrderButton = document.getElementById('saveOrderButton')
    saveOrderButton.addEventListener('click', function (){
        let clientId = document.getElementById('clients').value
        console.log('клиент: ', clientId)
        let orderId = document.getElementById('orderId').textContent.trim()
        console.log('Ордер id: ', orderId)
        let specializationId = document.getElementById('specializationSpan').dataset.specializationId
        console.log('специализация id: ', specializationId)
        let totalAmount = document.getElementById('totalAmount').textContent
        console.log('общая сумма: ', totalAmount)

        let servicesData = []
        servicesData = addedServiceList

        let orderData = {
            id: orderId,
            client_id: clientId,
            specialization_id: specializationId,
            services: servicesData,
            total_amount: totalAmount,
        }
        console.log(orderData)
        saveOrder(orderData)
    })

}
