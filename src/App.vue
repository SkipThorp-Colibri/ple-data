<template>
  <AddReport />
  
  <div class="container">
    <div class="text-left" style="margin-top: 1rem;">
      <button type="button" class="btn btn-primary btn-sm mb-2">new report</button>
    </div>
    
    <ReportsTable :reports="reports" />
  </div>
</template>

<script>
import AddReport from './components/AddReport.vue'
import ReportsTable from './components/ReportsTable.vue'

export default {
  name: 'App',
  components: {
    AddReport,
    ReportsTable
  },
  data() {
    return {
      reports: []
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
