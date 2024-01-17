<template>
<div class="input-group mb3">
    <input type="text" class="form-control-sm" placeholder="Search..." v-model="searchTerm" />
    <div class="input-group-append">
      <Button text="reset" color="btn-danger" @btn-click="resetCoupons" />
    </div>
    <div class="input-group-append">
      <Button text="search" color="btn-primary" @btn-click="searchCoupons" />
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
    async searchCoupons() {
      this.$emit('search-coupons', this.searchTerm)
    },
    async resetCoupons() {
      this.searchTerm = ""
      this.$emit('reset-coupons')
    }
  },
  emits: [
    'search-coupons',
    'reset-coupons'
  ]
}


</script>