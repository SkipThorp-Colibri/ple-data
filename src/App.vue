<template>
  <Navbar />
  <AddReport v-if="showAddReport" @add-new-report="addNewReportToList" @close-add-report="showAddReport = false" />
  <EditReport v-if="showEditReport" @submit-edit-report="onEditReport" :report="selectedReport" @close-edit-report="showEditReport = false" />
  <BulkInput v-if="showBulkInput" @add-bulk-reports="addBulkReportsToList" @close-bulk-input="showBulkInput = false"></BulkInput>
  <div class="container-fluid">
    <div class="text-left" style="margin-top: 1rem;">
      <Button text="new report" color="btn-primary" @btn-click="toggleAddReport" />
      <Button text="bulk input" color="btn-info" style="margin-left: 1rem;" @btn-click="toggleBulkInput" />
    </div>
    

    <UpdateTable :reportsUpdate="reportsUpdate" @clear-update-list="clearUpdateList" />

    <ReportsTable :reports="reports" @edit-report="editReport" @delete-report="deleteReport" />
  </div>
</template>

<script>
import AddReport from './components/AddReport.vue'
import BulkInput from './components/BulkInput.vue'
import Button from './components/Button.vue'
import EditReport from './components/EditReport.vue'
import Navbar from './components/Navbar.vue'
import ReportsTable from './components/ReportsTable.vue'
import UpdateTable from './components/UpdateTable.vue'

export default {
  name: 'App',
  components: {
    AddReport,
    BulkInput,
    Button,
    EditReport,
    Navbar,
    ReportsTable,
    UpdateTable
  },
  data() {
    return {
      reports: [],
      reportsUpdate: [],
      showAddReport: false,
      showEditReport: false,
      showBulkInput: false,
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
    toggleEditReport() {
      this.showEditReport = !this.showEditReport
    },
    toggleBulkInput() {
      this.showBulkInput = !this.showBulkInput
      if(this.showBulkInput) {
        this.showEditReport = false
      }
    },
    async addNewReportToList(report) {

      this.showAddReport = false
      this.showBulkInput = false

      const stringifyReport = JSON.stringify(report)

      const res = await fetch('http://localhost:5000/reports', {
        method: 'POST',
        headers: {
          'Content-type': 'application/json'
        },
        body: stringifyReport
      })
      const data = await res.json()
      this.reports = [...this.reports, data]
      this.addReportToUpdateList(data)
    },
    async addBulkReportsToList(reports) {
      for(let i = 0;i < reports.length;i++){
        await this.addNewReportToList(reports[i])
      }
    },
    async onEditReport(report) {
      this.toggleEditReport()
      
      const stringifyReport = JSON.stringify(report)

      const res = await fetch(`http://localhost:5000/reports/${report.id}`, {
        method: 'PUT',
        headers: {
          'Content-type': 'application/json'
        },
        body: stringifyReport
      })
      const data = await res.json()

      let updatedItemIndex = this.reports.findIndex(r => r.id === data.id)
      this.reports[updatedItemIndex] = data
      this.addReportToUpdateList(data)
    },
    async onDeleteReport(id) {
      const res = await fetch(`http://localhost:5000/reports/${id}`, {
        method: 'DELETE'
      })
    },
    async editReport(id) {
      this.selectedReport = await this.fetchReport(id)
      this.showEditReport = true
      this.showAddReport = false
      document.body.scrollTop = document.documentElement.scrollTop = 0
    },
    async deleteReport(id) {
      let report = await this.fetchReport(id)

      if(confirm(`Do you want to delete ${report.subject}`)) {
          this.reports = this.reports.filter((r) => r.id !== id)
      }
      this.onDeleteReport(id)
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
    },
    async addReportToUpdateList(report) {
      this.reportsUpdate = [...this.reportsUpdate, report]
    },
    clearUpdateList() {
      this.reportsUpdate = []
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
