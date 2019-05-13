<template>
    <span v-if="selected">
        {{ selected == now ? 'Statistics for today' : `Statistics for ${selected}` }}
    </span>
    <span v-else>Statistics on products</span>
</template>

<script>
    import moment from 'moment'

    export default {
        name: 'day-table-title',
        data () {
            return {
                selected: false,
                now: moment(new Date()).format('DD.MM.YYYY')
            }
        },
        methods: {
            chTitle ($selected) {
                //this.selected = $selected
            }
        },
        mounted () {
            this.$on('ch-table-title', this.chTitle)
        },
        beforeDestroy () {
            this.$off('ch-table-title');
        }
    }
</script>