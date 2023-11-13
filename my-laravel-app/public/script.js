if(document.querySelector('#displaySelectedWorks')){
    console.log('order script')
    order()
}

if (document.getElementById('editService')){

    console.log('edit script')
    edit()
}

function order(){
    document.addEventListener('DOMContentLoaded', function (){
        let defaultCategoryId = document.getElementById('category').value
        console.log('выбранная категория: ', defaultCategoryId)

        let defaultSpecializationId = document.getElementById('specialization').value
        loadCategoryBySpecialization(defaultSpecializationId)

        //для правильной загрузки, изначально грузит вообще все, надо будет испралять в контролере
        loadServicesByCategory(defaultCategoryId)

        //грузим категории по специализации
        function  loadCategoryBySpecialization(specializationId){
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
                    console.log('Категория Id: ', categoryId, ' сервисы: ', services)
                    let servicesDiv = document.getElementById('services')
                    servicesDiv.innerHTML = ''
                    services.forEach(function (service){
                        let serviceDiv = document.createElement('div')
                        serviceDiv.textContent = `${service.service} - ${service.price}`
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

        //обработчик клика для сервисов
        function addClickHandlers(){
            const serviceDivs = document.querySelectorAll('.selectable')
            serviceDivs.forEach(function (serviceDiv){
                serviceDiv.addEventListener('click', function (){
                    const serviceId = parseInt(this.dataset.id);
                    const index = selectedServices.indexOf(serviceId)
                    if (!selectedServices.includes(serviceId)){
                        selectedServices.push(serviceId)
                        this.style.background = 'red'
                    } else {
                        selectedServices.splice(selectedServices.indexOf(serviceId), 1)
                        this.style.background = ''
                    }
                    console.log('selected Service', selectedServices)

                })
            })
        }

        //обработчик события выбора специализации
        document.getElementById('specialization').addEventListener('change', function (){
            let specializationId = this.value
            loadCategoryBySpecialization(specializationId)
        })

        //обработчик события выбора категории
        document.getElementById('category').addEventListener('change', function (){
            let categoryId = this.value
            loadServicesByCategory(categoryId)
        })

        // получаем все элементы с классом 'service'
        const serviceDivs = document.querySelectorAll('.service')

        // массив для хранения выбранных сервисов
        const selectedServices = []

        // массив для хранения добавленных сервисов
        let addedService = []

        // элемент, в котором будут выводиться выбранные сервисы
        const displaySelectedWorks = document.getElementById('displaySelectedWorks')

        // выводим в консоль переменную service
        console.log(services)

        // Получаем кнопку с id 'addToService'
        const addButton = document.getElementById('addToServiceList')

        // Функция для снятия выделения с сервисов
        function removeHighlight() {
            serviceDivs.forEach(function (serviceDiv){
                serviceDiv.style.background = ''
            })
        }
        // Функция для обновления списка добавленный сервисов
        function updateAddedServiceList() {
            displaySelectedWorks.innerHTML = ''
            let total = 0
            addedService.forEach(function (serviceId){
                const serviceCh = services.find(service => service.id === serviceId )
                if (serviceCh) {
                    const serviceDiv = document.createElement('div');
                    serviceDiv.textContent = `${serviceCh.service} - ${serviceCh.price}`
                    serviceDiv.classList.add('selectable')
                    serviceDiv.dataset.id = serviceCh.id

                    const deleteButton = document.createElement('button')
                    deleteButton.textContent = 'удалить'
                    deleteButton.addEventListener('click', function (){
                        const idToRemove = parseInt(this.parentElement.dataset.id)
                        console.log("idToRemove: ",idToRemove)
                        console.log(addedService)
                        const indexToRemove = addedService.indexOf(idToRemove)
                        console.log("indexToRemove: ",indexToRemove)
                        if (indexToRemove !== -1) {
                            console.log('ok remove')
                            addedService.splice(indexToRemove,1)
                            this.parentElement.remove()
                            updateTotalPrice()
                        } else {
                            console.log("!не найден в addedService!")
                        }
                        console.log("remove click")
                        console.log("addedService: ",addedService)
                    })
                    serviceDiv.appendChild(deleteButton)

                    displaySelectedWorks.appendChild(serviceDiv)
                    total += parseInt(serviceCh.price)
                }
            })
            const totalPrice = document.getElementById('totalDiv');
            totalPrice.textContent = total

            const selectableDivs = document.querySelectorAll('.selectable')
            selectableDivs.forEach(function (div){
                div.addEventListener('click', function (){
                    selectableDivs.forEach(function (div){
                        div.classList.remove('selected')
                    })
                    this.classList.toggle('selected')
                })
            })
        }

        // Добавляем обработчик клика для кнопки 'addToService'
        addButton.addEventListener('click', function (){
            selectedServices.forEach(function (serviceId){
                //проверяем наличие такого id
                if (!addedService.includes(serviceId)) {
                    addedService.push(serviceId)
                }
            })
            selectedServices.length = 0
            removeHighlight()
            updateAddedServiceList()
            console.log('addedService:',addedService)
        })

        // Функция для обновления общей суммы
        function updateTotalPrice(){
            let total = 0;
            addedService.forEach(function (serviceId){
                const serviceCh = services.find(service => service.id === serviceId)
                if (serviceCh){
                    total += parseInt(serviceCh.price)
                }
            })
            const totalPrice = document.getElementById('totalDiv')
            totalPrice.textContent = total
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
            console.log('подгружаем всех клиентов')
            let xhr = new XMLHttpRequest()
            xhr.open('GET', `/get_clients/${specializationId}`, true)
            xhr.onload = function (){
                if (xhr.status >= 200 && xhr.status < 400){
                    let clients = JSON.parse(xhr.responseText)
                    let clientSelect = document.getElementById('client')
                    clientSelect.innerHTML = ''
                    if (clients.length === 0) {
                        let option = document.createElement('option')
                        option.value = ''
                        option.textContent = 'клиентов нет'
                        clientSelect.appendChild(option)
                    } else {
                        clients.forEach(function (client){
                            let option = document.createElement('option')
                            option.value = client.id
                            option.textContent = client.name
                            clientSelect.appendChild(option)
                        })
                    }
                }
            }
            xhr.send()
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
                    services.forEach(function (service) {
                        let serviceDiv = document.createElement('div')
                        serviceDiv.textContent = `${service.service} - ${service.price}`
                        serviceDiv.classList.add('selectable')
                        serviceDiv.dataset.id = service.id
                        servicesDiv.appendChild(serviceDiv)
                    })
                        //добавляем обработчик клика
                    servicesDiv.querySelectorAll('.selectable').forEach(function (div){
                         div.addEventListener('click', function (){
                             const serviceId = parseInt(this.dataset.id)
                             console.log('Выбран сервис с id: ', serviceId)
                             selectedServiceId = serviceId
                             //убираю подсветку у всех сервисов
                             servicesDiv.querySelectorAll('.selectable').forEach(function (div){
                                 div.classList.remove('selected')
                             })
                             //подсвечиваю выбранный
                             this.classList.add('selected')
                            })
                        })

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
        let showAddSpecializationFormButton = document.getElementById('addNewSpecializationButton')
        let newSpecializationForm = document.getElementById('addSpecializationDiv')
        showAddSpecializationFormButton.addEventListener('click', function (){
            newSpecializationForm.style.display = 'block'
        })

        //обработчик кнопки "Добавить клиента"
        let showAddClientFormButton = document.getElementById('showAddClientForm')
        let newClientDiv = document.getElementById('addClientDiv')
        showAddClientFormButton.addEventListener('click', function (){
            newClientDiv.style.display = 'block'
        })

        //обработчсик кнопки "добавить новую категорию"
        const showAddCategoryFormButton = document.getElementById('showAddCategoryForm')
        const newCategoryForm = document.getElementById('addCategoryDiv')
        showAddCategoryFormButton.addEventListener('click', function (){
            newCategoryForm.style.display = 'block'
        })

        //обработчик кнопки "добавить новую услугу"
        const showAddFormButton = document.getElementById('showAddForm')
        const serviceForm = document.getElementById('serviceForm')
        showAddFormButton.addEventListener('click', function (){
            serviceForm.style.display = 'block';
        })

        //обработчик формы "добавление новой специализации"
        document.getElementById('addSpecializationDiv').addEventListener('submit', function (e){
            e.preventDefault()
            let specializationName = this.querySelector('input[name="specializationName"]').value
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
        document.getElementById('addClientDiv').addEventListener('submit', function (e){
            e.preventDefault()
            let clientName = this.querySelector('input[name="clientName"]').value
            let clientPhone = this.querySelector('input[name="clientPhone"]').value
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
                    console.log(xhr.responseText)
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

        //обработчик формы "добавить новую категорию"
        document.getElementById('addCategoryDiv').addEventListener('submit', function (e){
            e.preventDefault()
            const categoryName = this.querySelector('input[name="categoryName"]').value
            let formData = new FormData()
            formData.append('category_name', categoryName)
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

        //обработчик формы "добавить новую услугу"
        document.getElementById('addServiceForm').addEventListener('submit', function (e){
            e.preventDefault();
            //получаем значения формы
            const serviceName = this.querySelector('input[name="name"]').value
            const servicePrice = this.querySelector('input[name="price"]').value
            let formData = new FormData()
            formData.append('service', serviceName)
            formData.append('price', servicePrice)
            formData.append('category_id', selectedCategoryId)
            let xhr = new XMLHttpRequest()
            xhr.open('POST', '/add_service', true)
            xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').getAttribute('content'))
            xhr.onload = function (){
                if (xhr.status === 200) {
                    console.log('Услуга успешно добавлена')
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

        //получаем все элементы с классом service
        const serviceDivs = document.querySelectorAll('.serviceForEdit')

        //обработчик кнопки удаления специализации
        document.getElementById('deleteSpecializationButton').addEventListener('click', function (){
            let selectedSpecializationId = document.getElementById('specialization').value
            deleteSpecialization(selectedSpecializationId)
        })

        //обработчик для удаления выбранной категории
        document.getElementById('deleteCategory').addEventListener('click', function (){
            console.log('нажата кнопка удалить категорию')
            const selectedCategoryId = document.getElementById('category').value
            console.log('удаляю категорию: ', selectedCategoryId)
            deleteCategory(selectedCategoryId)
        })

        // обработчик кнопки для удаления выбранного сервиса
        const deleteButton = document.getElementById('deleteService')
        deleteButton.addEventListener('click', function (){
        console.log('selectedServiceId: ' ,selectedServiceId)
            if (selectedServiceId) {
                console.log('удаляем сервис: ', selectedServiceId)
                deleteService(selectedServiceId)
            } else {
                console.log('выберите сервис для удаления')
            }
        })

        // обработчик кнопки "изменить специализацию"
        let editSpecializationButton = document.getElementById('editSpecializationButton')
        editSpecializationButton.addEventListener('click', function (){
            let selectedSpecializationName = document.getElementById('specialization').options[document.getElementById('specialization').selectedIndex].text
            console.log('меняем специализацию: ',selectedSpecializationName)
            document.getElementById('editSpecializationNameInput').value = selectedSpecializationName
            document.getElementById('editSpecializationDiv').style.display = 'block'
        })

        // обработчик для кнопки "изменить услугу"
        const editButton = document.getElementById('editService')
        editButton.addEventListener('click', function (){
            const selectedService = document.querySelector(`[data-id="${selectedServiceId}"]`)
            console.log(selectedService)

            if (selectedService){
                const serviceId = selectedService.dataset.id
                const serviceInfo = selectedService.textContent.split(' - ')
                const serviceName = serviceInfo[0] //name
                const servicePrice = serviceInfo[1] //price
                console.log('название сервиса: ', serviceName)

                //Заполняем форму для редактирования
                //document.getElementById('editServiceId').value = serviceId
                document.getElementById('editServiceName').value = serviceName
                document.getElementById('editServicePrice').value = servicePrice

                //Открываем форму для редактирования
                const editForm = document.getElementById('editServiceDiv')
                editForm.style.display = 'block'

                console.log('редактируем: ', serviceId)
            } else {
                console.log('выберите сервис для редактирования')
            }
        })

        // обработчик для кнопки "изменить категорию"
        const editCategoryButton = document.getElementById('editCategoryButton')
        editCategoryButton.addEventListener('click', function (){
            let selectedCategoryId = document.getElementById('category').value
            let selectedCategoryName = document.getElementById('category').options[document.getElementById('category').selectedIndex].text
            document.getElementById('editCategoryNameInput').value = selectedCategoryName
            console.log('меняем категорию: ',selectedCategoryName, selectedCategoryId)
            document.getElementById('editCategoryDiv').style.display = 'block'
        })

        // обработчик формы редактирования специализации
        document.getElementById('editSpecializationForm').addEventListener('submit', function (e){
            e.preventDefault()
            let selectedSpecializationId = document.getElementById('specialization').value
            let newSpecializationName = document.getElementById('editSpecializationNameInput').value
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

        // обработчик формы редактирования категории
        document.getElementById('editCategoryForm').addEventListener('submit', function (e){
            e.preventDefault()
            let selectedCategoryId = document.getElementById('category').value
            let newCategoryName = document.getElementById('editCategoryNameInput').value
            let formData = new FormData()
            formData.append('id', selectedCategoryId)
            formData.append('category_name', newCategoryName)
            let xhr = new XMLHttpRequest()
            xhr.open('POST', '/edit_category', true)
            xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').getAttribute('content'))
            xhr.onload = function (){
                if (xhr.status === 200) {
                    console.log('Категория успешно изменена')
                    location.reload()
                } else {
                    console.log(xhr.statusText)
                }
            }
            xhr.onerror = function (){
                console.log('Ошибка сети')
            }
            xhr.send(formData)
        })

        // обработчик формы редактирования услуги
        document.getElementById('editServiceForm').addEventListener('submit', function (e){
            e.preventDefault()

            const selectedService = document.querySelector('.serviceForEdit[style="background: red;"]')
            console.log('меняем сервис с id: ', selectedServiceId)
            let newServiceName = this.querySelector('input[name="name"]').value
            console.log('новое имя сервиса: ', newServiceName)
            const newServicePrice = this.querySelector('input[name="price"]').value
            let formData = new FormData()
            formData.append('id', selectedServiceId)
            formData.append('service', newServiceName)
            formData.append('price', newServicePrice)
            let xhr = new XMLHttpRequest()
            xhr.open('POST', '/edit_service', true)
            xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').getAttribute('content'))
            xhr.onload = function (){
                if (xhr.status === 200) {
                    console.log('услуга изменена')
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

        // очистка сервис листа
        function clearServicesList(){
            let servicesDiv = document.getElementById('servicesDiv')
            servicesDiv.innerHTML = ''
        }

    })
}


