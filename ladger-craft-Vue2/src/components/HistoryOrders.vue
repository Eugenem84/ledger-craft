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
    loadClients(){
      axios.get('http://localhost:8000/api/get_all_clients')
          .then(response => {
            this.clients = response.data
          })
          .catch(err => {
            console.error(err.message)
          })
    },
    showOrder(){
      //
    },
    getClientName(clientId){
      const client = this.clients.find((client) => client.id === clientId)
      return client ? client.name : 'неизвестный клиент'
    },
  },
  mounted() {
    this.loadClients()
    this.loadAllOrders()
  }
}
</script>

<template>
  <div id="ordersDiv">
    <b-list-group>
      <b-list-group-item id="orderItem" v-for="order in orders" :key="order.id" @click="showOrder(order.id)">
        <div class="d-flex justify-content-between align-items-center">
          <div>{{ getClientName(order.client_id) }}</div>
          <div>{{ order.total_amount }}</div>
        </div>
      </b-list-group-item>
    </b-list-group>
  </div>
</template>

<style scoped>

</style>