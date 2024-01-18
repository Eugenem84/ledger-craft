<script>
import axios from "axios";

export default {
  data(){
    return {
      isVisible: false,
      categoryId: ''
    }
  },

  methods: {
    open(categoryId){
      this.categoryId = categoryId
      this.isVisible = true
    },

    deleteCategory(){
      const requestData = {
        categoryId: this.categoryId

      }
      console.log(requestData)
      axios.post('http://localhost:8000/api/delete_category', requestData)
          .then(response => {
            this.$emit('category-deleted')
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

  <b-modal title="удаление категории" :visible="isVisible" @hidden="closeModal" hide-footer>
    <b-form @submit.stop.prevent="deleteCategory">
      Удалить категорию?
      <b-button @click="closeModal">отмена</b-button>
      <b-button type="submit" variant="primary">удалить</b-button>
    </b-form>
  </b-modal>

</template>

<style scoped>

</style>