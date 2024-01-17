<template>
  <Navbar @search-coupons="searchCoupons" @reset-coupons="fetchCoupons" />
  <div class="container-fluid" id="main-coupons-container">
    <AddCoupon v-if="showAddCoupon" @add-new-coupon="addNewCouponToList" @close-add-coupon="showAddCoupon = false" />
    <EditCoupon v-if="showEditCoupon" @submit-edit-coupon="onEditCoupon" :coupon="selectedCoupon" @close-edit-coupon="showEditCoupon = false" />
    <BulkInput v-if="showBulkInput" @add-bulk-coupons="addBulkCouponsToList" @close-bulk-input="showBulkInput = false"></BulkInput>
    <BulkEmailAdd v-if="showBulkEmailAdd" @close-bulk-email-input="showBulkEmailAdd = false" />

    <div class="text-left">
      <Button text="new coupon" color="btn-primary" @btn-click="toggleAddCoupon" />
      <Button text="bulk input" color="btn-info" style="margin-left: 1rem;" @btn-click="toggleBulkInput" />
      <Button text="add email to coupons" color="btn-info" style="margin-left: 1rem;" @btn-click="toggleBulkEmailAdd" />
    </div>
    
    <UpdateTable :couponsUpdate="couponsUpdate" @clear-update-list="clearUpdateList" />

    <CouponsTable :coupons="coupons" :currentPage="currentPage" @edit-coupon="editCoupon" @delete-coupon="deleteCoupon" @get-page="fetchCoupons" />
  </div>
</template>

<script>
import BulkEmailAdd from './components/BulkEmailAdd.vue'
import AddCoupon from './components/AddCoupon.vue'
import BulkInput from './components/BulkInput.vue'
import Button from './components/Button.vue'
import EditCoupon from './components/EditCoupon.vue'
import Navbar from './components/Navbar.vue'
import CouponsTable from './components/CouponsTable.vue'
import UpdateTable from './components/UpdateTable.vue'

export default {
  name: 'App',
  components: {
    BulkEmailAdd,
    AddCoupon,
    BulkInput,
    Button,
    EditCoupon,
    Navbar,
    CouponsTable,
    UpdateTable
  },
  data() {
    return {
      coupons: [],
      currentPage: 0,
      searchTerm: String,
      couponsUpdate: [],
      showAddCoupon: false,
      showEditCoupon: false,
      showBulkInput: false,
      showBulkEmailAdd: false,
      selectedCoupon: {},
      isEdit: false
    }
  },
  methods: {
    closeAll() {
      this.showAddCoupon = false
      this.showEditCoupon = false
      this.showBulkInput = false
      this.showBulkEmailAdd = false
    },
    toggleAddCoupon() {
      if(this.showAddCoupon) {
        this.closeAll()
      } else {
        this.showAddCoupon = !this.showAddCoupon
      }      
    },
    toggleEditCoupon() {
      if(this.showEditCoupon) {
        this.closeAll()
      } else {
        this.showEditCoupon = !this.showEditCoupon
      }    },
    toggleBulkInput() {
      if(this.showBulkInput) {
        this.closeAll()
      } else {
        this.showBulkInput = !this.showBulkInput
      }
    },
    toggleBulkEmailAdd() {
      if(this.showBulkEmailAdd) {
        this.closeAll()
      } else {
        this.showBulkEmailAdd = !this.showBulkEmailAdd
      }
    },
    async addNewCouponToList(coupon) {

      this.closeAll()

      await this.sortList(coupon)

      const stringifyCoupon = JSON.stringify(coupon)

      const res = await fetch('http://localhost:5003/coupons', {
        method: 'POST',
        headers: {
          'Content-type': 'application/json'
        },
        body: stringifyCoupon
      })
      const data = await res.json()
      this.coupons = [...this.coupons, data]
      this.addCouponToUpdateList(data)
    },
    async addBulkCouponsToList(coupons) {
      for(let i = 0;i < coupons.length;i++){
        await this.sortList(coupons[i])
        await this.addNewCouponToList(coupons[i])
      }
    },
    async onEditCoupon(coupon) {
      this.toggleEditCoupon()

      await this.sortList(coupon)
      
      const stringifyCoupon = JSON.stringify(coupon)

      const res = await fetch(`http://localhost:5003/coupons/${coupon.id}`, {
        method: 'PUT',
        headers: {
          'Content-type': 'application/json'
        },
        body: stringifyCoupon
      })
      const data = await res.json()

      let updatedItemIndex = this.coupons.findIndex(r => r.id === data.id)
      this.coupons[updatedItemIndex] = data
      this.addCouponToUpdateList(data)
    },
    async onDeleteCoupon(id) {
      const res = await fetch(`http://localhost:5003/coupons/${id}`, {
        method: 'DELETE'
      })
    },
    async editCoupon(id) {
      this.selectedCoupon = await this.fetchCoupon(id)
      this.showEditCoupon = true
      this.showAddCoupon = false
      document.body.scrollTop = document.documentElement.scrollTop = 0
    },
    async deleteCoupon(id) {
      let coupon = await this.fetchCoupon(id)

      if(confirm(`Do you want to delete ${coupon.subject}`)) {
          this.coupons = this.coupons.filter((r) => r.id !== id)
      }
      this.onDeleteCoupon(id)
    },
    async searchCoupons(term) {
      this.searchTerm = term
      this.coupons = []
      const res = await fetch(`http://localhost:5003/coupons?q=${this.searchTerm}`)
      const data = await res.json()
      this.coupons = data
    },
    async fetchAllCoupons() {
      for(let i = 1; i < 500; i++) {
        await this.fetchCoupons({ "page": i, "take": 50 })
      }
    },
    async fetchCoupons(obj) {
      this.currentPage = obj.page
      this.coupons = []
      const res = await fetch(`http://localhost:5003/coupons?_page=${obj.page}&_limit=${obj.take}`)
      const data = await res.json()
      this.coupons = data
    },
    async fetchCoupon(id) {
      const res = await fetch(`http://localhost:5003/coupons/${id}`)
      const data = await res.json()
      return data
    },
    async addCouponToUpdateList(coupon) {
      this.couponsUpdate = [...this.couponsUpdate, coupon]
    },
    async sortList(coupon) {
      if(coupon.departments != undefined && coupon.departments.length > 1) {
        coupon = { ...coupon, departments: coupon.departments.sort() }
      }
      if(coupon.emails != undefined && coupon.emails.length > 1) {
        coupon = { ...coupon, emails: coupon.emails.sort() }
      }

      return coupon
    },
    clearUpdateList() {
      this.couponsUpdate = []
    }
  },
  async mounted() {
    this.currentPage = 1
    await this.fetchCoupons({ "page": this.currentPage, "take": 100 })
  }
}
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
}

#main-coupons-container {
  margin-top: 4rem;
}

</style>