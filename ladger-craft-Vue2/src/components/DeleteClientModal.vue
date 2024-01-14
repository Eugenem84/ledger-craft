<script>
import axios from "axios";

export default {
  data(){
    return {
      isVisible: false,
      clientId: ''
    }
  },
  methods: {
    open(clientId){
      this.clientId = clientId
      this.isVisible = true
    },

    deleteClient() {
      const requestData = {
        clientId: this.clientId,
      }
      console.log('удаление клиента с Id: ', requestData)
      axios.post('http://localhost:8000/api/delete_client', requestData)
          .then(response => {
            console.log(response.data.message)
            this.$emit('client-deleted')
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
<div>

  <b-modal title="удаление клиента" :visible="isVisible" @hidden="closeModal" hide-footer>
    <b-form @submit.stop.prevent="deleteClient">
      Удалить клиента?
      <b-button @click="closeModal">отмена</b-button>
      <b-button type="submit" variant="primary">удалить</b-button>
    </b-form>

  </b-modal>
</div>
</template>

<style scoped>

</style>