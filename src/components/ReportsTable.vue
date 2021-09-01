<template>
  <table class="table">
    <thead>
      <tr>
        <th scope="col">Title/Subject</th>
        <th scope="col">Departments</th>
        <th scope="col">Emails</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
        <tr v-for="report in reports" :key="report.subject">
            <th scope="row">{{report.subject}}</th>
            <td class="text-left"><span v-for="dept in report.departments" :key="dept">{{ dept }}, </span></td>
            <td class="text-left"><span v-for="email in report.emails" :key="email">{{ email }}, </span></td>
            <td><button class="btn btn-primary btn-sm" @click="editLine(report)">edit</button></td>
        </tr>
    </tbody>
  </table>
  
</template>

<script>

var selectedItem = null;

export default {
    name: "ReportsTable",
    components: {
        
    },
    props: {
        reports: Array,
    },
    methods: {
        editLine(report) {
            this.selectedItem = {...report};
            console.log(`edit clicked for ${report.subject}`)
            console.log(this.selectedItem);
        }
    }
}
</script>

<style>

</style>