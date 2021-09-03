<template>
  <div v-show="showEditReport">
    <EditReport @add-new-report="addNewReportToList" :report="selectedReport" />
  </div>
  <div class="container">
    <div class="text-left" style="margin-top: 1rem;">
      <Button text="new report" color="btn-primary" @btn-click="toggleEditReport" />
    </div>
    <ReportsTable :reports="reports" @edit-report="editReport" />
  </div>
</template>

<script>
import EditReport from './components/EditReport.vue'
import Button from './components/Button.vue'
import ReportsTable from './components/ReportsTable.vue'

export default {
  name: 'App',
  components: {
    EditReport,
    Button,
    ReportsTable
  },
  data() {
    return {
      reports: [],
      showEditReport: false,
      selectedReport: null
    }
  },
  methods: {
    toggleEditReport() {
      this.showEditReport = !this.showEditReport
    },
    async editReport(id) {
      this.selectedReport = await this.fetchReport(id)
      this.showEditReport = true
    },
    async addNewReportToList(report) {
      this.toggleEditReport()
      const stringifyReport = JSON.stringify(report)

      const res = await fetch('http://localhost:5000/reports', {
        method: 'POST',
        headers: {
          'Content-type': 'application/json'
        },
        body: JSON.stringify(report)
      })
      const data = await res.json()
      this.reports = [...this.reports, data]
    },
    async fetchReports() {
      const res = await fetch('http://localhost:5000/reports')
      const data = await res.json()
      return data
    },
    async fetchReport(id) {
      const res = await fetch(`http://localhost:5000/reports/${id}`)
      const data = await res.json()
      return data
    }
  },
  async created() {
    this.reports = await this.fetchReports()
  }
}
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}
</style>
