export function closeAll() {
    this.showAddReport = false
    this.showEditReport = false
    this.showBulkInput = false
    this.showBulkEmailAdd = false
}

export async function addNewReportToList(report,jsonReport) {
    const reports = [];

    this.closeAll()

    const stringifyReport = JSON.stringify(jsonReport)

    const res = await fetch('/public/php-api/reports_api.php?action=create', {
      headers: {
        'Content-type': 'application/json'
      },
      body: stringifyReport
    })
    const data = await res.json()
    reports = [...reports, data]
    this.addReportToUpdateList(data)
  }

  export async function addBulkReportsToList(reports) {
    for(let i = 0;i < reports.length;i++){
      await this.addNewReportToList(reports[i])
    }
  }

  export async function onEditReport(report) {
    this.toggleEditReport()
    
    const stringifyReport = JSON.stringify(report)

    const res = await fetch(`/public/php-api/reports_api.php?action=update&id=${id}`, {
      headers: {
        'Content-type': 'application/json'
      },
      body: stringifyReport
    })
    const data = await res.json()

    let updatedItemIndex = this.reports.findIndex(r => r.id === data.id)
    this.reports[updatedItemIndex] = data
    this.addReportToUpdateList(data)
  }

  export async function onDeleteReport(id) {
    const res = await fetch(`/public/php-api/reports_api.php?action=delete&id=${id}`)
  }

  export async function editReport(id) {
    this.selectedReport = await this.fetchReport(id)
    this.showEditReport = true
    this.showAddReport = false
    document.body.scrollTop = document.documentElement.scrollTop = 0
  }
  
  export async function deleteReport(id) {
    let report = await this.fetchReport(id)

    if(confirm(`Do you want to delete ${report.subject}`)) {
        this.reports = this.reports.filter((r) => r.id !== id)
    }
    this.onDeleteReport(id)
  }

  export async function fetchReports() {
    const res = await fetch('/public/php-api/reports_api.php?action=read')
    const data = await res.json()
    return data
  }
  
  export async function fetchReport(id) {
    const res = await fetch(`/public/php-api/reports_api.php?action=readSingle&id=${id}`)
    const data = await res.json()
    return data
  }
  
  export async function addReportToUpdateList(report) {
    this.reportsUpdate = [...this.reportsUpdate, report]
  }
  
  export async function clearUpdateList() {
    this.reportsUpdate = []
  }