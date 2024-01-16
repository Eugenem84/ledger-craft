<script>
import axios from "axios"
import NewServiceModal from "@/components/NewServiceModal.vue";
import DeleteServiceModal from "@/components/DeleteServiceModal.vue";
import NewClientModal from "@/components/NewClientModal.vue";
import DeleteClientModal from "@/components/DeleteClientModal.vue";
import EditClientModal from "@/components/EditClientModal.vue";
import {BIconTrash} from "bootstrap-vue"
import {BIconPencilSquare} from "bootstrap-vue";
import {BAlert} from "bootstrap-vue";

export default {
  components: {
    BAlert,
    BIconTrash,
    BIconPencilSquare,
    NewServiceModal,
    DeleteServiceModal,
    NewClientModal,
    DeleteClientModal,
    EditClientModal,
  },

  data() {
    return {
      specializations: [],
      clients: [],
      categories: [],
      services: [],

      selectedSpecializations: '',
      selectedClients: '',
      selectedCategory: '',

      isDeleteClientModalOpen: true,
      currentClientId: null,

      alertVisible: false,
      alertVariant: 'success',
      alertMessage: '',
    }
  },

  methods: {
    handleSpecializationChange() {
      this.loadClients()
      this.loadCategories()
    },

    handleCategoryChange(){
      this.loadServicesByCategory()
    },

    handleClientAdded(){
      console.log('клиент добавлен')
      this.loadClients()
      this.showAlert('success', 'клиент добавлен')
    },

    handleClientDeleted(){
      this.loadClients()
      this.showAlert('success', 'клиент удален')
    },

    handleClientEdited(){
      this.loadClients()
      this.showAlert('success', 'клиент изменен')
    },

    handleServiceAdded(){
      this.loadServicesByCategory()
      this.showAlert('success', 'сервис добавлен')
    },

    handleServiceDeleted(){
      this.loadServicesByCategory()
      this.showAlert('success', 'сервис удален')
    },

    openNewSpecializationModal() {
      //
    },

    openNewCategoryModal() {
      //
    },

    openNewServiceModal() {
      //console.log(this.selectedCategory)
      if (this.$refs.newServiceModal) {
        this.$refs.newServiceModal.selectedCategory = this.selectedCategory
        this.$refs.newServiceModal.open()
      } else {
        console.log('модальное окно еще не доступно')
      }
    },

    openDeleteServiceModal(serviceId){
      console.log(serviceId)
      this.$refs.deleteServiceModal.open(serviceId)
    },

    openEditServiceModal(){
      console.log('редактирование сервиса')
    },

    loadClients() {
      axios.get(`http://localhost:8000/api/get_clients/${this.selectedSpecializations}`)
          .then(response => {
            this.clients = response.data
          })
          .catch(error => {
            console.error('ошибка загрузки клиентов: ', error.message)
          })
    },

    loadCategories() {
      axios.get(`http://localhost:8000/api/get_categories/${this.selectedSpecializations}`)
          .then(response => {
            this.categories = response.data
          })
          .catch(error => {
            console.error('Ошибка загрузки категорий: ', error.message)
          })
    },
    loadServicesByCategory() {
      axios.get(`http://localhost:8000/api/get_service/${this.selectedCategory}`)
          .then(response => {
            this.services = response.data
          })
          .catch(error => {
            console.log('ошибка загрузки сервисов', error.message)
          })
    },

    openNewClientModal(specializationId){
      this.$refs.newClientModal.open(specializationId)
    },

    openDeleteClientModal(clientId){
      this.$refs.deleteClientModal.open(clientId)
    },

    openEditClientModal(clientId, currentClientName, currentClientPhone){
      this.$refs.editClientModal.open(clientId, currentClientName, currentClientPhone)
    },

    closeDeleteClientModal(){
      this.currentClientId = null
      this.isDeleteClientModalOpen = false
    },

    editClient(){
      //
    },
    showEditClientsButtons(){
      //
    },
    toggleClientsButtons(client){
      this.clients.forEach((elem) => this.$set(elem, 'isClicked', false))
      client.isClicked = !client.isClicked
    },

    toggleServiceButtons(service){
      this.services.forEach((elem) => this.$set(elem, 'isClicked', false))
      service.isClicked = !service.isClicked
    },

    showAlert(variant, message){
      this.alertVariant = variant
      this.alertMessage = message
      this.alertVisible = true
      setTimeout(() => {
        this.alertVisible = false
      }, 2000)
    },

  },

  mounted() {
    axios.get('http://localhost:8000/api/getSpecialization')
        .then(response => {
          this.specializations = response.data
          console.log(response.data)
        })
        .catch(eError => {
          console.log(eError.message)
        })
  }
}

