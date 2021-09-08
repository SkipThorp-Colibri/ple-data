<template>
    <div class="container" id="add-report-container">
        <h3>Edit report</h3>
        <hr />
        <form class="text-left">
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
                <div class="col"><Button v-show="!showAddSubject" text="edit subject" color="btn-primary" @btn-click="toggleAddSubject" /></div>
                <div class="col"><Button v-show="!showAddDepartment" text="add department" color="btn-primary" @btn-click="toggleAddDepartment" /></div>
                <div class="col"><Button v-show="!showAddEmail" text="add email" color="btn-primary" @btn-click="toggleAddEmail" /></div>
            </div>
            <div class="form-row">
                <div class="col">
                    <div v-show="showAddSubject">
                        <input type="text" v-model="newSubject" class="form-control" />
                        <Button text="submit" color="btn-success" @btn-click="submitSubject" />
                    </div>
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
                <Button text="submit report" color="btn-success" @btn-click="onReportSubmit" />
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
    mounted() {
        console.log(this.report)
    },
    data() {
        return {
            subject: '',
            departments: [],
            emails: [],
            newDepartment: '',
            newEmail: '',
            newSubject: null,
            showAddDepartment: true,
            showAddEmail: true,
            showAddSubject: true
        }
    },
    methods: {
        onReportSubmit() {
            const report = { subject: this.subject, departments: this.departments, emails: this.emails}
            this.$emit('add-new-report', report)
            this.subject = ''
            this.departments = []
            this.emails = []
        },
        submitDepartment() {
            if(this.newDepartment != ''){
                this.departments = [...this.departments, this.newDepartment]
                this.newDepartment = ''
                this.toggleAddDepartment()
            }
        },
        submitEmail() {
            if(this.newEmail != ''){
                this.emails = [...this.emails, this.newEmail]
                this.newEmail = ''
                this.toggleAddEmail()
            }
        },
        submitSubject() {
            if(this.newSubject != ''){
                this.subject = this.newSubject
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
                this.emails = this.emails.filter((e) => e !== email)
            }
        },
        removeDepartment(dept) {
            if(confirm(`Do you want to delete ${dept}`)) {
                this.departments = this.departments.filter((d) => d !== dept)
            }
        },
        setReportData(report) {
            this.subject = this.report.subject
        },
        closeEditReport() {
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