<script>
import axios from "axios"
import DeleteClientModal from "@/components/DeleteClientModal.vue";
import {BIconTrash} from "bootstrap-vue"
import {BIconPencilSquare} from "bootstrap-vue";
import {BAlert} from "bootstrap-vue";

export default {
  components: {
    BAlert,
    BIconTrash,
    BIconPencilSquare,
    DeleteClientModal,
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

    handleClientDeleted(){
      this.loadClients()
      this.showAlert('success', 'клиент удален')
    },

    openNewSpecializationModal() {
      //
    },

    openNewClientModal() {
      //
    },

    openNewCategoryModal() {
      //
    },

    openNewServiceModal() {
      //
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
    openDeleteClientModal(clientId){
      this.$refs.deleteClientModal.open(clientId)
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
    toggleButtons(client){
      this.clients.forEach((elem) => this.$set(elem, 'isClicked', false))
      client.isClicked = !client.isClicked
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
              <b-list-group-item id="serviceItem" v-for="service in services"
                                 :key="service.id">
                <div class="d-flex justify-content-between align-items-center">
                  <div>{{ service.service }}</div>
                  <div>{{ service.price }}</div>
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
                                 v-for="client in clients"
                                 :key="client.id"
                                 @click="toggleButtons(client)"
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
                  <b-button @click="editClient(client.id)" variant="primary">
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

    <DeleteClientModal ref="deleteClientModal" @client-deleted="handleClientDeleted"/>

    <BAlert v-model="alertVisible" :variant="alertVariant" dismissible fade class="fixed-top">
      {{alertMessage}}
    </BAlert>

  </div>

</template>

<style scoped>
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