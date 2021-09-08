<template>
  <Navbar />
  <AddReport v-if="showAddReport" @add-new-report="addNewReportToList" @close-add-report="showAddReport = false" />
  <EditReport v-if="showEditReport" :report="selectedReport" @close-edit-report="showEditReport = false" />
  <div class="container">
    <div class="text-left" style="margin-top: 1rem;">
      <Button text="new report" color="btn-primary" @btn-click="toggleAddReport" />
    </div>
    <ReportsTable :reports="reports" @edit-report="editReport" />
  </div>
</template>

<script>
import AddReport from './components/AddReport.vue'
import Button from './components/Button.vue'
import EditReport from './components/EditReport.vue'
import Navbar from './components/Navbar.vue'
import ReportsTable from './components/ReportsTable.vue'

export default {
  name: 'App',
  components: {
    AddReport,
    Button,
    EditReport,
    Navbar,
    ReportsTable
  },
  data() {
    return {
      reports: [],
      showAddReport: false,
      showEditReport: false,
      selectedReport: null,
      isEdit: false
    }
  },
  methods: {
    toggleAddReport() {
      this.showAddReport = !this.showAddReport
      if(this.showAddReport) {
        this.showEditReport = false
      }
    },
    async addNewReportToList(report) {
      this.toggleAddReport()
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
    editReport(id) {
      console.log('edit report', id)
      this.showEditReport = true
      this.showAddReport = false
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
  async mounted() {
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
}
</style>
