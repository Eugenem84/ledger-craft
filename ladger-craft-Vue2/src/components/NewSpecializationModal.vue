<script>
import axios from "axios";

export default {
  data(){
    return {
      isVisible: false,
      newSpecializationNameInput: '',
    }
  },
  methods: {
    open(){
      this.isVisible = true
    },
    createNewSpecialization(){
      const requestsData = {
        specializationName: this.newSpecializationNameInput
      }
      axios.post('http://localhost:8000/api/add_specialization', requestsData)
          .then(response => {
            console.log(response.data.message)
            this.$emit('specialization-added')
          })
      this.isVisible = false
    },
    closeModal() {
      this.isVisible = false
    },
  },
}
</script>

<template>
<div>
  <b-modal title="создание новой специализации" :visible="isVisible" @hidden="closeModal" hide-footer>
    <b-form @submit.stop.prevent="createNewSpecialization">
      <b-input id="newSpecializationNameInput"
               v-model="newSpecializationNameInput"
               placeholder="введите название специализации"
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