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
      <!-- <Button text="convert to mySQL" color="btn-info" style="margin-left: 1rem;" @btn-click="downloadSql" /> -->
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

      const res = await fetch('http://prepare2pass.com/p2p_db/ple_reports_data', {
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

      const res = await fetch(`http://prepare2pass.com/p2p_db/ple_reports_data/${report.id}`, {
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
      const res = await fetch(`http://prepare2pass.com/p2p_db/ple_reports_data/${id}`, {
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
    // async fetchReports() {
    //   const res = await fetch('http://localhost:5000/reports')
    //   const data = await res.json()
    //   return data
    // },
    async fetchReports() {
      const res = await fetch('/src/api/index.php')
      const data = await res.json()
      return data
    },
    async fetchReport(id) {
      const res = await fetch(`http://prepare2pass.com/p2p_db/ple_reports_data/${id}`)
      const data = await res.json()
      return data
    },
    async addReportToUpdateList(report) {
      this.reportsUpdate = [...this.reportsUpdate, report]
    },
    clearUpdateList() {
      this.reportsUpdate = []
    },
    convertToSqlText() {
      console.log("entering convertToSqlText funtion")
      this.sqlContent = 'INSERT INTO `ple_reports_data` VALUES\r\n'
        this.reports.forEach((report,idx) => {
            var row = ''
            row += '(' + report.id
            row += `,'` + report.departments.join('%') + `'`
            row += `,'` + report.emails.join(';') + `'`
            row += `,'` + report.subject + `'`
            row += `,${report.rowsort}`
            row += `,${report.cc_email}`
            row += `,${report.columnsort}`
            row += `,${report.login_filter}`
            row += `,${report.completion_filter}`
            row += `,${report.remove_button}`
            row += `,${report.course_type_only}`
            row += `,${report.ple_only}`
            row += `,${report.summary_only === 1 ? 1 : 0}`
            row += parseInt(idx) < this.reports.length ? '),\r\n' : ')\r\n'

            this.sqlContent += row

        })
    },
    downloadSql() {
      console.log("downloadSql clicked")
        this.convertToSqlText()

        var a = document.createElement("a")
        document.body.appendChild(a)
        a.style = "display: none"
        var blob = new Blob([this.sqlContent], {type: "text/sql"}), url = window.URL.createObjectURL(blob)
        a.href = url
        a.download = "SQL_Update.sql"
        a.click()
        window.URL.revokeObjectURL(url)
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

#main-reports-container {
  margin-top: 4rem;
}

</style>