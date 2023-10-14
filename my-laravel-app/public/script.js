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
        //получаем все элементы с классом service
        const serviceDivs = document.querySelectorAll('.serviceForEdit')

        //обрабатываем клик для выбранного сервиса
        serviceDivs.forEach(function (serviceDiv){
            serviceDiv.addEventListener('click', function (){
                const serviceId = parseInt(this.dataset.id)
                serviceDivs.forEach(function (serviceDiv) {
                    serviceDiv.style.background = ''
                })
                this.style.background = 'red'
            })
        })
    })
}


