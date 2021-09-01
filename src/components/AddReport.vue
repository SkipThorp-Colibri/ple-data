<template>
    <div class="container" id="add-report-container">
        <form class="text-left">
            <div class="form-row">
                <div class="col">
                    <label class="control-label" for="subject">Subject</label>
                    <input type="text" v-model="subject" class="form-control" />
                </div>
                <div class="col">
                    <label class="control-label">Departments</label>
                    <ul>
                        <li v-for="dept in departments" :key="dept">{{ dept }}</li>
                        <!-- <li>Aflac SD - Amber Lind Agency</li>
                        <li>Aflac ND - Ellie Papineau Agency</li> -->
                    </ul>
                    <button class="btn btn-sm btn-primary mb-2" @click="addDepartment">add department</button>
                    <input type="text" v-model="newDepartment" class="form-control" />
                </div>
                <div class="col">
                    <label class="control-label">Emails</label>
                    <ul>
                        <li>mdevans@aflac.com</li>
                        <li>LThorson@aflac.com</li>
                    </ul>
                    <button class="btn btn-sm btn-primary mb-2">add email</button>
                    <input type="text" v-model="newEmail" class="form-control" />
                </div>
            </div>
            <div class="form-row">
                <button type="submit" class="btn btn-success btn-sm mb-2">add report</button>
            </div>
        </form>
    </div>
</template>

<script>

var newReport = null;

export default {
    name: "AddReport",
    data() {
        return {
            subject: '',
            departments: ["Aflac SD - Amber Lind Agency"],
            emails: [],
            newDepartment: '',
            newEmail: ''
        }
    },
    methods: {
        addDepartment() {
            this.departments = [...this.departments, newDepartment]
            newDepartment = ''
        }
    }
}
</script>

<style scoped>
    #add-report-container {
        background-color: #eeeeee;
        padding: 1rem;
    }
</style>