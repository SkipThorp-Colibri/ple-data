<template>
  <table class="table">
    <thead>
      <tr>
        <th scope="col">Id</th>
        <th scope="col">Departments</th>
        <th scope="col">Emails</th>
        <th scope="col">Title/Subject</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
        <tr v-for="report in reports" :key="report.subject">
            <th scope="row">{{report.id}}</th>
            <td class="text-left"><span v-for="(dept,i) in report.departments" :key="i"><span v-if="i > 0">, </span>{{ dept }}</span></td>
            <td class="text-left"><span v-for="(email,i) in report.emails" :key="i"><span v-if="i > 0">, </span>{{ email }}</span></td>
            <th class="text-left">{{report.subject}}</th>
            <td><Button color="btn-primary" text="edit" @btn-click="editLine(report)" /></td>
        </tr>
    </tbody>
  </table>
  
</template>

<script>
import Button from './Button.vue'

export default {
    name: "ReportsTable",
    components: {
        Button
    },
    props: {
        reports: Array,
    },
    methods: {
        editLine(report) {
            this.$emit('edit-report', report.id)
        }
    },
    emits: [
      'edit-report'
    ]
}
</script>

<style>

</style>