<template>
    <div class="container" id="bulk-input-container">
        <h3>Bulk Input</h3>
        <hr />
        <form class="text-left">
            <div class="form-row">
                
                <div class="col">
                    <h5>Paste TSV data</h5>
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
            report: []
        }
    },
    methods: {
        onProcessBulk() {
            const headers = ["departments","emails","subject"]
            const tsv = this.tsvText
            let result = []
            let tsvLines = tsv.split('\n')

            tsvLines.forEach(line => {
                let lineObj = {}
                let tsvLine = line.split('\t')

                lineObj[headers[0]] = tsvLine[0].split('%')
                lineObj[headers[1]] = tsvLine[1].split(';')
                lineObj[headers[2]] = tsvLine[2]

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