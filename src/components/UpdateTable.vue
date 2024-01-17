<template>
    <div id="updateTableContainer" v-if="couponsUpdate.length > 0">
    <table class="table">
        <thead>
        <tr>
            <th class="text-left" scope="col">Updated Items</th>
        </tr>
        </thead>
        <tbody>
            <tr v-for="coupon in couponsUpdate" :key="coupon.id">
                <td class="text-left">{{coupon.id}} | {{coupon.departments.join(', ')}} | {{coupon.emails.join(', ')}} | {{coupon.subject}}</td>
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
        couponsUpdate: Array,
    },
    data() {
        return {
            csvContent: ''
        }
    },
    methods: {
        convertToCsvText() {
            this.couponsUpdate.forEach((coupon) => {
                var row = ''
                row += coupon.id
                row += ',"' + coupon.departments.join('%') + '"'
                row += ',"' + coupon.emails.join(';') + '"'
                row += `,${coupon.subject}`
                row += `,${coupon.rowsort}`
                row += `,${coupon.cc_email}`
                row += `,${coupon.columnsort}`
                row += `,${coupon.login_filter}`
                row += `,${coupon.completion_filter}`
                row += `,${coupon.remove_button}`
                row += `,${coupon.course_type_only}`
                row += `,${coupon.ple_only}`
                row += `,${coupon.summary_only === 1 ? 1 : 0}\r\n`

                this.csvContent += row

            })
        },
        downloadCsv() {
            this.convertToCsvText()

            var a = document.createElement("a")
            document.body.appendChild(a)
            a.style = "display: none"
            var blob = new Blob([this.csvContent], {type: "text/csv"}), url = window.URL.createObjectURL(blob)
            a.href = url
            a.download = "Output_Update.csv"
            a.click()
            window.URL.revokeObjectURL(url)
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
        background-color: rgb(224, 246, 255);
        margin-bottom: 3rem;
    }
</style>