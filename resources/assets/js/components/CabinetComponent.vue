<template>
    <div class="relative">
        <div class="row">

            <div class="col-lg-9 col-md-12">

            </div>

        </div>
    </div>
</template>

<script>
    export default {
        data () {
            return {
                user: [],
            }
        },
        methods: {
            hasSegment ($name) {
                return false
            },
            goTo (a) {
                return false
            }
        },
        mounted () {
            this.user = user
        }
    }
</script>