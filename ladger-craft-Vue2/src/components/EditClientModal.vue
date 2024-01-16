<script>
import axios from "axios";

export default {
  data(){
    return {
      isVisible: false,
      clientId: '',
      currentClientName: '',
      currentClientPhone: '',
    }
  },
  methods: {
    open(clientId, currentClientName, currentClientPhone){
      this.clientId = clientId
      this.currentClientName = currentClientName
      this.currentClientPhone = currentClientPhone
      this.isVisible = true
    },

    editClient() {
      const requestData = {
        id: this.clientId,
        name: this.currentClientName,
        phone: this.currentClientPhone,
      }
      console.log(requestData)
      axios.post('http://localhost:8000/api/edit_client', requestData)
          .then(response => {
            console.log(response.data.message)
            this.$emit('client-edited')
          })
      this.isVisible = false
    },

    closeModal(){
      this.isVisible = false
    }
  }
}
</script>

<template>
  <b-modal title="редактирование клиента" :visible="isVisible" @hidden="closeModal" hide-footer>
    <b-form @submit.stop.prevent="editClient">
      редактируйте:
      <b-input id="newClientNameInput"
               v-model="currentClientName"
      ></b-input>
      <b-input id="newClientPhoneInput"
               v-model="currentClientPhone"
      ></b-input>
      <b-button @click="closeModal">отмена</b-button>
      <b-button type="submit" variant="primary">сохранить</b-button>

    </b-form>
  </b-modal>

</template>

<style scoped>

</style>