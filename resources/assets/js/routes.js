export default [
    {
        path: '/',
        name: 'profile',
        component: require('./CabinetComponents/ProfileComponent.vue')
    },
    {
        path: '/_=_',
        name: 'profile_facebook',
        component: require('./CabinetComponents/ProfileComponent.vue')
    },
    {
        path: '/reviews',
        name: 'reviews',
        component: require('./CabinetComponents/ReviewsComponent.vue')
    },
    {
        path: '/products',
        name: 'products',
        component: require('./CabinetComponents/ProductsComponent.vue')
    },
    {
        path: '/edit_product/:slug',
        name: 'edit_product',
        component: require('./CabinetComponents/AddProductComponent.vue')
    },
    {
        path: '/add_product',
        name: 'add_product',
        component: require('./CabinetComponents/AddProductComponent.vue')
    },
    {
        path: '/click_through_statistics',
        name: 'click_through_statistics',
        component: require('./CabinetComponents/ClickThroughStatisticsComponent.vue')
    },
    {
        path: '/operations_history',
        name: 'operations_history',
        component: require('./CabinetComponents/OperationsHistory.vue')
    },
    {
        path: '/refill_balance',
        name: 'refill_balance',
        component: require('./CabinetComponents/RefillTheBalanceComponent.vue')
    },
    {
        path: '/status_balance/:id',
        name: 'status_balance',
        component: require('./CabinetComponents/StatusBalanceComponent.vue')
    },
    {
        path: '/product_statistic/:slug',
        name: 'product_statistic',
        component: require('./CabinetComponents/ProductStatisticComponent.vue')
    }
];