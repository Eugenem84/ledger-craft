<script>
import axios from "axios";

export default {
  data(){
    return {
      isVisible: false,
      categoryId: '',
      currentCategoryName: '',
    }
  },

  methods: {
    open(categoryId, currentCategoryName){
      console.log(categoryId)
      this.categoryId = categoryId
      this.currentCategoryName = currentCategoryName
      this.isVisible = true
    },

    editCategory(){
      const requestData = {
        id: this.categoryId,
        category_name: this.currentCategoryName,
      }
      //console.log(requestData)
      axios.post('http://localhost:8000/api/edit_category', requestData)
          .then(response => {
            console.log(response.data.message)
            this.$emit('category-edited')
          })
      this.isVisible = false
    },

    closModal(){
      this.isVisible = false
    }
  }
}
</script>

<template>
<b-modal title="редактирование категории" :visible="isVisible" @hidden="closModal" hide-footer>
  <b-form @submit.stop.prevent="editCategory">
    редактируйте:
    <b-input id="newCategoryNameInput"
             v-model="currentCategoryName"
    ></b-input>
    <b-button @click="closModal">отмена</b-button>
    <b-button type="submit" variant="primary">сохранить</b-button>
  </b-form>
</b-modal>
</template>

<style scoped>

</style>