</script>

<template>
  <div>
    <div class="d-flex">
      <b-form-select v-model="selectedSpecializations" @change="handleSpecializationChange" class="w-auto">
        <b-form-select-option v-for="specialization in specializations"
                              :key="specialization.id" :value="specialization.id">
          {{ specialization.specializationName }}
        </b-form-select-option>
      </b-form-select>
    </div>
    <br>
    <div class="d-flex">
      <b-form-select v-model="selectedCategory" class="w-auto" @change="handleCategoryChange">
        <b-form-select-option v-for="category in categories"
                              :key="category.id" :value="category.id">
          {{ category.category_name }}
        </b-form-select-option>
      </b-form-select>
    </div>
    <div id="editServiceDiv" class="d-flex flex-column" style="min-height: 75vh">
      <b-tabs>
        <b-tab title="услуги" href="serviceChoice">
          <br>
          <div id="serviceChoice">
            <b-list-group>
              <b-list-group-item v-if="selectedCategory" id="serviceItem"
                                 @click="openNewServiceModal"
              >
                <div class="d-flex justify-content-between align-items-center">
                  добавить новую услугу
                </div>
              </b-list-group-item>

              <b-list-group-item id="serviceItem"
                                 v-for="service in services"
                                 :key="service.id"
                                 @click="toggleServiceButtons(service)"
                                 :style="{border: service.isClicked ? '2px solid black' : 'white'}"
              >
                <div class="d-flex justify-content-between align-items-center">
                  <div>{{ service.service }}</div>
                  <div>{{ service.price }}</div>
                </div>
                <div id="servicesEditButtons" v-if="service.isClicked">
                  <b-button @click="openDeleteServiceModal(service.id)" variant="danger">
                    удалить
                    <BIconTrash icon="trash"></BIconTrash>
                  </b-button>
                  <b-button @click="openEditServiceModal(service.id)" variant="primary">
                    редактировать
                    <BIconPencilSquare icon="pencil-square"></BIconPencilSquare>
                  </b-button>
                </div>
              </b-list-group-item>
            </b-list-group>
          </div>
        </b-tab>
        <b-tab title="клиенты" href="clientChoice">
          <br>
          <div id="clientChoice">
            <b-list-group>
              <b-list-group-item id="clientItem"
                                 @click="openNewClientModal"
              >новый клиент</b-list-group-item>

              <b-list-group-item id="clientItem"
                                 v-for="client in clients"
                                 :key="client.id"
                                 @click="toggleClientsButtons(client)"
                                 :style="{border: client.isClicked ? '2px solid black' : 'white'}"
              >
                <div>
                  <div>{{ client.name }}</div>
                  <div>{{ client.phone }}</div>
                </div>
                <div id="clientsEditButtons" v-if="client.isClicked">
                  <b-button @click="openDeleteClientModal(client.id)" variant="danger">
                    удалить
                    <BIconTrash icon="trash"></BIconTrash>
                  </b-button>
                  <b-button @click="openEditClientModal(client.id, client.name, client.phone)" variant="primary">
                    редактировать
                    <BIconPencilSquare icon="pencil-square"></BIconPencilSquare>
                  </b-button>
                </div>
              </b-list-group-item>
            </b-list-group>
          </div>
        </b-tab>
        <br>
      </b-tabs>
    </div>

    <NewClientModal :selected-specialization="selectedSpecializations"
                    ref="newClientModal"
                    @client_added="handleClientAdded"
    />

    <DeleteClientModal ref="deleteClientModal"
                       @client-deleted="handleClientDeleted"
    />

    <EditClientModal ref="editClientModal"
                     @client-edited="handleClientEdited"
    />

    <NewServiceModal :selectedCategory="selectedCategory"
                     ref="newServiceModal"
                     @service-added="handleServiceAdded"
    ></NewServiceModal>

    <DeleteServiceModal ref="deleteServiceModal"
                        @service-deleted="handleServiceDeleted"
    />

    <BAlert v-model="alertVisible" :variant="alertVariant" dismissible fade class="fixed-top">
      {{alertMessage}}
    </BAlert>

  </div>

</template>

<style scoped>

#serviceItem:hover {
  background-color: gray;
  color: white;
  cursor: pointer;
}

#serviceItem:active {
  background-color: red;
  color: white;
}

#clientItem:hover {
  background-color: #6c757d;
  color: white;
  cursor: pointer;
}

#clientItem:active {
  background-color: red;
  color: white;
}
</style>