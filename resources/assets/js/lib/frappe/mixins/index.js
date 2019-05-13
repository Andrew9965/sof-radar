import { Chart } from 'frappe-charts/dist/frappe-charts.min.esm'

export const mixin = {
    props: {
        id: {
            required: true,
            type: String,
            default: null
        },

        dataSets: {
            required: true,
            type: Array,
            default: () => []
        },

        labels: {
            required: true,
            type: Array,
            default: () => []
        },

        title: {
            required: false,
            type: String
        },

        height: {
            required: false,
            type: Number,
            default: 300
        },

        type: {
            required: false,
            type: String,
            default: 'bar'
        },

        yMarkers: {
            required: false,
            type: Array,
            default: () => [
                {
                    label: 'Marker',
                    value: 70,
                    options: {
                        labelPos: 'left'
                    }
                }
            ]
        },

        yRegions: {
            required: false,
            type: Array,
            default: () => [
                {
                    label: 'Region',
                    start: -10,
                    end: 50,
                    options: {
                        labelPos: 'right'
                    }
                }
            ]
        },

        colors: {
            required: false,
            type: Array,
            default: () => [
                'purple', '#ffa3ef', 'light-blue'
            ]
        },

        isNavigable: {
            required: false,
            type: Boolean,
            default: false
        },

        valuesOverPoints: {
            required: false,
            type: Boolean,
            default: false
        },

        barOptions: {
            required: false,
            type: Object,
            default: () => {
                return {
                    spaceRatio: 0.5,
                    stacked: 0
                }
            }
        },

        lineOptions: {
            required: false,
            type: Object,
            default: () => {
                return {
                    dotSize: 4,
                    hideLine: 0,
                    hideDots: 0,
                    heatline: 0,
                    regionFill: 0,
                    areaFill: 0
                }
            }
        },

        axisOptions: {
            required: false,
            type: Object,
            default: () => {
                return {
                    yAxisMode: '',
                    xAxisMode: '',
                    xIsSeries: 0
                }
            }
        },

        maxLegendPoints: {
            required: false,
            type: Number,
            default: 20
        },

        maxSlices: {
            required: false,
            type: Number,
            default: 20
        },

        barOptions: {
            required: false,
            type: Object,
            default: () => {
                return {
                    height: 20,
                    depth: 2
                }
            }
        },

        discreteDomains: {
            required: false,
            type: Boolean,
            default: true
        },

        tooltipOptions: {
            required: false,
            type: Object,
            default: () => {
                return {
                    formatTooltipX: d => (d + '').toUpperCase(),
                    formatTooltipY: d => d + ' pts'
                }
            }
        },

        events: {
            required: false,
            type: Object,
            default: () => {
                return {}
            }
        }
    },
    
    data () {
        return {
            chart: null,
            data: {
                labels: this.labels,
                datasets: this.dataSets
            }
        }
    },

    mounted () {
        this.startChart()
    },

    methods: {
        startChart () {
            this.chart = new Chart(`#${this.id}`, {
                data: this.data,
                type: this.type,
                title: this.title,
                colors: this.colors,
                height: this.height,
                tooltipOptions: this.tooltipOptions,
                isNavigable: this.isNavigable,
                valuesOverPoints: this.valuesOverPoints,
                barOptions: this.barOptions,
                lineOptions: this.lineOptions,
                axisOptions: this.axisOptions,
                maxLegendPoints: this.maxLegendPoints,
                maxSlices: this.maxSlices,
                barOptions: this.barOptions,
                discreteDomains: this.discreteDomains
            })
            _.map(this.events, (val, key) => {
                this.chart.parent.addEventListener(key, val);
            })
        },

        export () {
            this.chart.export()
        },

        addDataPoint (label, valueFromEachDataset, index) {
            this.chart.addDataPoint(label, valueFromEachDataset, index)
        },

        removeDataPoint (index) {
            this.chart.removeDataPoint(index)
        },

        updateDataset (datasetValues, index) {
            this.chart.updateDataset(datasetValues, index)
        },

        unbindWindowEvents () {
            this.chart.unbindWindowEvents()
        }
    }
}

