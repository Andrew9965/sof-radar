<template>
    <div class="relative">
        <div class="row">

            <aside class="col-lg-3 aside">
                <div class="filter js-filter-box">
                    <div class="filter__box">
                        <form action="">
                            <div class="filter__inner js-custom-scroll">
                                <div class="filter__header">
                                    <div class="_title"><i class="far fa-user-circle"></i> {{user.name}}</div>
                                </div>
                                <div class="filter__body" style="padding: 0;">

                                    <div class="filter__item">
                                        <div class="filter__item-title" style="padding: 20px 0 0 20px;"><i class="fas fa-box-open"></i> Products</div>

                                        <ul class="user-menu-container">
                                            <li @click="goTo">
                                                    <a href="#/product_list" :class="hasSegment('product_list') ? 'active' : ''">
                                                    <i class="fas fa-list-ul"></i> Product list
                                                </a>
                                            </li>
                                            <li @click="goTo">
                                                <a href="#/add_product" :class="hasSegment('add_product') ? 'active' : ''">
                                                    <i class="fas fa-plus-square"></i> Add product
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <!--<div class="filter__action">-->
                                        <!--<button class="btn btn-apply btn-purple btn-small w100"><i></i>Save</button>-->
                                    <!--</div>-->
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </aside>

            <div class="col-lg-9 col-md-12">

            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data () {
            return {
                user: [],
            }
        },
        methods: {
            hasSegment ($name) {
                return false
            },
            goTo (a) {
                return false
            }
        },
        mounted () {
            this.user = user
        }
    }
</script>