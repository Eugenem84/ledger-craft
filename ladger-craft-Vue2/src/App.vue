<template>
  <div id="app">

    <header>
      <b-tabs justified>
        <b-tab title="Заказ" active>
          <OrderMake />
        </b-tab>
        <b-tab title="История" active>
          <HistoryOrders />
        </b-tab>
        <b-tab title="Статистика" active>
          <StatisticOrders />
        </b-tab>
      </b-tabs>
      <!--      <h1>L A D G E R - C R A F T</h1>-->
      <!--      <router-link to="/order-make"> Создание ордера </router-link>-->
      <!--      <router-link to="/history-orders"> История работ </router-link>-->
      <!--      <router-link to="/statistic-orders"> Статистика </router-link>-->
      <!--      <b-button variant="primary">bootstrap</b-button>-->
    </header>
    <meta name="csrf-token" :content="csrfToken">
  </div>
</template>

<script>
//import HelloWorld from './components/HelloWorld.vue'
//import TestBootstrap from "@/components/TestBootstrap.vue";
import OrderMake from "@/components/OrderMake.vue";
import HistoryOrders from "@/components/HistoryOrders.vue";
import StatisticOrders from "@/components/StatisticOrders.vue";
export default {
  name: 'App',
  components: {
    StatisticOrders,
    HistoryOrders,
    OrderMake,
    //TestBootstrap
  },
  data(){
    return{
      csrfToken: window.csrfToken
    }
  }
}
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}
</style>
