<template>
    <div class="container" id="add-report-container">
        <h3>Edit report - {{ report.id }}</h3>
        <hr />
        <form class="text-left">
            <div class="form-row">
                <div class="col">
                    <h5>Departments</h5>
                    <ul>
                        <li v-for="dept in report.departments" :key="dept"><Button :text="dept" color="btn-light" :block="true" @btn-click="removeDepartment(dept)" /></li>
                    </ul>
                </div>
                <div class="col">
                    <h5>Emails</h5>
                    <ul>
                        <li v-for="email in report.emails" :key="email"><Button :text="email" color="btn-light" :block="true" @btn-click="removeEmail(email)" /></li>
                    </ul>
                </div>
                <div class="col">
                    <h5>Subject</h5>
                    {{ report.subject }}
                </div>
                <div class="col">
                    <div class="form-row">
                        <div class="col"><label for="rowsort" class="col-sm-2 col-form-label">rowsort</label></div>
                        <div class="col"><input class="form-control" name="rowsort" v-model="report.rowsort" /></div>
                    </div>
                    <div class="form-row">
                        <div class="col"><label for="columnsort" class="col-sm-2 col-form-label">columnsort</label></div>
                        <div class="col"><input class="form-control" name="columnsort" v-model="report.columnsort" /></div>
                    </div>
                    <div class="form-row">
                        <div class="col"><label for="login_filter" class="col-sm-2 col-form-label">login_filter</label></div>
                        <div class="col"><input class="form-control" name="login_filter" v-model="report.login_filter" /></div>
                    </div>
                    <div class="form-row">
                        <div class="col"><label for="completion_filter" class="col-sm-2 col-form-label">completion_filter</label></div>
                        <div class="col"><input class="form-control" name="completion_filter" v-model="report.completion_filter" /></div>
                    </div>
                    <div class="form-row">
                        <div class="col"><label for="remove_button" class="col-sm-2 col-form-label">remove_button</label></div>
                        <div class="col"><input class="form-control" name="remove_button" v-model="report.remove_button" /></div>
                    </div>
                    <div class="form-row">
                        <div class="col"><label for="course_type_only" class="col-sm-2 col-form-label">course_type_only</label></div>
                        <div class="col"><input class="form-control" name="course_type_only" v-model="report.course_type_only" /></div>
                    </div>
                    <div class="form-row">
                        <div class="col"><label for="ple_only" class="col-sm-2 col-form-label">ple_only</label></div>
                        <div class="col"><input class="form-control" name="ple_only" v-model="report.ple_only" /></div>
                    </div>
                    <div class="form-row">
                        <div class="col"><label for="summary_only" class="col-sm-2 col-form-label">summary_only</label></div>
                        <div class="col"><input class="form-control" name="summary_only" v-model="report.summary_only" /></div>
                    </div>
                </div>
            </div>
            <div class="form-row">
                
                <div class="col"><Button v-show="!showAddDepartment" text="add department" color="btn-primary" @btn-click="toggleAddDepartment" /></div>
                <div class="col"><Button v-show="!showAddEmail" text="add email" color="btn-primary" @btn-click="toggleAddEmail" /></div>
                <div class="col"><Button v-show="!showAddSubject" text="edit subject" color="btn-primary" @btn-click="toggleAddSubject" /></div>
                <div class="col"></div>
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
                <div class="col"></div>
            </div>
            <hr />
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
            for(let i = 0; i < this.report.emails.length; i++) {
                this.report.emails[i] = this.report.emails[i].toLowerCase()
            }
            this.$emit('submit-edit-report', this.report)
            this.subject = ''
            this.departments = []
            this.emails = []
        },
        submitDepartment() {
            if(this.newDepartment != ''){
                let newDeptArray = this.newDepartment.split('%')

                newDeptArray.forEach((value) => {
                    value = value.replace(/\u2013|\u2014/g, "-")
                    this.report.departments = [...this.report.departments, value]
                })

                this.newDepartment = ''
                this.toggleAddDepartment()
            }
        },
        submitEmail() {
            if(this.newEmail != ''){
                let newEmailArray = this.newEmail.split(';')

                newEmailArray.forEach((value) => {
                    this.report.emails = [...this.report.emails, value.toLowerCase()]
                })

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
        margin-bottom: 3rem;
    }
    ul {
        list-style: none;
        padding-left: 0;
    }
</style>