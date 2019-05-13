<template>
    <div :id="this.id"></div>
</template>

<script>
    import { mixin } from './../../mixins'

    export default {
        mixins: [
            mixin
        ]        
    }
</script>
