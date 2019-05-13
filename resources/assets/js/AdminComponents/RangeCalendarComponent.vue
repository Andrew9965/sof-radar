<template>
    <div class="datepicker-trigger">
        <button class="btn btn-sm btn-success" id="datepicker-trigger">
            <i class="fa fa-calendar"></i> {{ date.start==date.end ? (date.start == now ? 'For today' : `From ${date.start}`) : `From ${date.start} through ${date.end}` }}
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
</template>

<script>
    import moment from 'moment'

    export default {
        name: 'range-calendar',
        data () {
            return {
                date: {start: moment(new Date()).subtract(30, "days").format('YYYY-MM-DD'), end: moment(new Date()).format('YYYY-MM-DD')},
                now: moment(new Date()).format('YYYY-MM-DD'),
                now2: moment(new Date()).format('DD.MM.YYYY'),
                startDate: new Date(),
                endDate: new Date(),
                graph: this.$root.$refs.graph
            }
        },
        mounted() {

        },
        methods: {
            getData () {
                console.log(this.$root.$refs.graph)
                this.$root.$refs.graph.$emit('data-changed', this.date)
                this.$root.$refs.table.$emit('table-load-data', this.date)
            }
        }
    }
</script>

<style>
    .asd__wrapper {
        text-align: right;
    }
    .bar {
        cursor: pointer;
    }
</style>