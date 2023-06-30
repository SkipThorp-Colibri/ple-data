<template>
    <div class="container" id="bulk-input-container">
        <h3>Bulk Input</h3>
        <hr />
        <form class="text-left">
            <div class="form-row">
                
                <div class="col">
                    <h5>Paste TSV data from Excel</h5>
                    <textarea id="bulk-input-text" style="width: 100%; height: 200px;" v-model="tsvText"></textarea>
                </div>
                
            </div>
            <hr />
            <div class="form-row">
                <Button text="process bulk" color="btn-success" @btn-click="onProcessBulk" />
                <Button text="cancel" color="btn-danger" @btn-click="closeBulkInput" class="ml-1" />
            </div>
        </form>
    </div>
</template>

<script>
import Button from './Button.vue'

export default {
    name: "BulkInput",
    components: {
        Button
    },
    data() {
        return {
            tsvText: ''
        }
    },
    methods: {
        onProcessBulk() {
            const tsv = this.tsvText
            let result = []
            let tsvLines = tsv.split('\n')

            tsvLines.forEach(line => {
                let lineObj = {}
                let tsvLine = line.split('\t')

                let departments = tsvLine[0].split('%')
                let cleanDepts = []
                departments.forEach((dept) => {
                    cleanDepts = [ ...cleanDepts, this.cleanDepartment(dept) ]
                })

                let emails = tsvLine[1].split(';')
                let cleanEmails = []
                emails.forEach((email) => {
                    cleanEmails = [ ...cleanEmails, this.cleanEmail(email) ]
                })

                let subject = tsvLine[2]
                let cleanSubject = ''
                if(subject == undefined || subject == '') {
                    cleanSubject = this.createSubject(departments[0])
                } else {
                    cleanSubject = subject.replace(/\u2013|\u2014/g, "-")
                    cleanSubject = cleanSubject.replace(/ - /g,"_")
                    cleanSubject = cleanSubject.replace(/,/g," ")
                    cleanSubject = cleanSubject.replace(/ /g,"_")
                    cleanSubject = cleanSubject.replace(/__/g,"_")
                    cleanSubject = cleanSubject.trim()
                }

                lineObj["departments"] = cleanDepts
                lineObj["emails"] = cleanEmails
                lineObj["subject"] = cleanSubject

                lineObj["rowsort"] = 0
                lineObj["cc_email"] = ""
                lineObj["columnsort"] = 0
                lineObj["login_filter"] = 0
                lineObj["completion_filter"] = 0
                lineObj["remove_button"] = 0
                lineObj["course_type_only"] = 0
                lineObj["ple_only"] = 0
                lineObj["summary_only"] = 0
                
                result.push(lineObj)
            })
            
            this.$emit('add-bulk-reports', result)
        },
        parseRecords(records) {
            return records.split('\n')
        },
        parseSingleRecord(text) {
            return text.split('\t')
        },
        closeBulkInput() {
            this.$emit('close-bulk-input')
        },
        createSubject(subjectText) {
            subjectText = subjectText.replace(/\u2013|\u2014/g, "-")
            subjectText = subjectText.replace(/ - /g,"_")
            subjectText = subjectText.replace(/,/g," ")
            subjectText = subjectText.replace(/ /g,"_")
            subjectText = subjectText.replace(/__/g,"_")

            return subjectText.trim()
        },
        cleanDepartment(dept) {
            let newDept = dept.trim()

            if(newDept != '' && newDept != undefined){
                newDept = newDept.replace(/\u2013|\u2014/g, "-")
                newDept = newDept.replace(/^a-zA-Z0-9 ]/g, '')
            }

            return newDept
        },
        cleanEmail(email) {
            let newEmail = email.trim()
            if(newEmail != '' && newEmail != undefined){
                newEmail = newEmail.toLowerCase()
            }
            return newEmail
        }
    }
}
</script>

<style scoped>
    button {
        margin-top: 1rem;
    }
    #bulk-input-container {
        background-color: #eeeeee;
        padding: 1rem;
    }
    ul {
        list-style: none;
        padding-left: 0;
    }
</style>