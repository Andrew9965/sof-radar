<template>
    <div class="datepicker-trigger">
        <button class="btn btn-sm btn-success" id="datepicker-trigger-2">
            <i class="fa fa-calendar"></i> {{ date.start==date.end ? (date.start == now ? 'For today' : `From ${date.start}`) : `From ${date.start} through ${date.end}` }}
        </button>

        <AirbnbStyleDatepicker
                :trigger-element-id="'datepicker-trigger-2'"
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
        name: 'range-calendar-2',
        props: ["click"],
        data () {
            return {
                date: {start: moment(new Date()).subtract(30, "days").format('YYYY-MM-DD'), end: moment(new Date()).format('YYYY-MM-DD')},
                now: moment(new Date()).format('YYYY-MM-DD'),
                now2: moment(new Date()).format('DD.MM.YYYY'),
                startDate: new Date(),
                endDate: new Date()
            }
        },
        methods: {
            getData () {
                //this.$root.$refs.prod_stat.$emit('data-ins-changed', this.date)
                this.click(this.date)
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