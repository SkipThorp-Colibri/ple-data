<template>
  <nav class="navbar navbar-dark bg-dark fixed-top">
  <span class="navbar-brand mb-0 h1">PLE Report Add/Update</span>
  <span class="text-middle"><SearchForm @search-reports="searchReports" @reset-reports="resetReports" /></span>
  <span class="scroll-btn"><Button text="top" color="btn-secondary" @btn-click="scrollToTop" /></span>
</nav>
</template>

<script>
import Button from './Button.vue'
import SearchForm from './SearchForm.vue'

export default {
  name: "Navbar",
  components: {
    Button,
    SearchForm
  },
  data () {
    return {
      searchTerm: String
    }
  },
  methods: {
    async searchReports(searchTerm) {
      this.$emit("search-reports", searchTerm)
    },
    async resetReports() {
      this.$emit("reset-reports",{ "page": 1, "take": 100 })
    },
    scrollToTop() {
      window.scrollTo({
        top: 0,
        left: 0,
        behavior: "smooth"
      });
    }
  },
  emits: [
    'search-reports',
    'reset-reports'
  ]
}


</script>

<style>
 .scroll-btn {
  margin-top: 0rem;
 }
</style>