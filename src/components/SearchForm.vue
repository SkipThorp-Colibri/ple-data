<template>
<div class="input-group mb3">
    <input type="text" class="form-control-sm" placeholder="Search..." v-model="searchTerm" />
    <div class="input-group-append">
      <Button text="search" color="btn-primary" @btn-click="searchReports(searchTerm)" />
    </div>
  </div>
</template>

<script>
import Button from './Button.vue'

export default {
  name: "Navbar",
  components: {
    Button
  },
  data() {
    return {
      searchTerm: String
    }
  },
  methods: {
    async searchReports() {
      console.log("searchTerm in SearchForm: ", this.searchTerm)
      this.$emit('search-reports', this.searchTerm)
    }
  },
  emits: [
    'search-reports'
  ]
}


</script>