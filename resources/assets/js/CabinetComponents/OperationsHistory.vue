<template>
    <div style="margin-bottom: 50px">
        <div class="filter__header" style="margin-bottom: 30px">
            <div class="_title"><i class="fas fa-history"></i> Operations history</div>
        </div>

        <div v-if="!wait" style="margin: 20px;">
            <span v-if="items.data.length">
                <div v-for="(item, index) in items.data" :key="item.id" class="table-content__row">
                    <router-link :to="{name: 'status_balance', params: {id: item.id}}">
                    <div class="pull-left">
                        <i v-if="item.status == status.STATUS_PENDING" style="color: #339af0;" class="far fa-clock"></i>
                        <i v-else-if="item.status == status.STATUS_SUCCESS" style="color: #13bb76;" class="far fa-check-circle"></i>
                        <i v-else-if="item.status == status.STATUS_FAILED" style="color: #ed3b59;" class="fas fa-ban"></i>
                        <i v-else-if="item.status == status.STATUS_ERROR" style="color: #ffae00;" class="fas fa-exclamation-circle"></i>
                        <span v-if="item.type == types.TYPE_REFILL">REFILL</span>
                        <span v-else-if="item.type == types.TYPE_PAYOUT">PAYOUT</span>
                        <span v-else-if="item.type == types.TYPE_AD">AD</span>
                        <span v-else-if="item.type == types.TYPE_REFUND">REFUND</span>
                        <span v-if="item.status == status.STATUS_PENDING">PENDING</span>
                        <span v-else-if="item.status == status.STATUS_SUCCESS">SUCCESS</span>
                        <span v-else-if="item.status == status.STATUS_FAILED">FAILED</span>
                        <span v-else-if="item.status == status.STATUS_ERROR">ERROR</span>
                    </div>
                    <div class="pull-left">&nbsp;({{item.amount}} USD)</div>

                    <div class="pull-right" v-if="$mq=='desktop' || $mq=='laptop'">
                        <i class="fas fa-info-circle"></i>
                    </div>
                    <div class="pull-right" v-if="$mq=='desktop' || $mq=='laptop'">{{item.created_at}}&nbsp;</div>

                    </router-link>
                </div>

                <div v-if="items.last_page!=undefined && items.last_page!=1">
                    <div class="pagination" style="margin-top: 50px">
                        <div class="pagination__inner">


                            <a class="_item all" @click="getData(1)" style="cursor: pointer" v-if="items.current_page!=1 && items.current_page!=2">1</a>

                            <span class="_item dots" v-if="items.current_page!=1 && items.current_page!=2">...</span>
                            <a v-if="items.prev_page_url" @click="getData(items.current_page-1)" style="cursor: pointer" class="_item arrow arrow-left"><i></i></a>

                            <div class="_item current">{{items.current_page}}</div>

                            <a v-if="items.current_page!=items.last_page" @click="getData(items.current_page+1)" style="cursor: pointer" class="_item arrow arrow-right"><i></i></a>
                            <span class="_item dots" v-if="items.current_page != items.last_page">...</span>

                            <a class="_item all" @click="getData(items.last_page)" style="cursor: pointer" v-if="items.current_page != items.last_page">{{items.last_page}}</a>
                        </div>
                    </div>
                </div>
            </span>

            <div v-else style="text-align: center;margin: 30px;">
                <i class="fas fa-exclamation-triangle" style="font-size: 20vh;"></i>
                <h1>No history available.</h1>
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
                items: { data: [], current_page: 0 },
                wait: true,
                status: {
                    STATUS_PENDING: 0,
                    STATUS_SUCCESS: 1,
                    STATUS_FAILED: 2,
                    STATUS_ERROR: 3
                },
                types: {
                    TYPE_REFILL: 1,
                    TYPE_PAYOUT: 2,
                    TYPE_AD: 3,
                    TYPE_REFUND: 4
                }
            }
        },
        methods: {
            getData ($page = 1) {
                this.axios.post('get_transactions', {page: $page}).then((response) => {
                    this.items = response.data
                    this.wait = false
                }).catch((err) => {
                    toastr.error(err.response.data.message ? err.response.data.message : err.message)
                    this.wait = true
                })
            }
        },
        mounted () {
            this.user = user
            this.getData()
        }
    }
</script>