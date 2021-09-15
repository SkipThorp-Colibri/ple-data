<template>
    <div class="container" id="add-report-container">
        <h3>Edit report</h3>
        <hr />
        <form class="text-left">
            <div class="form-row">
                
                <div class="col">
                    <label class="control-label">Departments</label>
                    <ul>
                        <li v-for="dept in report.departments" :key="dept"><Button :text="dept" color="btn-light" :block="true" @btn-click="removeDepartment(dept)" /></li>
                    </ul>
                </div>
                <div class="col">
                    <label class="control-label">Emails</label>
                    <ul>
                        <li v-for="email in report.emails" :key="email"><Button :text="email" color="btn-light" :block="true" @btn-click="removeEmail(email)" /></li>
                    </ul>
                </div>
                <div class="col">
                    <h4>Subject</h4>
                    {{ report.subject }}
                </div>
            </div>
            <div class="form-row">
                
                <div class="col"><Button v-show="!showAddDepartment" text="add department" color="btn-primary" @btn-click="toggleAddDepartment" /></div>
                <div class="col"><Button v-show="!showAddEmail" text="add email" color="btn-primary" @btn-click="toggleAddEmail" /></div>
                <div class="col"><Button v-show="!showAddSubject" text="edit subject" color="btn-primary" @btn-click="toggleAddSubject" /></div>
            </div>
            <div class="form-row">
                
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
                <div class="col">
                    <div v-show="showAddSubject">
                        <input type="text" v-model="newSubject" class="form-control" />
                        <Button text="submit" color="btn-success" @btn-click="submitSubject" />
                    </div>
                </div>
            </div>
            <div class="form-row">
                <Button text="submit edit" color="btn-success" @btn-click="onReportSubmit" />
                <Button text="cancel" color="btn-danger" @btn-click="closeEditReport" class="ml-1" />
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
    props: {
        report: Object
    },
    data() {
        return {
            subject: '',
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
        onReportSubmit() {
            this.$emit('submit-edit-report', this.report)
            this.subject = ''
            this.departments = []
            this.emails = []
        },
        submitDepartment() {
            if(this.newDepartment != ''){
                this.newDepartment = this.newDepartment.replace(/\u2013|\u2014/g, "-")
                this.departments = [...this.departments, this.newDepartment]
                this.newDepartment = ''
                
                this.toggleAddDepartment()
            }
        },
        submitEmail() {
            if(this.newEmail != ''){
                this.report.emails = [...this.report.emails, this.newEmail]
                this.newEmail = ''
                this.toggleAddEmail()
            }
        },
        submitSubject() {
            if(this.newSubject != ''){
                this.newSubject = this.newSubject.replace(/\u2013|\u2014/g, "-")
                this.newSubject = this.newSubject.replace(/ - /g,"_")
                this.newSubject = this.newSubject.replace(/,/g," ")
                this.newSubject = this.newSubject.replace(/ /g,"_")
                this.newSubject = this.newSubject.replace(/__/g,"_")
                
                this.report.subject = this.newSubject
                this.newSubject = ''
            }
            this.toggleAddSubject()
        },
        toggleAddDepartment() {
            this.showAddDepartment = !this.showAddDepartment
        },
        toggleAddEmail() {
            this.showAddEmail = !this.showAddEmail
        },
        toggleAddSubject() {
            this.showAddSubject = !this.showAddSubject
        },
        removeEmail(email) {
            if(confirm(`Do you want to delete ${email}`)) {
                this.report.emails = this.report.emails.filter((e) => e !== email)
            }
        },
        removeDepartment(dept) {
            if(confirm(`Do you want to delete ${dept}`)) {
                this.report.departments = this.report.departments.filter((d) => d !== dept)
            }
        },
        closeEditReport() {
            // this.report = null
            this.$emit('close-edit-report')
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