//import select2 from 'select2'

export default {
    props: ['options', 'value', 'ajax', 'classStyle', 'tags', 'change'],
    template: '<select><slot></slot></select>',
    mounted: function () {
        var vm = this
        $(this.$el)
            .select2(!this.ajax ? {
                data: this.options,
                containerCssClass: this.classStyle,
                tags: this.tags ? true : false
            } : {
                data: this.options,
                allowClear: true,
                escapeMarkup: function (markup) { return markup; },
                ajax: {
                    url: this.ajax,
                    dataType: 'json',
                    data: function(params) {
                        return {
                            term: params.term || '',
                            page: params.page || 1
                        }
                    },
                    cache: true
                },
                containerCssClass: this.classStyle,
                tags: this.tags ? true : false
            })
            .val(this.value)
            .trigger('change')
            .on('change', function () {
                if(this.value!='') {
                    if(this.change) this.change
                    vm.$emit('input', this.value)
                }
            })
    },
    watch: {
        value: function (value) {
            // update value
            $(this.$el)
                .val(value)
                .trigger('change')
        },
        options: function (options) {
            // update options
            $(this.$el).empty().select2({ data: options, containerCssClass: this.classStyle, tags: this.tags ? true : false }).val(this.value).trigger('change')
        }
    },
    destroyed: function () {
        $(this.$el).off().select2('destroy')
    }
}