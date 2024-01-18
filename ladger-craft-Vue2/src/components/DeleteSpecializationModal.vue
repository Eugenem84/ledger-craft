<script>
import axios from "axios";

export default {
  data(){
    return {
      isVisible: false,
      specializationId: '',
    }
  },
  methods: {
    open(specializationId){
      this.specializationId = specializationId
      this.isVisible = true
    },

    deleteSpecialization(){
      const requestData = {
        specializationId: this.specializationId,
      }
      axios.post('http://localhost:8000/api/delete_specialization', requestData)
          .then(response => {
            this.$emit('specialization-deleted')
            console.log(response.data.message)
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
  <b-modal title="удаление специализации" :visible="isVisible" @hidden="closeModal" hide-footer>
    <b-form @submit.stop.prevent="deleteSpecialization">
      Удалить специализацию?
      <b-button @click="closeModal">отмена</b-button>
      <b-button type="submit" variant="primary">удалить</b-button>
    </b-form>
  </b-modal>

</template>

<style scoped>

</style>