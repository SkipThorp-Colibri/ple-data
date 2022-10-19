<template>
    <div class="container" id="bulk-input-container">
        <h3>Bulk Input</h3>
        <hr />
        <form class="text-left">
            <div class="form-row">
                
                <div class="col">
                    <h5>Paste CSV data</h5>
                    <textarea id="bulk-input-text" style="width: 100%; height: 200px;" v-model="csvText"></textarea>
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
            report: Object        }
    },
    methods: {
        onProcessBulk() {
            const csv = this.csvText
            let processedBulk = []

            let csvRecords = this.parseRecords(csv)

            csvRecords.forEach((rec, index) => {
                let csvRecord = this.parseSingleRecord(rec)
                console.log(csvRecord)
                processedBulk.push(csvRecord)
            })
            console.log(processedBulk)

            csvRecords.forEach((record) => {
                report.departments = []
                report.emails = []
                report.subject = ''

                console.log(report)
            })
        },
        parseRecords(records) {
            return records.split('\n')
        },
        parseSingleRecord(text) {
            text =  text.split('","')
            text.forEach((value, index) => {
                text[index] = value.replace('"','')
            })
            return text
        },
        closeBulkInput() {
            this.$emit('close-bulk-input')
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