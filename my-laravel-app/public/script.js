document.addEventListener('DOMContentLoaded', function (){
    const serviceDivs = document.querySelectorAll('.service')
    const selectedServices = []
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
            console.log(selectedServices)
        })
    })

    const addButton = document.getElementById('addToServiceList')

    addButton.addEventListener('click', function (){
        selectedServices.forEach(function (serviceId){
            const serviceDiv = document.createElement('div')
            serviceDiv.textContent = serviceId;

            const serviceElement = document.querySelector(`[data-id="${serviceId}"]`)
            serviceElement.style.background = ''
            displaySelectedWorks.appendChild(serviceDiv);
        })
        selectedServices.length = 0;
    })
})



