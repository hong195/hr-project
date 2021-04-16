<template>
  <json-excel
    class="btn btn-default"
    :data="excelData"
    :fields="headersPdf"
    worksheet="My Worksheet"
    name="filename.xls"
  >
    <v-btn outlined large>
      Скачать <v-icon color="green">
        mdi-file-excel
      </v-icon>
    </v-btn>
  </json-excel>
</template>
<script>
  import JsonExcel from 'vue-json-excel'
  export default {
    name: 'ExportToPdf',
    components: {
      JsonExcel,
    },
    props: ['headersPdf', 'excelData'],
  }
</script>
