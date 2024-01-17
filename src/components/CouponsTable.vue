<template>
  <div>
    <span class="m-2"><Button color="btn-primary" text="prev" @btn-click="getPrevPage(currentPage)" /></span>
    <span class="m-2"><Button color="btn-primary" text="next" @btn-click="getNextPage(currentPage)" /></span>
  </div>
  <table class="table">
    <thead>
      <tr>
        <th scope="col" class="text-left">Coupon Id</th>
        <th scope="col" class="text-left">Coupon Name</th>
        <th scope="col" class="text-left">Coupon Code</th>
        <!-- <th scope="col" class="text-left">Course Ids</th>
        <th scope="col" class="text-left">Course Names</th> -->
      </tr>
    </thead>
    <tbody>
        <tr v-for="coupon in coupon" :key="coupon.Id">
            <th scope="row">{{coupon.CouponId}}</th>
            <td class="text-left">{{coupon.CouponName}}</td>
            <td class="text-left">{{coupon.CouponCode}}</td>
            <!-- <td class="text-left"><span v-for="(coup,i) in coupon.departments" :key="i"><span v-if="i > 0">, </span>{{ coup }}</span></td>
            <td class="text-left"><span v-for="(email,i) in coupon.emails" :key="i"><span v-if="i > 0">, </span>{{ email }}</span></td>
            <td class="text-left">{{coupon.subject}}</td> -->
            <!-- <td><Button color="btn-primary" text="edit" @btn-click="editLine(coupon)" /></td>
            <td><Button color="btn-danger" text="delete" @btn-click="deleteLine(coupon)" /></td> -->
        </tr>
    </tbody>
  </table>
  
</template>

<script>
import Button from './Button.vue'

export default {
    name: "CouponTable",
    components: {
        Button
    },
    props: {
        coupon: Array,
        currentPage: Number
    },
    methods: {
        editLine(coupon) {
            this.$emit('edit-coupon', coupon.id)
        },
        deleteLine(coupon) {
          this.$emit('delete-coupon', coupon.id)
        },
        getNextPage(page) {
          this.$emit('get-page', { "page": page + 1, "take": 100 })
        },
        getPrevPage(page) {
          this.$emit('get-page', { "page": page - 1, "take": 100 })
        }
    },
    emits: [
      'edit-coupon',
      'delete-coupon',
      'get-page'
    ]
}
</script>

<style>

</style>