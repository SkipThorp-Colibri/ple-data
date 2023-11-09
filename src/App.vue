<template>
  <Navbar />
  <div class="container-fluid" id="main-reports-container">
    <AddReport v-if="showAddReport" @add-new-report="addNewReportToList" @close-add-report="showAddReport = false" />
    <EditReport v-if="showEditReport" @submit-edit-report="onEditReport" :report="selectedReport" @close-edit-report="showEditReport = false" />
    <BulkInput v-if="showBulkInput" @add-bulk-reports="addBulkReportsToList" @close-bulk-input="showBulkInput = false"></BulkInput>
    <BulkEmailAdd v-if="showBulkEmailAdd" @close-bulk-email-input="showBulkEmailAdd = false" />


    <div class="text-left">
      <Button text="new report" color="btn-primary" @btn-click="toggleAddReport" />
      <Button text="bulk input" color="btn-info" style="margin-left: 1rem;" @btn-click="toggleBulkInput" />
      <Button text="add email to reports" color="btn-info" style="margin-left: 1rem;" @btn-click="toggleBulkEmailAdd" />
    </div>
    
    <UpdateTable :reportsUpdate="reportsUpdate" @clear-update-list="clearUpdateList" />

    <ReportsTable :reports="reports" @edit-report="editReport" @delete-report="deleteReport" />
  </div>
</template>

<script>
import BulkEmailAdd from './components/BulkEmailAdd.vue'
import AddReport from './components/AddReport.vue'
import BulkInput from './components/BulkInput.vue'
import Button from './components/Button.vue'
import EditReport from './components/EditReport.vue'
import Navbar from './components/Navbar.vue'
import ReportsTable from './components/ReportsTable.vue'
import UpdateTable from './components/UpdateTable.vue'
import {
  closeAll,
  addNewReportToList,
  addBulkReportsToList,
  onEditReport,
  onDeleteReport,
  editReport,
  deleteReport,
  fetchReports,
  fetchReport,
  addReportToUpdateList,
  clearUpdateList
} from './js/methods.js'

export default {
  name: 'App',
  components: {
    BulkEmailAdd,
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
      showBulkEmailAdd: false,
      selectedReport: {},
      isEdit: false,
      sqlContent: ''
    }
  },
  methods: {
    toggleAddReport() {
      if(this.showAddReport) {
        closeAll()
      } else {
        this.showAddReport = !this.showAddReport
      }      
    },
    toggleEditReport() {
      if(this.showEditReport) {
        closeAll()
      } else {
        this.showEditReport = !this.showEditReport
      }    },
    toggleBulkInput() {
      if(this.showBulkInput) {
        closeAll()
      } else {
        this.showBulkInput = !this.showBulkInput
      }
    },
    toggleBulkEmailAdd() {
      if(this.showBulkEmailAdd) {
        closeAll()
      } else {
        this.showBulkEmailAdd = !this.showBulkEmailAdd
      }
    },
    async addNewReportToList(report) {

      closeAll()

      const stringifyReport = JSON.stringify(report)

      const res = await addNewReportToList(report)
      const data = await res.json()
      this.reports = [...this.reports, data]
      addReportToUpdateList(data,stringifyReport)
    },
    async addBulkReportsToList(reports) {
      for(let i = 0;i < reports.length;i++){
        await this.addNewReportToList(reports[i])
      }
    },
    async onEditReport(report) {
      this.toggleEditReport()
      
      const stringifyReport = JSON.stringify(report)

      const res = await editReport(report)
      const data = await res.json()

      let updatedItemIndex = this.reports.findIndex(r => r.id === data.id)
      this.reports[updatedItemIndex] = data
      this.addReportToUpdateList(data)
    },
    async onDeleteReport(id) {
      let report = await this.fetchReport(id)

      if(confirm(`Do you want to delete ${report.subject}`)) {
          this.reports = this.reports.filter((r) => r.id !== id)
      }
      this.deleteReport(id)      
    },
    async deleteReport(id) {
      const res = await deleteReport(id)
    },
    async fetchReport(id) {
      const res = await fetchReport(id)
      return res.json()
    },
    async addReportToUpdateList(report) {
      this.reportsUpdate = [...this.reportsUpdate, report]
    },
    clearUpdateList() {
      this.reportsUpdate = []
    }
  },
    async mounted() {
      this.reports = await fetchReports()
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

#main-reports-container {
  margin-top: 4rem;
}

</style>