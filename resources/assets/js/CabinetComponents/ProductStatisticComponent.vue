<template>
    <div>
        <div class="filter__header" style="margin-bottom: 30px" @click="getProductInfo()">
            <div class="_title"><i class="fas fa-box-open"></i> {{prod.title != undefined ? 'Product: '+prod.title : 'Wait...'}}</div>
        </div>

        <div v-if="!wait">
            <line-chart v-if="prod.total_clicks != undefined"
                :data="prod.total_clicks"
                :options="{responsive: true, maintainAspectRatio: false, type: 'bar'}"
                :height="200">
            </line-chart>

            <vue-good-table v-if="prod.info != undefined"
                    :title="prod.title"
                    :columns="columns"
                    :rows="prod.info"
                    :groupOptions="{enabled: true}"
                    :lineNumbers="false">

                <template slot="table-row" slot-scope="props">
                    <span v-if="props.column.field == 'hours_clicks'">
                        {{props.formattedRow[props.column.field]}}
                    </span>
                    <span v-else>
                        {{props.formattedRow[props.column.field]}}
                    </span>
                </template>

            </vue-good-table>
        </div>
        <div v-else>
            <img src="/spinner.gif" style="margin: 0 auto; display: flex;"/>
        </div>
    </div>
</template>

<script>
    export default {
        data () {
            return {
                user: [],
                prod: {},
                wait: true,
                columns: [
                    { label: 'Name', field: 'name' },
                    { label: 'Value', field: 'value' }
                ]
            }
        },
        watch: {},
        methods: {
            getProductInfo () {
                this.wait = true
                if(this.$route.params.slug) {
                    this.axios.get('get_product', {params: {slug: this.$route.params.slug, resource:true}}).then((response) => {
                        this.prod = response.data.data
                        this.wait = false
                    }).catch((err) => {
                        toastr.error(err.response.data.message ? err.response.data.message : err.message)
                        this.wait = false
                    })
                }
            }
        },
        mounted () {
            this.user = user
            this.getProductInfo()
            /*setInterval(() => {
                $('.asd__wrapper').css('text-align', 'right')
            }, 300)*/
        }
    }
</script>