<script>
import axios from "axios"
import {BIconTrash} from 'bootstrap-vue'
//import {error} from "@babel/eslint-parser/lib/convert";
export default {
   components: {
     BIconTrash
   },

  data(){
    return {
      specializations: [],
      clients: [],
      categories: [],
      services: [],
      addedServices: [],
      selectedSpecialization: null,
      selectedClient: null,
      selectedCategory: null,
      materials: null,
      comments: null,
    }
  },

  computed: {
    tabTitleCounter() {
      return `добавлено услуг: ${this.addedServices.length}`
    },

    totalAddedServicesPrice(){
      return this.addedServices.reduce((total, service) => total + service.price, 0)
    },

  },

  methods: {

    handleSpecializationChange(){
      this.loadClients()
      this.loadCategories()
      console.log('выбрана специализация: ', this.selectedSpecialization)
    },

    handleClientChange(){
      //
    },

    handleCategoriesChange(){
      this.loadServicesByCategory()
      console.log('выбрана категория: ', this.selectedCategory)
    },

    loadCategories(){
      axios.get(`http://localhost:8000/get_categories/${this.selectedSpecialization}`)
          .then(response => {
            this.categories = response.data
            console.log('список категорий: ',this.categories)
          })
          .catch(error => {
            console.error('Ошибка загрузки категорий: ', error.message)
          })
    },

    loadClients(){
      axios.get(`http://localhost:8000/get_clients/${this.selectedSpecialization}`)
          .then(response => {
            this.clients = response.data
            console.log('список клиентов: ', this.clients)
          })
          .catch(error => {
            console.error('Ошибка загрузки клиентов: ', error.message)
          })
    },

    loadServicesByCategory(){
      axios.get(`http://localhost:8000/get_service/${this.selectedCategory}`)
          .then(response => {
            this.services = response.data
            console.log('Список услуг: ', this.services)
          })
          .catch(error => {
            console.error('Ошибка загрузки услуг: ', error.message)
          })
    },

    //удаление сервиса из ордера
    deleteFromAdded(serviceId) {
      console.log('удаляем сервис')
      const index = this.addedServices.findIndex((service) => service.id === serviceId)
      if (index !== -1){
        this.addedServices.splice(index, 1);
      }
      console.log(this.addedServices)
    },

    //добавление сервиса в ордер
    addServiceToOrder(service) {
      console.log('Добавление сервиса в ордер: ', service)
      const isServiceAlreadyAdded = this.addedServices.some(addedService => addedService.id === service.id)
      if (!isServiceAlreadyAdded) {
        this.addedServices.push(service)
        console.log('Добавленные сервисы: ', this.addedServices)
      } else {alert('Такой сервис уже есть в ордере!')}
    },

    //сохранение ордера
    saveOrder() {
      console.log('создаем ордер')
      const totalAmount = this.totalAddedServicesPrice
      const orderData = {
        clientId: this.selectedClient,
        specializationId: this.selectedSpecialization,
        totalAmount: totalAmount,
        materials: this.materials,
        comments: this.comments,
        servicesId: this.addedServices.map(service => service.id)
      }
      console.log('данные для сохранения: ', orderData)
      const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
      console.log('сsrfToken: ', csrfToken)
      axios.post('http://localhost:8000/save_order', orderData,{
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
          }
      })
          .then(response => {
            console.log(response.data.message)
          })
          .catch(error => {
            console.error('Ошибка сохранения ордера: ', error)
          })
    }
  },

  mounted() {
    axios.get('http://localhost:8000/getSpecialization')
        .then(response => {
          this.specializations = response.data
          console.log('список специализаций: ', this.specializations )
        })
        .catch(eError => {
          console.error(eError.message)
        })
  }
}

</script>

<template>
  <div>
    <div>
      <div class="d-flex">
        <b-form-select v-model="selectedSpecialization" @change="handleSpecializationChange" class="w-auto"  >
          <b-form-select-option v-for="specialization in specializations"
                                :key="specialization.id" :value="specialization.id" >
            {{ specialization.specializationName }}
          </b-form-select-option>
        </b-form-select>

        <b-form-select v-model="selectedClient" class="w-auto" @change="handleClientChange" >
          <b-form-select-option v-for="client in clients"
                                :key="client.id" :value="client.id">
            {{client.name}} - {{client.phone}}
          </b-form-select-option>
        </b-form-select>
      </div>

      <div>
        <b-container>
          <b-row>
            <b-col md="6">
              <b-form-select v-model="selectedCategory" @change="handleCategoriesChange" class="w-auto" >
                <b-form-select-option v-for="category in categories"
                                      :key="category.id" :value="category.id">
                  {{category.category_name}}
                </b-form-select-option>
              </b-form-select>
            </b-col>
            <b-col md="6">
              <div>
                Сумма: {{ totalAddedServicesPrice }}
              </div>
            </b-col>
          </b-row>
        </b-container>
      </div>
    </div>


    <div id="orderDiv" class="d-flex flex-column" style="min-height: 75vh">
      <b-tabs order switch>
        <b-tab title="Выбор услуг" href="#serviceChoice">
          <br>
          <div id="serviceChoice">
            <b-list-group>
              <b-list-group-item id="serviceItem" v-for="service in services" :key="service.id" @click="addServiceToOrder(service)">
                <div class="d-flex justify-content-between align-items-center">
                  <div>{{service.service }}</div>
                  <div>{{service.price}}</div>
                </div>
              </b-list-group-item>
            </b-list-group>
          </div>
        </b-tab>

        <b-tab :title="tabTitleCounter" href="#addedServices">
          <br>
          <div id="addedServices">
            <b-list-group-item v-for="service in addedServices" :key="service.id" >
              <div class="d-flex justify-content-between align-items-center">
                <div>{{service.service}}</div>
                <div>{{service.price}}</div>
                <b-button @click="deleteFromAdded(service.id)" variant="danger">
                  <BIconTrash icon="trash"></BIconTrash>
                </b-button>
              </div>
            </b-list-group-item>

            <br>

            <b-form-textarea id="materialsTextArea"
                             v-model="materials"
                             placeholder="нет материалов"
                             rows="1"
                             max-rows="6"
            ></b-form-textarea>

            <br>

            <b-form-textarea id="commentsTextArea"
                             v-model="comments"
                             placeholder="комментарии"
                             rows="1"
                             max-rows="6"
            ></b-form-textarea>

          </div>
        </b-tab>
      </b-tabs>

    </div>

    <b-container class="fixed-bottom">
      <b-row class="justify-content-end">
        <b-col md="auto">
          <b-button @click="saveOrder()" variant="primary" class="m-3" >
            сохранить ордер
          </b-button>
        </b-col>
      </b-row>
    </b-container>

</div>
</template>

<style scoped>
#serviceItem:hover {
  background-color: #6c757d;
  color: white;
  cursor: pointer;
}
#serviceItem:active {
  background-color: red;
  color: white;
}
</style>