<script>
import axios from "axios";

export default {
  props: ['selectedSpecialization'],
  data(){
    return {
      isVisible: false,
      newCategoryNameInput: '',
    }
  },
  methods: {
    open(){
      this.isVisible = true
    },

    createNewCategory(){
      const requestData = {
        category_name: this.newCategoryNameInput,
        specialization_id: this.selectedSpecialization,
      }
      axios.post('http://localhost:8000/api/add_category', requestData)
          .then(response => {
            console.log(response.data.message)
            this.$emit('category-added')
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
    <b-modal title="создание новой категории" :visible="isVisible" @close="closeModal"  hide-footer>
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