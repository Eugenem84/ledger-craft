<script>
import axios from "axios";
//import {error} from "@babel/eslint-parser/lib/convert";

export default {
  data(){
    return {
      isVisible: false,
      serviceId: '',
    }
  },
  methods: {
    open(serviceId) {
      this.serviceId = serviceId
      this.isVisible = true
    },

    deleteService() {
      const requestData = {
        serviceId: this.serviceId
      }
      console.log(requestData)
      axios.post('http://localhost:8000/api/delete_service', requestData)
          .then(response => {
            console.log(response.data.message)
            this.$emit('service-deleted')
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

  <b-modal title="удаление сервиса" :visible="isVisible" @hidden="closeModal" hide-footer>
    <b-form @submit.stop.prevent="deleteService">
      Удалить сервис
      <b-button @click="closeModal">отмена</b-button>
      <b-button type="submit" variant="primary">удалить</b-button>
    </b-form>
  </b-modal>

</div>
</template>

<style scoped>

</style>