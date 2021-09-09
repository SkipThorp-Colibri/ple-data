<template>
    <div id="updateTableContainer">
    <table class="table">
        <thead>
        <tr>
            <th class="text-left" scope="col">CSV text</th>
        </tr>
        </thead>
        <tbody>
            <tr v-for="report in reportsUpdate" :key="report.id">
                <td class="text-left">{{report.id}} | {{report.subject}} | {{report.departments.join(', ')}} | {{report.emails.join(', ')}}</td>
            </tr>
        </tbody>
    </table>
    <Button text="download update csv" color="btn-success" @btn-click="downloadCsv" />
    <Button text="refresh" class="ml-1" color="btn-info" @btn-click="convertToCsvText" />
    <Button text="clear" class="ml-1" color="btn-danger" @btn-click="clearUpdateContent" />
  </div>
</template>

<script>
import Button from './Button.vue'

export default {
    name: "UpdateTable",
    components: {
        Button
    },
    props: {
        reportsUpdate: Array,
    },
    data() {
        return {
            csvContent: ''
        }
    },
    methods: {
        convertToCsvText() {
            this.csvContent = "data:text/csv;charset=utf-8,"
            this.reportsUpdate.forEach((report) => {
                console.log('in reportsUpdate')
                var row = ''
                row += report.id + ','
                report.departments.forEach((dept,i) => {
                    if(i > 0) {
                        row += '%'
                    }
                    row += dept
                })
                row += ','
                report.emails.forEach((email,i) => {
                    if(i > 0) {
                        row += ';'
                    }
                    row += email
                })
                row += ','
                row += report.subject + '\r\n'
                this.csvContent += row
            })
        },
        downloadCsv() {
            this.convertToCsvText()

            var encodedUri = encodeURI(this.csvContent);
            var link = document.createElement("a");
            link.setAttribute("href", encodedUri);
            link.setAttribute("download", "Output_Update.csv");
            document.body.appendChild(link); // Required for FF

            link.click(); // This will download the data file named "Output_Update.csv".
        },
        clearUpdateContent() {
            this.csvContent = ''
            this.$emit('clear-update-list')
        }
    }
}
</script>

<style scoped>
    #updateTableContainer {
        background-color: lightblue;
    }
</style>