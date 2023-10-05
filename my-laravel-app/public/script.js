document.addEventListener('DOMContentLoaded', function() {
    const addButton = document.querySelector('button[data-id="addToServiceList"]');
    const serviceSelect = document.getElementById('service');
    const orderDiv = document.querySelector('.order');
    const selectedServices = [];

    addButton.addEventListener('click', function() {
        const selectedOption = serviceSelect.options[serviceSelect.selectedIndex];
        const serviceId = parseInt(selectedOption.value, 10);

        if (!selectedServices.includes(serviceId)) {
            selectedServices.push(serviceId);

            const serviceItem = document.createElement('div');
            serviceItem.innerText = selectedOption.innerText;
            orderDiv.appendChild(serviceItem);

            let isClicked = false

            serviceItem.addEventListener('click', function (){
                if (!isClicked) {
                    this.style.background = 'red'
                } else {
                    this.style.background = ''
                }
            })

            serviceItem.addEventListener('mouseover', function () {
                this.style.background = 'blue';
                this.style.color = 'white';
            })

            serviceItem.addEventListener('mouseout', function (){
                this.style.background = ''
                this.style.color = ''
            })

            console.log(selectedServices); // Печать в консоль
        }
    });
});

