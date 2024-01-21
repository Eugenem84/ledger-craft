<script>
import axios from "axios";

export default {
  components: {
    //
  },
  data(){
    return {
      orders: [],
      clients: [],
      specializations: [],

      orderDetails: '',

      isOrderOpened: false,
      isOrdersListVisible: true,
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
      console.log('открытие ордера с id: ', orderId)
      this.isOrderOpened = true
      this.isOrdersListVisible = false
      axios.get(`http://localhost:8000/api/order/${orderId}`)
          .then(response => {
          this.orderDetails = response.data
          })
      console.log('детали ордера', this.orderDetails)
    },
    closeOrderDetailsDiv(){
      this.isOrderOpened = false
      this.isOrdersListVisible = true
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
  mounted() {
    this.loadSpecializations()
    this.loadAllClients()
    this.loadAllOrders()
  }
}
</script>

<template>
<div>
  <div id="openOrderDiv" v-if="isOrderOpened">
    <b-container >
      <b-row>
        <div class="col-md-6">
          номер ордера: {{ this.orderDetails.id }}
        </div>
        <div class="col-md-6">
          клиент: {{ this.orderDetails.client_id }}
        </div>
        <b-col md="12">
          какая то хрень
        </b-col>
        <b-col>
          еще хрень
        </b-col>
      </b-row>
      <b-row>
        <b-row>
          и еще
        </b-row>
      </b-row>

    </b-container>

    <b-container class="fixed-bottom">
      <b-row class="justify-content-end">
        <b-col md="auto">
          <b-button @click="closeOrderDetailsDiv">закрыть</b-button>
        </b-col>
      </b-row>
    </b-container>
  </div>

  <div id="ordersDiv" v-if="isOrdersListVisible">
    <b-list-group>
      <b-list-group-item id="orderItem" v-for="order in orders" :key="order.id" @click="showOrder(order.id)">
        <div class="d-flex justify-content-between align-items-center">
          <div> {{getSpecializationName(order.specialization_id)}} | "{{ getClientName(order.client_id) }}" </div>
          <div>{{ order.total_amount }}</div>
        </div>
      </b-list-group-item>
    </b-list-group>
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