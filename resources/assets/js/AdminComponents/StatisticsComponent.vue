<template xmlns:v-bind="">
    <div style="margin-bottom: 50px">

        <div class="datepicker-trigger">
            <button class="btn btn-success" id="datepicker-trigger">
                <i class="far fa-calendar-alt"></i> {{ date.start==date.end ? (date.start == now ? 'Statistics for today' : `Statistics for ${date.start}`) : `Statistics for ${date.start} through ${date.end}` }}
            </button>

            <AirbnbStyleDatepicker
                    :trigger-element-id="'datepicker-trigger'"
                    :mode="'range'"
                    :fullscreen-mobile="true"
                    :date-one="date.start"
                    :date-two="date.end"

                    @date-one-selected="val => { date.start = val }"
                    @date-two-selected="val => { date.end = val }"
                    @apply="getData"
            />
        </div>

        <div v-if="!wait">
            <div v-if="data.length" style="min-height: 300px">
                <vue-frappe
                        ref="charte"
                        id="test"
                        :labels="labels"
                        title=""
                        :height="300"
                        :colors="['purple', '#ffa3ef', 'light-blue']"
                        areaFill
                        isNavigable
                        :yRegions="[{ label: 'Region', start: 0, end: 50000 }]"
                        :dataSets="this.data"
                        :tooltipOptions="{formatTooltipY: d => d + ' Clicks'}"
                        :events="{'data-select': selectDate, click: getEvents}"
                ></vue-frappe>

                <div class="filter__header" style="margin-bottom: 30px" v-if="selected">
                    <div class="_title"><i class="fas fa-chart-line"></i> {{ selected == now2 ? 'Statistics for today' : `Statistics for ${selected}` }}</div>
                </div>

                <div v-if="!waitDetail">
                    <vue-good-table
                            title="Statistics"
                            :columns="columns"
                            :rows="rows"
                            :paginate="true"
                            @on-row-click="onRowClick"
                            :lineNumbers="true">

                        <!--@on-row-click="onRowClick"-->

                        <template slot="table-row" slot-scope="props">
                            <span v-if="props.column.field == 'hours_clicks'">
                                <sparkline style="width: 100%" height="30" :indicatorStyles="{stroke: '#000'}" :tooltipProps="spTooltipProps3">
                                <sparklineCurve v-if="rows.length"
                                          :data="props.row.hours_clicks"
                                          :limit="24"
                                          :spotlight="array_big(props.row.hours_clicks, true)"
                                          :styles="{stroke: '#54a5ff',fill: '#000'}"
                                          :spotStyles="{fill: '#54a5ff'}"
                                          :spotProps="{size: 2}"
                                          refLineType="avg"
                                          :refLineStyles="{stroke: '#d14',strokeOpacity: 1,strokeDasharray: '2, 2'}"
                                          :textStyles="{fill: '#d14',fontSize: '10'}" />
                                </sparkline>
                                <span style="">Total: {{array_sum(props.row.hours_clicks)}}</span>
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

            <div v-else style="text-align: center;margin: 30px;">
                <i class="fa fa-exclamation-triangle" style="font-size: 20vh;"></i>
                <h1>No statistics available.</h1>
            </div>

        </div>

        <div v-else>
            <img src="/spinner.gif" style="margin: 0 auto; display: flex;"/>
        </div>
    </div>
</template>

<style>
    .asd__wrapper {
        text-align: right;
    }
    .bar {
        cursor: pointer;
    }
</style>

<script>
    import moment from 'moment'

    export default {
        components: {},
        watch: {
          date () {
              this.getData()
          }
        },
        data () {
            return {
                user: [],
                wait: true,
                waitDetail: true,
                date: {start: moment(new Date()).subtract(30, "days").format('YYYY-MM-DD'), end: moment(new Date()).format('YYYY-MM-DD')},
                now: moment(new Date()).format('YYYY-MM-DD'),
                now2: moment(new Date()).format('DD.MM.YYYY'),
                startDate: new Date(),
                endDate: new Date(),
                labels: [],
                data: [],
                selected: false,
                spTooltipProps3: {
                    formatter (val) {
                        let $hour = (val.index + 1)
                        return `${$hour <= 9 ? '0'+$hour : $hour}:00 - <label style="color:${val.color};font-weight:bold;">${val.value}</label>`
                    }
                },
                columns: [
                    {
                        label: 'Product',
                        field: 'title',
                        filterable: true,
                    },
                    {
                        label: 'Total (clicks)',
                        field: 'total',
                        type: 'number',
                        html: false,
                        filterable: true,
                    },
                    {
                        label: 'Clicks for  select period',
                        field: 'select_period',
                        type: 'number',
                        html: false,
                        filterable: true,
                    },
                    {
                        label: 'Clicks per day',
                        field: 'hours_clicks',
                        html: true,
                        filterable: false
                    },
                    {
                        label: 'Total spend ($)',
                        field: 'total_sum',
                        type: 'number',
                        html: false,
                        filterable: true,
                    }
                ],
                rows: [],
            }
        },
        watch: {
            selected ($data) {
                this.getEvents()
            }
        },
        methods: {
            onRowClick (e) {
                this.$router.push({name: 'product_statistic', params: {slug: e.row.slug}})
            },
            getEvents () {
                if (!this.selected){ return this.selected = this.array_last(this.labels) }
                this.waitDetail = true

                this.$get('/get_date_statistic', {selected: this.selected, between: this.date, user_id: this.user.id}, (response) => {
                    this.rows = response.data.data
                    this.waitDetail = false
                }, (response) => {
                    this.waitDetail = false
                })
            },
            selectDate (e) {
                this.selected = e.label
            },
            getData () {
                this.wait = true
                this.axios.get('get_new_statistic', {params: {...this.date, user_id: this.user.id}}).then((response) => {
                    this.wait = false
                    if(response.data.status == 'success') {
                        this.data = response.data.data ? response.data.data : []
                        this.labels = response.data.labels
                        this.getEvents()
                    }else if(response.data.status == 'error'){
                        toastr.error(response.data.message)
                        this.data = []
                        this.labels = []
                    }

                    if(response.data.startDate != undefined) {
                        this.startDate = new Date(response.data.startDate.year, response.data.startDate.month-1, response.data.startDate.day)
                    }
                    if(response.data.endDate != undefined) {
                        this.endDate = new Date(response.data.endDate.year, response.data.endDate.month-1, response.data.endDate.day)
                    }
                }).catch((err) => {
                    toastr.error(err.response.data.message ? err.response.data.message : err.message)
                    this.wait = false
                    this.data = []
                    this.labels = []

                    if(err.response.data.startDate != undefined) {
                        this.startDate = new Date(err.response.data.startDate.year, err.response.data.startDate.month-1, err.response.data.startDate.day)
                    }
                    if(err.response.data.endDate != undefined) {
                        this.endDate = new Date(err.response.data.endDate.year, err.response.data.endDate.month-1, err.response.data.endDate.day)
                    }
                })
            }
        },
        mounted () {
            this.user = user
            this.getData()
        }
    }
</script>