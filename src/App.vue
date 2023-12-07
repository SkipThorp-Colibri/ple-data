<template>
  <Navbar 
    @search-reports="searchReports" 
    @reset-reports="fetchReports"
  />
  <div class="container-fluid" id="main-reports-container">
    <AddReport 
      v-if="showAddReport" 
      @add-new-report="addNewReportToList" 
      @close-add-report="showAddReport = false" 
    />
    <EditReport 
      v-if="showEditReport" 
      @submit-edit-report="onEditReport" 
      :report="selectedReport" 
      @close-edit-report="showEditReport = false" 
    />
    <BulkInput 
      v-if="showBulkInput" 
      @add-bulk-reports="addBulkReportsToList" 
      @close-bulk-input="showBulkInput = false" 
    />
    <BulkEmailAdd 
      v-if="showBulkEmailAdd" 
      @close-bulk-email-input="showBulkEmailAdd = false" 
    />

    <div class="text-left">
      <Button 
        text="new report" 
        color="btn-primary" 
        @btn-click="toggleAddReport" 
      />
      <Button 
        text="bulk input" 
        color="btn-info" 
        style="margin-left: 1rem;" 
        @btn-click="toggleBulkInput" 
      />
      <Button 
        text="add email to reports" 
        color="btn-info" 
        style="margin-left: 1rem;" 
        @btn-click="toggleBulkEmailAdd"       
      />
    </div>
    
    <UpdateTable 
      :reportsUpdate="reportsUpdate" 
      @clear-update-list="clearUpdateList" 
    />

    <ReportsTable 
      :reports="reports" 
      :currentPage="currentPage" 
      :totalPages="totalPages" 
      @edit-report="editReport" 
      @delete-report="deleteReport" 
      @get-page="fetchReports" 
    />
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
      currentPage: 0,
      totalPages: 0,
      searchTerm: String,
      reportsUpdate: [],
      showAddReport: false,
      showEditReport: false,
      showBulkInput: false,
      showBulkEmailAdd: false,
      selectedReport: {},
      isEdit: false
    }
  },
  methods: {
    closeAll() {
      this.showAddReport = false
      this.showEditReport = false
      this.showBulkInput = false
      this.showBulkEmailAdd = false
    },
    toggleAddReport() {
      if(this.showAddReport) {
        this.closeAll()
      } else {
        this.showAddReport = !this.showAddReport
      }      
    },
    toggleEditReport() {
      if(this.showEditReport) {
        this.closeAll()
      } else {
        this.showEditReport = !this.showEditReport
      }    },
    toggleBulkInput() {
      if(this.showBulkInput) {
        this.closeAll()
      } else {
        this.showBulkInput = !this.showBulkInput
      }
    },
    toggleBulkEmailAdd() {
      if(this.showBulkEmailAdd) {
        this.closeAll()
      } else {
        this.showBulkEmailAdd = !this.showBulkEmailAdd
      }
    },
    async addNewReportToList(report) {

      this.closeAll()

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
    async searchReports(term) {
      this.searchTerm = term
      this.reports = []
      const res = await fetch(`http://localhost:5000/reports?q=${this.searchTerm}`)
      const data = await res.json()
      this.reports = data
    },
    async fetchReports(obj) {
      this.currentPage = obj.page
      this.reports = []
      const res = await fetch(`http://localhost:5000/reports?_page=${obj.page}&_limit=${obj.take}`)
      const data = await res.json()
      this.reports = data
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
    this.currentPage = 1
    await this.fetchReports({ "page": this.currentPage, "take": 100 })
    this.totalPages = Math.ceiling(reports.length / 100)
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