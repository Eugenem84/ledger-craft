<script>
import axios from "axios";
//import OrderMake from "@/components/OrderMake.vue";
import EditOrder from "@/components/EditOrder.vue";

export default {
  components: {
    EditOrder,
    //OrderMake
    //
  },
  data(){
    return {
      orders: [],
      clients: [],
      specializations: [],
      services:[],

      selectedOrder: '',

      orderDetails: '',

      isOrderOpened: false,
      isOrdersListVisible: true,
      isEditOrderDivVisible: false,
    }
  },
  methods: {
    loadAllOrders(){
      axios.get('http://localhost:8000/api/get_all_orders')
          .then(response => {
            this.orders = response.data
            console.log(response.data)
          })
          .catch(err => {
            console.error(err.message)
          })
    },
    loadAllClients(){
      axios.get('http://localhost:8000/api/get_all_clients')
          .then(response => {
            this.clients = response.data
          })
          .catch(err => {
            console.error(err.message)
          })
    },
    loadSpecializations() {
      axios.get('http://localhost:8000/api/get_all_specializations')
          .then(response => {
            this.specializations = response.data
          })
    },

    showOrder(orderId){
      this.selectedOrder = this.orders.find(order => order.id === orderId)
      console.log('открытие ордера с id: ', orderId)
      this.isOrderOpened = true
      this.isOrdersListVisible = false
      axios.get(`http://localhost:8000/api/get_services/${orderId}`)
          .then(response => {
            this.services = response.data
          }).catch(err => {
            console.error(err.message)
      })
    },
    closeOrderDetailsDiv(){
      this.isOrderOpened = false
      this.isOrdersListVisible = true
    },
    openEditOrder(){
      this.isOrderOpened = false
      this.isEditOrderDivVisible = true
    },
    closeEditOrderDiv(){
      this.isOrderOpened = true
      this.isEditOrderDivVisible = false
    },

    getSpecializationName(specializationId){
      const specialization = this.specializations.find((specialization) => specialization.id === specializationId)
      return specialization ? specialization.specializationName : 'неизвестная специализация'
    },
    getClientName(clientId){
      const client = this.clients.find((client) => client.id === clientId)
      return client ? client.name : 'неизвестный клиент'
    },
    getOrderDetails(){
      //
    },
  },

  filters: {
    formatData(datetime){
      const options = { year: 'numeric', month: 'long', day: 'numeric',}
      return new Date(datetime).toLocaleString('en-US', options)
    }
  },

  mounted() {
    this.loadAllOrders()
  }
}
</script>

<template>
<div>
  <div id="openOrderDiv" v-if="isOrderOpened">
    <b-container >
      <b-row>
        <div class="col-md-4">
          номер ордера: <br>
          {{ this.selectedOrder.id }}
        </div>
        <div class="col-md-4">
          клиент: <br>
          {{ this.selectedOrder.client_name }}
        </div>
        <div class="col-md-4">
          специализация: <br>
          {{ this.selectedOrder.specialization_name }}
        </div>
        <div class="col-md-4">
          дата: <br>
          {{ this.selectedOrder.created_at | formatData }}
        </div>

      </b-row>

    </b-container>

    <b-container>
      <b-list-group>
        <b-list-group-item id="serviceItem" v-for="service in services" :key="service.id">
          <div class="d-flex justify-content-between align-items-center">
            <div>{{ service.service }}</div>
            <div>{{ service.price }}</div>
          </div>
        </b-list-group-item>
      </b-list-group>
    </b-container>
    <br>
    <b-container>
      <b-form-textarea id="materialsTextArea"
                       v-model="this.selectedOrder.materials"
                       placeholder="нет материалов"
                       rows="1"
                       max-rows="6"
                       readonly
      ></b-form-textarea>

      <br>

      <b-form-textarea id="commentsTextArea"
                       v-model="this.selectedOrder.comments"
                       placeholder="нет комментарии"
                       rows="1"
                       max-rows="6"
                       readonly
      ></b-form-textarea>
    </b-container>

    <b-container class="fixed-bottom">
      <b-row class="justify-content-end">
        <b-col md="auto">
          <b-button @click="closeOrderDetailsDiv">закрыть</b-button>
          <b-button @click="openEditOrder">редактировать</b-button>
        </b-col>
      </b-row>
    </b-container>
  </div>

  <div id="ordersDiv" v-if="isOrdersListVisible">
    <b-list-group>
      <b-list-group-item id="orderItem" v-for="order in orders" :key="order.id" @click="showOrder(order.id)">
        <div class="d-flex justify-content-between align-items-center">
          <div> {{ order.created_at | formatData }}</div>
          <div> {{ order.specialization_name }} | "{{ order.client_name }}" </div>
          <div>{{ order.total_amount }}</div>
        </div>
      </b-list-group-item>
    </b-list-group>
  </div>

  <div id="editOrderDiv" v-if="isEditOrderDivVisible">
    редактор ордера

    <EditOrder :orderToEdit="selectedOrder" :already-added-services="services"/>

    <b-button @click="closeEditOrderDiv">отмена</b-button>
  </div>

</div>
</template>

<style>

#orderItem:hover {
  background-color: #6c757d;
  color: white;
  cursor: pointer;
}

#orderItem:active {
  background-color: red;
  color: white;
}

</style>