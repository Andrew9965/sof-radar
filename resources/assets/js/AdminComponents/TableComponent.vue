<template>
    <div>
        <div v-if="!wait">
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

            <!--<button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-default">-->
                <!--Launch Default Modal-->
            <!--</button>-->

            <div class="modal fade" id="modal-default">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">{{modal.title}}</h4>
                        </div>
                        <div class="modal-body">
                            <prod-stat :slug="modal.slug" :date="date"></prod-stat>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->

        </div>
        <div v-else>
            <img src="/spinner.gif" style="margin: 0 auto; display: flex;"/>
        </div>
    </div>
</template>

<script>
    import moment from 'moment'

    export default {
        name: 'day-table',
        data () {
            return {
                modal: {title: '', wait: false, slug: ''},
                date: {start: moment(new Date()).subtract(30, "days").format('YYYY-MM-DD'), end: moment(new Date()).format('YYYY-MM-DD')},
                selected: false,
                wait: true,
                columns: [
                    {
                        label: 'Product',
                        field: 'title',
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
                        label: 'Spend for select period ($)',
                        field: 'select_period_sum',
                        type: 'number',
                        html: false,
                        filterable: true,
                    },
                    {
                        label: 'Total (clicks)',
                        field: 'total',
                        type: 'number',
                        html: false,
                        filterable: true,
                    },
                    // {
                    //     label: 'Clicks per day',
                    //     field: 'hours_clicks',
                    //     html: true,
                    //     filterable: false
                    // },
                    {
                        label: 'Total spend ($)',
                        field: 'total_sum',
                        type: 'number',
                        html: false,
                        filterable: true,
                    }
                ],
                rows: [],
                spTooltipProps3: {
                    formatter (val) {
                        let $hour = (val.index + 1)
                        return `${$hour <= 9 ? '0'+$hour : $hour}:00 - <label style="color:${val.color};font-weight:bold;">${val.value}</label>`
                    }
                },
            }
        },
        mounted () {
            this.$on('table-load-data', this.loadData)
            this.loadData(this.date)
        },
        methods: {
            onRowClick (e) {
                this.modal = e.row
                $('#modal-default').modal('show')
            },
            loadData (date = false) {
                this.wait = true
                if(date) this.date = date

                this.$get('/get_date_statistic', {between: this.date}, (response) => {
                    this.rows = response.data.data
                    this.wait = false
                }, (response) => {
                    this.wait = false
                })
            }
        },
        beforeDestroy () {
            this.$off('table-load-data');
        }
    }
</script>