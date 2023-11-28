<template>
  <button type="button" class="btn btn-sm mb-2" :class="[ block ? 'btn-block' : '', color ? color : '']" @click="onButtonClick" >{{text}}</button>
</template>

<script>
export default {
    name: 'Button',
    props: {
        text: String,
        color: String,
        block: Boolean
    },
    methods: {
        onButtonClick() {
            this.$emit('btn-click')
        }
    },
    emits: [
      'btn-click'
    ]
}
</script>

<style>

</style>