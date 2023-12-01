<template>
<div class="input-group mb3">
    <input type="text" class="form-control-sm" placeholder="Search..." v-model="searchTerm" />
    <div class="input-group-append">
      <Button text="reset" color="btn-danger" @btn-click="resetReports" />
    </div>
    <div class="input-group-append">
      <Button text="search" color="btn-primary" @btn-click="searchReports" />
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
      searchTerm: ""
    }
  },
  methods: {
    async searchReports() {
      this.$emit('search-reports', this.searchTerm)
    },
    async resetReports() {
      this.searchTerm = ""
      this.$emit('reset-reports')
    }
  },
  emits: [
    'search-reports',
    'reset-reports'
  ]
}


</script>