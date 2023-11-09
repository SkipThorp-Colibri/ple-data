export function convertToSqlText() {
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
    }
export function downloadSql() {
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