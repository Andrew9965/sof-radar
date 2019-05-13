<template>
        <div style="margin-bottom: 50px">
            <div class="filter__header" style="margin-bottom: 30px">
                <div class="_title"><i class="fas fa-list-ul"></i> Product list <span v-if="items.total!=undefined && items.data.length">({{items.total}})</span></div>
            </div>

            <div v-if="!wait">
                <span v-if="items.data.length">
                    <div class="review-item review-item--m_b" v-for="(item, index) in items.data" :key="index">
                        <div class="review-item__inner">
                            <div class="review-item__header">
                                <div class="review-item__header-company">
                                    <div class="_logo"><a :href="`/app/${item.slug}`"><img :src="item.logo" :alt="item.title" width="53"></a></div>
                                    <div class="_info">
                                        <div class="_title"><a :href="`/app/${item.slug}`">{{item.title}}</a></div>
                                    </div>
                                </div>
                                <div class="review-item__header-rating">
                                    <div class="rating">
                                        <div class="rating__inner">
                                            <div class="rating__info">
                                                <div class="rating__label ">Average rating:</div>

                                                <div class="rating__star ">
                                                    <div class="rating-star ">
                                                        <div class="rating-star__inner">
                                                            <div class="rating-star__empty"></div>
                                                            <div class="rating-star__fill" :style="`width: ${(100/5)*calcRaitTotal(item)}%`"></div>
                                                        </div>
                                                    </div>


                                                    <div class="rating__comment">
                                                        <div class="icon-comment">
                                                            <i></i><a :href="`/app/${item.slug}/reviews`">{{item.review_count}}</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="rating__total">
                                                <div :class="`rating-total__value ${item.color}`">
                                                    <span class="_label">{{splitTotal(item)[0]}}</span>
                                                    <span v-if="splitTotal(item)[1]!=undefined">{{splitTotal(item)[1]}}</span>/5
                                                </div>
                                            </div>
                                        </div>
                                    </div>



                                </div>
                            </div>

                            <div class="review-item__info">
                                <div class="_info">
                                    <div class="_title">
                                        <a :href="`http://soft.laraman.ru/category/${item.category_1.slug}`">{{item.category_1.title}}</a>
                                    </div>
                                    <div class="_size">Business size: <span>{{item.details.business_size.join(', ')}}</span></div>
                                </div>
                                <div class="_action">
                                    <a class="_btn btn btn-purple btn-big-w" @click="$router.push({name: 'edit_product', params: {slug: item.slug}})">Edit</a>
                                </div>
                            </div>

                            <div class="review-item__body">
                                <div class="_inner">
                                    <div class="_item">
                                        <div class="_desc" v-html="item.short_description"></div>
                                    </div>
                                </div>
                                <div class="_action">
                                    <a :href="`/app/${item.slug}`" class="_btn btn btn-border">Open</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </span>

                <div v-else style="text-align: center;margin: 30px;">
                    <i class="fas fa-exclamation-triangle" style="font-size: 20vh;"></i>
                    <h1>No products available.</h1>
                </div>
            </div>

            <div v-else>
                <img src="spinner.gif" style="margin: 0 auto; display: flex;"/>
            </div>
        </div>
</template>

<script>
    export default {
        data () {
            return {
                user: [],
                wait: true,
                items: { data: [], current_page: 0 },
            }
        },
        methods: {
            getData ($page = 1) {
                this.wait = true
                this.axios.post('get_products', {page: $page}).then((responce) => {
                    this.items = responce.data
                    this.wait = false
                }).catch((err) => {
                    toastr.error(err.response.data.message ? err.response.data.message : err.message)
                })
            },
            calcRaitTotal (item) {
                return (Number(item.easy_of_use)+Number(item.functionality)+Number(item.product_quality)+Number(item.customer_support)+Number(item.value_for_money))/5;
            },
            splitTotal (item) {
                return String(this.calcRaitTotal(item)).split('.')
            }
        },
        mounted () {
            this.user = user
            this.getData()
        }
    }
</script>