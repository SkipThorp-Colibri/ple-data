<template>
    <div class="container" id="add-report-container">
        <h3>Add new report</h3>
        <hr />
        <form class="text-left">
            <div class="form-row">
                
                <div class="col">
                    <h5>Departments</h5>
                    <ul>
                        <li v-for="dept in departments" :key="dept"><Button :text="dept" color="btn-light" :block="true" @btn-click="removeDepartment(dept)" /></li>
                    </ul>
                </div>
                <div class="col">
                    <h5>Emails</h5>
                    <ul>
                        <li v-for="email in emails" :key="email"><Button :text="email" color="btn-light" :block="true" @btn-click="removeEmail(email)" /></li>
                    </ul>
                </div>
                <div class="col">
                    <h5>Subject</h5>
                    {{ subject }}
                </div>
                <div class="col">
                    <table class="table table-condensed table-borderless">
                        <tr>
                            <td><label for="rowsort" class="col-sm-2 col-form-label">rowsort</label></td>
                            <td><input class="form-control form-control-sm" name="rowsort" v-model="rowsort" /></td>
                        </tr>
                        <tr>
                            <td><label for="columnsort" class="col-sm-2 col-form-label">columnsort</label></td>
                            <td><input class="form-control form-control-sm" name="columnsort" v-model="columnsort" /></td>
                        </tr>
                        <tr>
                            <td><label for="login_filter" class="col-sm-2 col-form-label">login_filter</label></td>
                            <td><input class="form-control form-control-sm" name="login_filter" v-model="login_filter" /></td>
                        </tr>
                        <tr>
                            <td><label for="completion_filter" class="col-sm-2 col-form-label">completion_filter</label></td>
                            <td><input class="form-control form-control-sm" name="completion_filter" v-model="completion_filter" /></td>
                        </tr>
                        <tr>
                            <td><label for="remove_button" class="col-sm-2 col-form-label">remove_button</label></td>
                            <td><input class="form-control form-control-sm" name="remove_button" v-model="remove_button" /></td>
                        </tr>
                        <tr>
                            <td><label for="course_type_only" class="col-sm-2 col-form-label">course_type_only</label></td>
                            <td><input class="form-control form-control-sm" name="course_type_only" v-model="course_type_only" /></td>
                        </tr>
                        <tr>
                            <td><label for="ple_only" class="col-sm-2 col-form-label">ple_only</label></td>
                            <td><input class="form-control form-control-sm" name="ple_only" v-model="ple_only" /></td>
                        </tr>
                        <tr>
                            <td><label for="summary_only" class="col-sm-2 col-form-label">summary_only</label></td>
                            <td><input class="form-control form-control-sm" name="summary_only" v-model="summary_only" /></td>
                        </tr>
                    </table>
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
                <Button text="submit report" color="btn-success" @btn-click="onReportSubmit" />
                <Button text="cancel" color="btn-danger" @btn-click="closeAddReport" class="ml-1" />
            </div>
        </form>
    </div>
</template>

<script>
import Button from './Button.vue'

export default {
    name: "AddReport",
    components: {
        Button
    },
    data() {
        return {
            departments: [],
            emails: [],
            subject: '',
            rowsort: 0,
            cc_email: "",
            columnsort: 0,
            login_filter: 0,
            completion_filter: 0,
            remove_button: 0,
            course_type_only: 0,
            ple_only: 0,
            summary_only: 0,           
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
            const report = { 
                departments: this.departments, 
                emails: this.emails, 
                subject: this.subject,
                rowsort: parseInt(this.rowsort),
                cc_email: parseInt(this.cc_email),
                columnsort: parseInt(this.columnsort),
                login_filter: parseInt(this.login_filter),
                completion_filter: parseInt(this.completion_filter),
                remove_button: parseInt(this.remove_button),
                course_type_only: parseInt(this.course_type_only),
                ple_only: parseInt(this.ple_only),
                summary_only: parseInt(this.summary_only)
            }
            this.$emit('add-new-report', report)
            this.subject = ''
            this.departments = []
            this.emails = []
        },
        submitDepartment() {
            if(this.newDepartment != ''){
                let newDeptArray = this.newDepartment.split('%')
                
                newDeptArray.forEach((value) => {
                    value = value.replace(/\u2013|\u2014/g, "-")
                    this.departments = [...this.departments, value]
                })

                this.newDepartment = ''
                this.toggleAddDepartment()
            }
        },
        submitEmail() {
            if(this.newEmail != ''){
                let newEmailArray = this.newEmail.split(';')

                newEmailArray.forEach((value) => {
                    this.emails = [...this.emails, value.toLowerCase()]
                })

                this.newEmail = ''
                this.toggleAddEmail()
            }
        },
        submitSubject() {
            if(this.newSubject != ''){
                this.subject = this.newSubject
                this.newSubject = ''

                this.subject = this.subject.replace(/\u2013|\u2014/g, "-")
                this.subject = this.subject.replace(/ - /g,"_")
                this.subject = this.subject.replace(/,/g," ")
                this.subject = this.subject.replace(/ /g,"_")
                this.subject = this.subject.replace(/__/g,"_")
                
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
        closeAddReport() {
            this.$emit('close-add-report')
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