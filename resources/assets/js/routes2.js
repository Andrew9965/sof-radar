export default [
    {
        path: '/',
        name: 'statistic',
        component: require('./AdminComponents/StatisticsComponent.vue')
    },
    {
        path: '/product_statistic/:slug',
        name: 'product_statistic',
        component: require('./AdminComponents/ProductStatisticComponent.vue')
    }
];