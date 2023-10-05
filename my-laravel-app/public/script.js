document.addEventListener('DOMContentLoaded', function (){
    const serviceDivs = document.querySelectorAll('.service')
    const selectedServices = []
    const addedService = []
    const displaySelectedWorks = document.getElementById('displaySelectedWorks')

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
        addedService.forEach(function (serviceId){
            const serviceDiv = document.createElement('div');
            serviceDiv.textContent = serviceId
            displaySelectedWorks.appendChild(serviceDiv)
        })
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



