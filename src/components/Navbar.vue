<template>
  <nav class="navbar navbar-dark bg-dark fixed-top">
  <span class="navbar-brand mb-0 h1">PLE Report Add/Update</span>
  <span class="scroll-btn"><Button text="top" color="btn-secondary" @btn-click="scrollToTop" /></span>
</nav>
</template>

<script>
import Button from './Button.vue'

export default {
  name: "Navbar",
  components: {
    Button
  },
  methods: {
    scrollToTop() {
      window.scrollTo({
        top: 0,
        left: 0,
        behavior: "smooth"
      });
    }
  } 
}


</script>

<style>
 .scroll-btn {
  margin-top: 0rem;
 }
</style>