<template>
    <div class="relative">
        <div class="row">

            <aside class="col-lg-3 aside">
                <div class="filter js-filter-box" :style="`margin-top: ${$mq=='mobile' ? 100 : ($mq=='tablet' ? 167 : 0)}px;`">
                    <div class="filter__box">
                        <form action="">
                            <div class="filter__inner js-custom-scroll">
                                <div class="filter__header">
                                    <div class="_title">Menu</div>
                                </div>
                                <div class="filter__body" style="padding: 0;background-color: #ebedf2;">

                                    <div class="filter__item">
                                        <div class="filter__item-title" style="padding: 20px 0 0 20px;" v-if="user.moderator_id"><i class="fas fa-wallet"></i> Balance {{user.balance == 0 ? '0.00' : user.balance}}$</div>

                                        <ul class="user-menu-container">
                                            <li>
                                                <router-link :to="{name: 'click_through_statistics'}" :class="$route.name=='click_through_statistics' || $route.name=='product_statistic' ? 'active' : ''">
                                                    <i class="fas fa-chart-area"></i> Click-through statistics
                                                </router-link>
                                            </li>
                                            <li>
                                                <router-link :to="{name: 'operations_history'}" :class="$route.name=='operations_history' || $route.name=='status_balance' ? 'active' : ''">
                                                    <i class="fas fa-history"></i> Operations history
                                                </router-link>
                                            </li>
                                            <li>
                                                <router-link :to="{name: 'refill_balance'}" :class="$route.name=='refill_balance' ? 'active' : ''">
                                                    <i class="fas fa-plus-circle"></i> Refill the balance
                                                </router-link>
                                            </li>
                                        </ul>

                                        <div class="filter__item-title" style="padding: 20px 0 0 20px;" v-if="user.moderator_id"><i class="fas fa-box-open"></i> Products</div>

                                        <ul class="user-menu-container" v-if="user.moderator_id">
                                            <li>
                                                <router-link :to="{name: 'products'}" :class="$route.name=='products' || $route.name=='edit_product' ? 'active' : ''">
                                                    <i class="fas fa-list-ul"></i> Product list
                                                </router-link>
                                            </li>
                                            <li>
                                                <router-link :to="{name: 'add_product'}" :class="$route.name=='add_product' ? 'active' : ''">
                                                    <i class="fas fa-plus-square"></i> Add product
                                                </router-link>
                                            </li>
                                        </ul>

                                        <div class="filter__item-title" style="padding: 20px 0 0 20px;"><i class="far fa-user-circle"></i> {{user.name}}</div>

                                        <ul class="user-menu-container">
                                            <li>
                                                <router-link :to="{name: 'profile'}" :class="$route.name=='profile' ? 'active' : ''">
                                                    <i class="far fa-user"></i> Profile
                                                </router-link>
                                            </li>
                                            <li>
                                                <router-link :to="{name: 'reviews'}" :class="$route.name=='reviews' ? 'active' : ''">
                                                    <i class="far fa-comments"></i> Reviews
                                                </router-link>
                                            </li>
                                            <li>
                                                <a @click="logoutConfirm" style="cursor: pointer">
                                                    <i class="fas fa-sign-out-alt"></i> Logout
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </aside>

            <div class="col-lg-9 col-md-12">
                <div class="block-open__filter">
                    <button class="_btn js-open-filter btn btn-big btn-purple"><i></i><span class="_apply">Apply</span><span class="_open">Open menu</span><span class="_close">Close</span></button>
                </div>
                <router-view></router-view>
            </div>
        </div>

        <div class="popup" id="logOut">
            <div class="popup-inner">
                <a href="#" class="popup-close js-close-wnd"></a>

                <div class="popup__title">
                    <span id="popup_title_1" class="popup_titles_my">
                        <div class="_text">Logout?</div>
                    </span>
                </div>
                <form action="/cabinet/logout" method="post">
                    <input type="hidden" name="_token" :value="token" />
                    <div class="popup__container--small">
                        <div class="popup__form-action w245">
                            <button class="btn btn-purple w100 btn-big" type="submit">Yes</button>
                        </div>

                        <div class="popup__form-action w245">
                            <button class="btn btn-purple w100 btn-big js-close-wnd">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'app',
        data () {
            return {
                user: [],
                token: ''
            }
        },
        methods: {
            logout () {
                this.axios.get('logout').then((resposce) => {
                    toastr.success('By!')
                    window.location = '/'
                }).catch((err) => {
                    toastr.error(err.message)
                })
            },
            logoutConfirm () {
                Popups.openById('logOut')
            }
        },
        mounted () {
            if(window.location.hash === '#/_=_') this.$router.push({name: 'profile'})
            this.user = user
            this.token = $('meta[name="csrf-token"]').attr('content')
        }
    }
</script>