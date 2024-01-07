import { createRouter, createWebHistory} from "vue-router";
import OrderMake from "@/components/OrderMake.vue";
import HistoryOrders from "@/components/HistoryOrders.vue";
import StatisticOrders from "@/components/StatisticOrders.vue";

const routes = [
    {path: '/order-make', component:OrderMake },
    {path: '/history-orders', component: HistoryOrders},
    {path: '/statistic-orders', component: StatisticOrders},
];

const router = createRouter({
    history: createWebHistory(),
    routes,
})

export default router