<script>
import axios from "axios";

export default {
  data() {
    return {
      isVisible: false,
      serviceId: '',
      currentServiceName: '',
      currentServicePrice: '',
    }
  },

  methods: {
    open(serviceId, currentServiceName, currentServicePrice) {
      this.serviceId = serviceId
      this.currentServiceName = currentServiceName
      this.currentServicePrice = currentServicePrice
      this.isVisible = true
    },

    editService() {
      const requestData = {
        id: this.serviceId,
        service: this.currentServiceName,
        price: this.currentServicePrice,
      }
      axios.post('http://localhost:8000/api/edit_service', requestData)
          .then(response => {
            console.log(response.data.message)
            this.$emit('service-edited')
          })
      this.isVisible = false
    },

    closeModal() {
      this.isVisible = false
    }
  }
}
</script>

<template>
<div>
  <b-modal title="редактирование сервиса" :visible="isVisible" @hidden="closeModal" hide-footer>
    <b-form @submit.stop.prevent="editService">
      редактируйте:
      <b-input id="newServiceNameInput" v-model="currentServiceName"></b-input>
      <b-input id="newServicePriceInput" v-model="currentServicePrice"></b-input>
      <b-button @click="closeModal">отмена</b-button>
      <b-button type="submit" variant="primary">сохранить</b-button>
    </b-form>
  </b-modal>
</div>
</template>

<style scoped>

</style>