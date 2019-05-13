<template>
    <div>
        <div v-show="!wait">
            <range-calendar-2 style="float: right" :click="dateCh"></range-calendar-2>
            <div style="clear: both"></div>
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
        props: {
            slug: {
                type: String,
                required: true
            },
            date: {
                type: Object
            }
        },
        data () {
            return {
                b_date: this.date,
                user: [],
                prod: {},
                wait: true,
                columns: [
                    { label: 'Name', field: 'name' },
                    { label: 'Value', field: 'value' }
                ]
            }
        },
        watch: {
            slug (a) {
                this.getProductInfo()
            }
        },
        methods: {
            getProductInfo () {
                this.wait = true
                if(this.slug && this.slug!='') {
                    axios.get('get_product', {params: {slug: this.slug, resource:true, date: this.b_date}}).then((response) => {
                        this.prod = response.data.data
                        this.wait = false
                    }).catch((err) => {
                        toastr.error(err.response.data.message ? err.response.data.message : err.message)
                        this.wait = false
                    })
                }
            },
            dateCh (date) {
                this.b_date = date
                this.getProductInfo()
            }
        },
        mounted () {
            this.getProductInfo()
        }
    }
</script>