<template>
    <div style="margin-bottom: 50px">
        <div class="filter__header" style="margin-bottom: 30px">
            <div class="_title"><i class="fas fa-plus-circle"></i> Refill status</div>
        </div>
        <div v-if="!wait" style="text-align: center;">
            <i v-if="data.status == status.STATUS_PENDING" style="color: #339af0;margin: 0 auto;font-size: 100pt;" class="far fa-clock"></i>
            <i v-else-if="data.status == status.STATUS_SUCCESS" style="color: #13bb76;margin: 0 auto;font-size: 100pt;" class="far fa-check-circle"></i>
            <i v-else-if="data.status == status.STATUS_FAILED" style="color: #ed3b59;margin: 0 auto;font-size: 100pt;" class="fas fa-ban"></i>
            <i v-else-if="data.status == status.STATUS_ERROR" style="color: #ffae00;margin: 0 auto;font-size: 100pt;" class="fas fa-exclamation-circle"></i>
            <h1>
                <span v-if="data.type == types.TYPE_REFILL">REFILL</span>
                <span v-else-if="data.type == types.TYPE_PAYOUT">PAYOUT</span>
                <span v-else-if="data.type == types.TYPE_AD">AD</span>
                <span v-else-if="data.type == types.TYPE_REFUND">REFUND</span>

                <span v-if="data.status == status.STATUS_PENDING">PENDING</span>
                <span v-else-if="data.status == status.STATUS_SUCCESS">SUCCESS</span>
                <span v-else-if="data.status == status.STATUS_FAILED">FAILED</span>
                <span v-else-if="data.status == status.STATUS_ERROR">ERROR</span>
            </h1>
        </div>
        <div v-if="!wait" class="container">
            <blockquote>
                <div class="table-content__row">
                    <div class="pull-left">ID:</div>
                    <div class="pull-right">{{data.id}}</div>
                </div>
                <div class="table-content__row">
                    <div class="pull-left">Amount:</div>
                    <div class="pull-right">{{data.amount}} USD</div>
                </div>
                <div class="table-content__row">
                    <div class="pull-left">Status:</div>
                    <div class="pull-right">
                        <span v-if="data.status == status.STATUS_PENDING">PENDING</span>
                        <span v-else-if="data.status == status.STATUS_SUCCESS">SUCCESS</span>
                        <span v-else-if="data.status == status.STATUS_FAILED">FAILED</span>
                        <span v-else-if="data.status == status.STATUS_ERROR">ERROR</span>
                    </div>
                </div>
                <div class="table-content__row">
                    <div class="pull-left">Type:</div>
                    <div class="pull-right">
                        <span v-if="data.type == types.TYPE_REFILL">REFILL</span>
                        <span v-else-if="data.type == types.TYPE_PAYOUT">PAYOUT</span>
                        <span v-else-if="data.type == types.TYPE_AD">AD</span>
                        <span v-else-if="data.type == types.TYPE_REFUND">REFUND</span>
                    </div>
                </div>
                <div class="table-content__row">
                    <div class="pull-left">Date:</div>
                    <div class="pull-right">{{data.created_at}}</div>
                </div>
                <div class="table-content__row" v-if="data.created_at!=data.updated_at">
                    <div class="pull-left">Updated:</div>
                    <div class="pull-right">{{data.updated_at.split(' ')[0] == data.created_at.split(' ')[0] ? data.updated_at.split(' ')[1] : data.updated_at}}</div>
                </div>
            </blockquote>
            <div style="text-align: center;">
                <button class="btn btn-purple w100 btn-big" type="button" @click="$router.push({name: 'operations_history'})"><i class="fas fa-history"></i> Go to operations history</button>
            </div>
        </div>
        <div v-else>
            <img src="spinner.gif" style="margin: 0 auto; display: flex;"/>
        </div>
    </div>
</template>

<script>
    export default {
        data: function() {
            return {
                wait: true,
                data: {},
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

        },
        mounted () {
            if(!this.$route.params.id) this.$router.push({name: 'refill_balance'})
            this.axios.post('get_transaction/'+this.$route.params.id).then((response) => {
                this.data = response.data
                this.wait = false
            }).catch((err) => {
                toastr.error(err.response.data.message ? err.response.data.message : err.message)
                this.$router.push({name: 'refill_balance'})
            })
        }
    }
</script>