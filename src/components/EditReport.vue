<template>
    <div class="container" id="add-report-container">
        <form class="text-left" @submit="onAddReportSubmit">
            <div class="form-row">
                <div class="col">
                    <h4>Subject</h4>
                    {{ subject }}
                </div>
                <div class="col">
                    <label class="control-label">Departments</label>
                    <ul>
                        <li v-for="dept in departments" :key="dept"><Button :text="dept" color="btn-light" :block="true" @btn-click="removeDepartment(dept)" /></li>
                    </ul>
                </div>
                <div class="col">
                    <label class="control-label">Emails</label>
                    <ul>
                        <li v-for="email in emails" :key="email"><Button :text="email" color="btn-light" :block="true" @btn-click="removeEmail(email)" /></li>
                    </ul>
                </div>
            </div>
            <div class="form-row">
                <div class="col"></div>
                <div class="col"><Button text="add department" color="btn-primary" @btn-click="toggleAddDepartment" /></div>
                <div class="col"><Button text="add email" color="btn-primary" @btn-click="toggleAddEmail" /></div>
            </div>
            <div class="form-row">
                <div class="col">
                    <input type="text" v-model="subject" class="form-control" />
                </div>
                <div class="col">
                    <div v-show="showAddDepartment">
                        <input type="text" v-model="newDepartment" class="form-control" />
                        <Button text="submit" color="btn-success" @btn-click="submitDepartment" />
                    </div>
                </div>
                <div class="col">
                    <div v-show="showAddEmail">
                        <input type="text" v-model="newEmail" class="form-control" />
                        <Button text="submit" color="btn-success" @btn-click="submitEmail" />
                    </div>
                </div>
            </div>
            <div class="form-row">
                <Button text="add report" color="btn-success" @btn-click="onAddReportSubmit" />
            </div>
        </form>
    </div>
</template>

<script>
import Button from './Button.vue'

export default {
    name: "EditReport",
    components: {
        Button
    },
    data() {
        return {
            subject: '',
            departments: ["Aflac SD - Amber Lind Agency"],
            emails: ["mdevans@aflac.com","LThorson@aflac.com"],
            newDepartment: '',
            newEmail: '',
            newReport: null,
            showAddDepartment: false,
            showAddEmail: false
        }
    },
    methods: {
        onAddReportSubmit() {
            this.newReport = { subject: this.subject, departments: this.departments, emails: this.emails}
            console.log("add report submitted", this.newReport)
        },
        submitDepartment() {
            if(this.newDepartment != ''){
                this.departments = [...this.departments, this.newDepartment]
                this.newDepartment = ''
            }
        },
        submitEmail() {
            if(this.newEmail != ''){
                this.emails = [...this.emails, this.newEmail]
                this.newEmail = ''
            }
        },
        toggleAddDepartment() {
            console.log("toggle show add department", this.showAddDepartment)
            this.showAddDepartment = !this.showAddDepartment
        },
        toggleAddEmail() {
            console.log("toggle show add email", this.showAddEmail)
            this.showAddEmail = !this.showAddEmail
        },
        removeEmail(email) {
            console.log(email)
            //this.$emit('delete-email', email)
        }
        ,
        removeDepartment(dept) {
            console.log(dept)
            //this.$emit('delete-dept', dept)
        }
    }
}
</script>

<style scoped>
    button {
        margin-top: 1rem;
    }
    #add-report-container {
        background-color: #eeeeee;
        padding: 1rem;
    }
    ul {
        list-style: none;
        padding-left: 0;
    }
</style>