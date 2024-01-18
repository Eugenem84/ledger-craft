<script>
import axios from "axios";

export default {
  props: ['selectedSpecialization'],
  data(){
    return {
      isVisible: false,
      newCategoryNameInput: '',
      specializationId: ''
    }
  },
  methods: {
    open(selectedSpecialization){
      this.isVisible = true
      this.specializationId = selectedSpecialization
    },

    createNewCategory(){
      const requestData = {
        category_name: this.newCategoryNameInput,
        specialization_id: this.specializationId,
      }
      console.log(this.selectedSpecialization)
      axios.post('http://localhost:8000/api/add_category', requestData)
          .then(response => {
            console.log(response.data.message)
            this.$emit('category-added')
            this.newCategoryNameInput= ''
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
    <b-modal title="создание новой категории" :visible="isVisible" @hidden="closeModal"  hide-footer>
      <b-form @submit.stop.prevent="createNewCategory">
        <b-input id="newCategoryNameInput"
                 v-model="newCategoryNameInput"
                 placeholder="введите название категории"
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