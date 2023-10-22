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

        // Добавляем обработчик клика для каждого сервиса
        serviceDivs.forEach(function (serviceDiv){
            serviceDiv.addEventListener('click', function (){
                const serviceId = parseInt(this.dataset.id)
                const index = selectedServices.indexOf(serviceId)

                if (!selectedServices.includes(serviceId)) {
                    selectedServices.push(serviceId)
                    this.style.background = 'red'
                } else {
                    selectedServices.splice(selectedServices.indexOf(serviceId), 1)
                    this.style.background = ''
                }
                console.log('selectedService',selectedServices)
            })
        })

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

    document.addEventListener('DOMContentLoaded', function (){
        console.log('listener is started')

        //обработчик кнопки "добавить новую услугу"
        const showAddFormButton = document.getElementById('showAddForm')
        const serviceForm = document.getElementById('serviceForm')
        showAddFormButton.addEventListener('click', function (){
            serviceForm.style.display = 'block';
        })
        document.getElementById('addServiceForm').addEventListener('submit', function (e){
            e.preventDefault();
            //получаем значения формы
            const serviceName = this.querySelector('input[name="name"]').value
            const servicePrice = this.querySelector('input[name="price"]').value
            let formData = new FormData()
            formData.append('service', serviceName)
            formData.append('price', servicePrice)
            let xhr = new XMLHttpRequest()
            xhr.open('POST', '/add_service', true)
            xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').getAttribute('content'))
            xhr.onload = function (){
                if (xhr.status === 200) {
                    console.log('Услуга успешно добавлена')
                } else {
                    console.error(xhr.statusText)
                }
            }
            xhr.onerror = function (){
                console.log('Ошибка сети')
            }
            xhr.send(formData) //возвращает ошибку 500

        })

        function deleteService(serviceId) {
            const xhr = new XMLHttpRequest()
            xhr.open('POST', '/delete_service', true)
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
            xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="cdrf-token"]').getAttribute('content'))

            xhr.onload = function () {
                if (xhr.status === 200) {
                    console.log('Сервис успешно удален')
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

        // обработчик для удаления выбранного сервиса
        const deleteButton = document.getElementById('deleteService')
        deleteButton.addEventListener('click', function (){
            const selectedService = document.querySelector('.serviceForEdit[style="background: red;"]')

            if (selectedService) {
                const serviceId = selectedService.dataset.id
                console.log('удаляем сервис: ', serviceId)
                deleteService(serviceId)
            } else {
                console.log('выберите сервис для удаления')
            }
        })

        // обработчик для кнопки "изменить"
        const editButton = document.getElementById('editService')
        editButton.addEventListener('click', function (){
            const selectedService = document.querySelector('.serviceForEdit[style="background: red;"]')

            if (selectedService){
                const serviceId = selectedService.dataset.id
                console.log('редактируем: ', serviceId)
            } else {
                console.log('выберите сервис для редактирования')
            }
        })

        //обрабатываем клик для выбранного сервиса
        serviceDivs.forEach(function (serviceDiv){
            serviceDiv.addEventListener('click', function (){
                const serviceId = parseInt(this.dataset.id)
                console.log('Выбран сервис с id: ', serviceId)
                serviceDivs.forEach(function (serviceDiv) {
                    serviceDiv.style.background = ''
                })
                this.style.background = 'red'
            })
        })
    })
}


