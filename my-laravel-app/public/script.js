document.addEventListener('DOMContentLoaded', function (){
    const serviceDivs = document.querySelectorAll('.service')
    const selectedServices = []
    const addedService = []
    const displaySelectedWorks = document.getElementById('displaySelectedWorks')

    console.log(services)

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

    const addButton = document.getElementById('addToServiceList')

    function removeHighlight() {
        serviceDivs.forEach(function (serviceDiv){
            serviceDiv.style.background = ''
        })
    }
    function updateAddedServiceList() {
        displaySelectedWorks.innerHTML = ''
        let total = 0
        addedService.forEach(function (serviceId){
            const serviceCh = services.find(service => service.id ===serviceId )
            if (serviceCh) {
                const serviceDiv = document.createElement('div');
                //serviceDiv.textContent = serviceCh.service;\
                serviceDiv.textContent = `${serviceCh.service} - ${serviceCh.price}`
                displaySelectedWorks.appendChild(serviceDiv)
                total += parseInt(serviceCh.price)
            }
        })
        const totalPrice = document.getElementById('totalDiv');
        totalPrice.textContent = total
    }

    function calculateTotalPrice(){
        let total = 0
    }

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
})



