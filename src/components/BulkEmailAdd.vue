<template>
    <div class="container" id="add-bulk-email-add-container">
        <h3>Bulk Email Add</h3>
        <hr />
        <form class="text-left">
            <div class="form-row">
                <div class="col">
                    <h5>Email</h5>
                    
                </div>
                <div class="col">
                    <h5>Coupons</h5>
                    
                </div>
                <div class="col">
                    <h5>temp</h5>
                    
                </div>
                
            </div>
            <div class="form-row">
                <div class="col">
                    <div>
                        <input type="text" v-model="newEmail" class="form-control" />
                    </div>
                </div>
                <div class="col">
                    <div>
                        <textarea class="form-control" v-model="couponNames"></textarea>
                    </div>
                </div>
                <div class="col">
                    <div>
                        
                    </div>
                </div>
                
            </div>
            <hr />
            <div class="form-row">
                
                <Button text="submit edit" color="btn-success" @btn-click="onBulkEmailSubmit" />
                <Button text="cancel" color="btn-danger" @btn-click="closeBulkEmailAdd" class="ml-1" />
            </div>
        </form>
    </div>
</template>

<script>
import Button from './Button.vue'

export default {
    name: "BulkEmailAdd",
    components: {
        Button
    },
    props: {
        coupon: Object
    },
    data() {
        return {
            departments: [],
            emails: [],
            newDepartment: '',
            newEmail: '',
            newSubject: null,
            showAddDepartment: false,
            showAddEmail: false,
            showAddSubject: false
        }
    },
    methods: {
        onCouponSubmit() {
            for(let i = 0; i < this.coupon.emails.length; i++) {
                this.coupon.emails[i] = this.coupon.emails[i].toLowerCase()
            }
            this.$emit('submit-edit-coupon', this.coupon)
            this.subject = ''
            this.departments = []
            this.emails = []
        },
        submitDepartment() {
            if(this.newDepartment != ''){
                let newDeptArray = this.newDepartment.split('%')

                newDeptArray.forEach((value) => {
                    value = value.replace(/\u2013|\u2014/g, "-")
                    this.coupon.departments = [...this.coupon.departments, value]
                })

                this.newDepartment = ''
                this.toggleAddDepartment()
            }
        },
        closeBulkEmailAdd() {
            this.$emit('close-bulk-email-input')
        }
    }
}
</script>

<style scoped>
    button {
        margin-top: 1rem;
    }
    #add-bulk-email-add-container {
        background-color: #eeeeee;
        padding: 1rem;
    }
    ul {
        list-style: none;
        padding-left: 0;
    }
</style>