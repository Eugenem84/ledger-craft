<script>
import axios from "axios"
import {BIconTrash} from 'bootstrap-vue'
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
    }
  },

  computed: {
    tabTitleCounter() {
      return `добавлено услуг: ${this.addedServices.length}`
    }
  },

  methods: {

    handleSpecializationChange(){
      this.loadClients()
      this.loadCategories()
      console.log('выбрана специализация: ', this.selectedSpecialization)
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

        <b-form-select v-model="selectedClient" class="w-auto"  >
          <b-form-select-option v-for="client in clients"
                                :key="client.id" :value="client.id">
            {{client.name}} - {{client.phone}}
          </b-form-select-option>
        </b-form-select>
      </div>

      <b-form-select v-model="selectedCategory" @change="handleCategoriesChange" class="w-auto" >
        <b-form-select-option v-for="category in categories"
                              :key="category.id" :value="category.id">
            {{category.category_name}}
        </b-form-select-option>
      </b-form-select>

    </div>
    <div>
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
          </div>
        </b-tab>
      </b-tabs>
    </div>
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