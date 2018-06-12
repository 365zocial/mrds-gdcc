<?php

/*
*
* for config Api path
*
*/

return [

    /*
    *
    *for set path file (server or localhost)
    *
    */

    # for pgcp export
    // localhost
    'export_pgcp_file_path'             =>          '/public/',
    // server
    // 'export_pgcp_file_path'             =>          '/',

    # for export record excel
    // localhost
    // 'export_record_file_path'             =>          public_path("export_result_record"),
    // server
    'export_record_file_path'             =>          '/var/www/html/mrds_file/export_result_record',

    # for export log
    // localhost
    'export_systemlog_file_path'             =>          public_path("export_systemlog"),
    // server
    // 'export_systemlog_file_path'             =>          '/var/www/html/export_systemlog',

];
