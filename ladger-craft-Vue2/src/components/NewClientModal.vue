<script>
import axios from "axios";

export default {
  props: ['selectedSpecialization'],
  data(){
    return {
      isVisible: false,
      newClientNameInput: '',
      newClientPhoneInput: '',
    }
  },
  methods: {
    open(){
      this.isVisible = true
    },

    createNewClient(){
      const requestData = {
        name: this.newClientNameInput,
        phone: this.newClientPhoneInput,
        specialization_id: this.selectedSpecialization,
      }
      axios.post('http://localhost:8000/api/add_client', requestData)
          .then(response => {
            console.log(response.data.message)
            this.$emit('client_added')
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
    <b-modal title="создание нового клиента" :visible="isVisible" hide-footer>
      <b-form @submit.stop.prevent="createNewClient">
        <b-input id="newClientNameInput"
                 v-model="newClientNameInput"
                 placeholder="введите имя клиентя"
                 required
        ></b-input>
        <br>
        <b-input id="newClientPhoneInput"
                 v-model="newClientPhoneInput"
                 placeholder="введите телефон"
                 required
        ></b-input>
        <br>
        <b-button @click="closeModal">отмена</b-button>
        <b-button type="submit" variant="primary">сохранить</b-button>
      </b-form>
    </b-modal>
  </div>

</template>

<style scoped>

</style>