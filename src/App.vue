<template>
  <div v-show="showAddNewReport">
    <AddReport @add-new-report="addNewReportToList" />
  </div>
  
  
  <div class="container">
    <div class="text-left" style="margin-top: 1rem;">
      <Button text="new report" color="btn-primary" @btn-click="toggleAddReport" />
    </div>
    
    <ReportsTable :reports="reports" />
  </div>
</template>

<script>
import AddReport from './components/AddReport.vue'
import Button from './components/Button.vue'
import ReportsTable from './components/ReportsTable.vue'

export default {
  name: 'App',
  components: {
    AddReport,
    Button,
    ReportsTable
  },
  data() {
    return {
      reports: [],
      showAddNewReport: false
    }
  },
  methods: {
    toggleAddReport() {
      this.showAddNewReport = !this.showAddNewReport
    },
    addNewReportToList(report) {
      this.toggleAddReport()
      console.log("received new report", report)
      this.reports = [...this.reports, report]
    }
  },
  created() {
    this.reports = [
      { 
        subject: "Aflac ND/SD", 
        departments: ["Aflac SD - Amber Lind Agency","Aflac ND - Ellie Papineau Agency"],
        emails: ["mdevans@aflac.com","LThorson@aflac.com"] 
      },
      { 
        subject: "Report 2", 
        departments: ["Aflac SD - Craig Stadtfeld Agency","Aflac ND - Lynn Brokaw Agency","Aflac SD - Shon Ford Agency"],
        emails: ["cnewell@aflac.com"] 
      }
    ]
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
