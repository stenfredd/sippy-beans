/*=========================================================================================
    File Name: datatables-basic.js
    Description: Basic Datatable
    ----------------------------------------------------------------------------------------
    Item Name: Vuexy  - Vuejs, HTML & Laravel Admin Dashboard Template
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

$(document).ready(function() {

    /****************************************
    *       js of zero configuration        *
    ****************************************/
   $('.configuration').DataTable({
        "paging":   true,
        "info":     true,
        "ordering": true,
    });
    $('.zero-configuration').DataTable({
        "paging":   true,
        "info":     true,

    });
    $('.table-pagenation-section').DataTable({
        "paging":   true,
        "ordering": false,
        "info":      true,
        

    });
    $('.table-pagenation').DataTable({
        "paging":   true,
        "ordering": false,
        "info":      true,

    });

});
