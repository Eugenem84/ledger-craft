<script>
import axios from "axios";

export default {
  props: ['selectedCategory'],
  data(){
    return {
      isVisible: false,
      newServiceNameInput: '',
      newServicePriceInput: '',
    }
  },
  methods:{
    open(){
      this.isVisible = true
    },

    createNewService(){
      const requestData = {
        service: this.newServiceNameInput,
        price: this.newServicePriceInput,
        category_id: this.selectedCategory,
      }
      axios.post('http://localhost:8000/api/add_service', requestData)
          .then(response => {
            console.log(response.data.message)
            this.$emit('service-added')
          })
      this.isVisible = false
    },
    closeModal(){
      this.isVisible = false
    }
  },
}

</script>

<template>
  <div>
    <b-modal title="создание новой услуги" :visible="isVisible" @hidden="closeModal" hide-footer>
      <b-form @submit.stop.prevent="createNewService">
        <b-input id="newServiceNameInput"
                 v-model="newServiceNameInput"
                 placeholder="введите название услуги"
                 required
        ></b-input>
        <br>
        <b-input id="newServicePriceInput"
                 v-model="newServicePriceInput"
                 placeholder="введите цену"
                 type="number"
                 required
        ></b-input>
        <br>
        <b-button @click="closeModal">отмена</b-button>
        <b-button type="submit" variant="primary" >сохранить</b-button>
      </b-form>
    </b-modal>
  </div>
</template>

<style scoped>

</style>