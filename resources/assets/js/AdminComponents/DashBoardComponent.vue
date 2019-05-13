<template>
    <div v-if="!wait">
        <vue-frappe
            ref="charte"
            id="test"
            :labels="labels"
            title=""
            :height="300"
            :colors="['purple', '#ffa3ef', 'light-blue']"
            areaFill
            :yRegions="[{ label: 'Region', start: 0, end: 50000 }]"
            :dataSets="this.data"
            :tooltipOptions="{formatTooltipY: d => d + ' Clicks'}"
            :events="{'data-select': selectDate}"
    ></vue-frappe>
    </div>
    <div v-else>
        <img src="/spinner.gif" style="margin: 0 auto; display: flex;"/>
    </div>
</template>

<script>
    import moment from 'moment'

    export default {
        name: 'day-graphs',
        data () {
            return {
                wait: true,
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
                el_title: this.$root.$refs.table_title
            }
        },
        mounted() {
            this.getData()
            this.$on('data-changed', this.dataChanged)
        },
        beforeDestroy () {
            this.$off('data-changed');
        },
        methods: {
            dataChanged ($date) {
                this.date = $date
                this.getData()
            },
            getEvents () {
                if (!this.selected) this.selected = this.array_last(this.labels)
                this.$root.$refs.table_title.$emit('ch-table-title', this.selected)
            },
            selectDate (e) {
                this.selected = e.label
            },
            getData () {
                this.wait = true
                axios.get('get_new_statistic', {params: {...this.date}}).then((response) => {
                    this.wait = false
                    if(response.data.status == 'success') {
                        this.data = response.data.data ? response.data.data : []
                        this.labels = response.data.labels
                        // this.getEvents()
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
                    console.log(err)
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
        }
    }
</script>