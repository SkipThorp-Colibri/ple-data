<template>
    <div id="pagination-component-container">
        <span class="m-2"><Button color="btn-primary" text="prev" @btn-click="getPrevPage" /></span>
        <span class="m-2" v-if="showPrev">{{ currentPage - 2 }}</span>
        <span class="m-2" v-if="showPrev">{{ currentPage - 1 }}</span>
        <span class="m-2">{{ currentPage }}</span>
        <span class="m-2" v-if="showNext">{{ currentPage + 1 }}</span>
        <span class="m-2" v-if="showNext">{{ currentPage + 2 }}</span>
        <span class="m-2"><Button color="btn-primary" text="next" @btn-click="getNextPage" /></span>
    </div>
</template>

<script>
import Button from './Button.vue'

export default {
    name: "Pagination",
    components: {
        Button
    },
    props: {
        currentPage: Number,
        reports: Array,
        totalPages: Number
    },
    data() {
        return {
            showPrev: this.currentPage < 2 ? false : true,
            showNext: this.currentPage <= this.totalPages - 2 ? false : true
        }
    },
    methods: {
        getNextPage(page) {
          this.$emit('get-next-page', this.currentPage + 1)
        },
        getPrevPage(page) {
          this.$emit('get-prev-page', this.currentPage - 1)
        }
    },
    emits: [
      'get-prev-page',
      'get-next-page'
    ]
}
</script>

<style>
    #pagination-component-container {
        margin: 1rem;
    }
</style>