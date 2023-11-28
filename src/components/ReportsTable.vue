<template>
  <div>
    <Button color="btn-primary" text="prev" @btn-click="getPrevPage(currentPage)" />
    <Button color="btn-primary" text="next" @btn-click="getNextPage(currentPage)" />
  </div>
  <table class="table">
    <thead>
      <tr>
        <th scope="col">Id</th>
        <th scope="col">Departments</th>
        <th scope="col">Emails</th>
        <th scope="col">Title/Subject</th>
        <th></th>
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
            <td><Button color="btn-danger" text="delete" @btn-click="deleteLine(report)" /></td>
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
        currentPage: Number
    },
    methods: {
        editLine(report) {
            this.$emit('edit-report', report.id)
        },
        deleteLine(report) {
          this.$emit('delete-report', report.id)
        },
        getNextPage(page) {
          this.$emit('get-page', page + 1)
        },
        getPrevPage(page) {
          this.$emit('get-page', page - 1)
        }
    },
    emits: [
      'edit-report',
      'delete-report',
      'get-page'
    ]
}
</script>

<style>

</style>