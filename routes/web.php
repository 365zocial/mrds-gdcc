<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

# For Reclaim Loan Specimen.
Route::get('reclaim/loan_specimen', 'LoanController@emailReclaim');

Route::group(['middleware' => ['CheckAuthened']], function () {
    # เข้าใช้งาน โดย user (คนทั่วไป) ไม่ต้อง login
    Route::get('/', 'UserController@dashboard');
    Route::post('sendEmailToAdmin', 'MailboxController@sendEmailToAdmin'); //Ajax

    Route::group(['prefix' => 'search'], function () {
        #------------------------#
        # Search Category C Type #
        #------------------------#
        Route::post('getTaxonomyName', 'AjaxController@getTaxonomyName'); //AjaxController
        Route::get('diversity', 'SearchTypeCController@searchDiversity');
        Route::get('distribution', 'SearchTypeCController@searchDistribution');
        Route::post('distribution', 'SearchTypeCController@getDistribution');
        Route::post('distributiondatatable', 'SearchTypeCController@distributionAsDataTable')->name('distribution.datatable'); //Ajax
        Route::post('diversityCAsDataTable', 'SearchTypeCController@diversityCAsDataTable')->name('typec.diversity.datatable'); //Ajax
        Route::post('recentRecordCAsDataTable', 'SearchTypeCController@recentRecordCAsDataTable')->name('typec.recent.datatable'); //Ajax
        Route::post('nameRecordCAsDataTable', 'SearchTypeCController@nameRecordCAsDataTable')->name('typec.record.datatable'); //Ajax
        Route::get('recentrecord', 'SearchTypeCController@searchRecent');
        Route::post('searchdata', 'SearchTypeCController@search'); //Ajax
        Route::get('NameRecord', 'SearchTypeCController@searchByNameRecord');
        Route::post('doNameRecord', 'SearchTypeCController@doSearchNameRecord'); //Ajax

        Route::post('exportSearchTypeA', 'ExportRecordController@exportSearchTypeA'); //Ajax
        Route::post('exportDistributionSearch', 'ExportRecordController@exportDistributionSearch')->name('typec.distribution.export'); //Ajax

    });

    Route::group(['prefix' => 'abbreviation'], function () {
        Route::get('/', 'UserController@dashboardAbbreviation');
        Route::get('referenceLoan', 'WordingController@referenceLoan');
        Route::get('collectionCode', 'WordingController@collectionForUser');
        Route::get('MarineCenter', 'WordingController@MarineCenterForUser');
    });
});

Route::get('setLangThai', 'AuthenController@setLanguageTH');
Route::get('setLangEng', 'AuthenController@setLanguageEN');

Route::get('profile', 'UserController@viewProfile');
Route::get('editprofile', 'UserController@editProfile');
Route::post('editprofile', 'UserController@doEditProfile');
Route::get('editpassword', 'UserController@editPassword');
Route::post('editpassword', 'UserController@doEditPassword');

# For show img when search
Route::post('recordPicture', 'AjaxController@getRecordPicture');    //AjaxController

include_once('authen.php');
Route::group(['middleware' => ['Authen']], function () {

    Route::post('exportSearchTypeA', 'ExportRecordController@exportSearchTypeA'); //Ajax
    Route::post('deleteFileForExcelRecord', 'ExportRecordController@deleteFileForExcelRecord'); //Ajax

    Route::group(['prefix' => 'staff'], function () {
        Route::post('getInfoClassification', 'AjaxController@getInfoClassification'); //AjaxController
        Route::post('getTaxonomyName', 'AjaxController@getTaxonomyName'); //AjaxController
        Route::post('searchname', 'StaffController@searchByName');
        //Route::post('getNospecies', 'AjaxController@getLastDuplicationPublication');  //AjaxController

        Route::get('dashboard', 'StaffController@dashboard');

        /*
        *
        * CheckAdmin
        *
        */
        Route::group(['middleware' => 'CheckAdmin'], function () {
            #-------------#
            # Manage User #
            #-------------#
            Route::get('list', 'StaffController@listUser');
            Route::get('add', 'StaffController@addStaff');
            Route::get('edit/{id}', 'StaffController@editStaffById')->where('id', '[0-9]+');
            Route::get('resume/{id}', 'StaffController@resumeUserById')->where('id', '[0-9]+');
            Route::get('delete/{id}', 'StaffController@deleteUserById')->where('id', '[0-9]+');
            Route::post('add', 'StaffController@addStaffAction');
            Route::post('edit/{id}', 'StaffController@editStaffByIdAction')->where('id', '[0-9]+');

            #-----------------------#
            # Manage classification #
            #-----------------------#
            Route::get('editClassificationForm/{id}', 'ClassificationController@editClassificationForm');
            Route::get('manageClassification', 'ClassificationController@manageClassification');
            Route::get('list-Classification', 'ClassificationController@getClassificationDataTable')->name('list.classification.datatable');
            Route::post('doEditClassification', 'ClassificationController@doEditClassification');
            Route::get('changeClassification/{record_id}/{classification_id}', 'ClassificationController@changeClassification');
            Route::post('doChangeClassification', 'ClassificationController@doChangeClassification');
            Route::get('viewClassification/{id}', 'ClassificationController@viewClassification');

            #----------------#
            # Manage wording #
            #----------------#
            Route::get('mainWording', 'WordingController@mainWording');
            Route::group(['prefix' => 'wording'], function () {
                //taxonomy
                Route::get('taxonomyList', 'WordingController@taxonomyList');
                Route::get('list-taxonomy', 'WordingController@getTaxonomyDataTable')->name('list.taxonomy.datatable');

                Route::post('addTaxonomy', 'WordingController@addTaxonomy');
                Route::post('getTaxonomyWording', 'WordingController@getTaxonomyWording');
                Route::post('editTaxonomy', 'WordingController@editTaxonomy');
                //Country
                Route::get('countryList', 'WordingController@countryList');
                Route::post('addCountry', 'WordingController@addCountry');
                Route::post('getCountryWording', 'WordingController@getCountryWording');
                Route::post('editCountry', 'WordingController@editCountry');
                //Province
                Route::get('provinceList', 'WordingController@provinceList');
                Route::post('addProvince', 'WordingController@addProvince');
                Route::post('getProvinceWording', 'WordingController@getProvinceWording');
                Route::post('editProvince', 'WordingController@editProvince');
                //District
                Route::get('districtList', 'WordingController@districtList');
                Route::post('addDistrict', 'WordingController@addDistrict');
                Route::post('getDistrictWording', 'WordingController@getDistrictWording');
                Route::post('editDistrict', 'WordingController@editDistrict');
                //County
                Route::get('countyList', 'WordingController@countyList');
                Route::get('list-county', 'WordingController@getCountyDataTable')->name('list.county.datatable');
                Route::post('addCounty', 'WordingController@addCounty');
                Route::post('getCountyWording', 'WordingController@getCountyWording');
                Route::post('editCounty', 'WordingController@editCounty');
                //Wording
                Route::get('wordingList/{wording?}', 'WordingController@wordingList');
                Route::post('addWording', 'WordingController@addWording');
                Route::post('getWording', 'WordingController@getWording');
                Route::post('editWording', 'WordingController@editWording');
                //Collection
                Route::get('collectionList', 'WordingController@collectionList');
                Route::post('addCollection', 'WordingController@addCollection');
                Route::post('getCollection', 'WordingController@getCollection');
                Route::post('editCollection', 'WordingController@editCollection');
                //Reference
                Route::get('referenceList', 'WordingController@referenceList');
                Route::post('addReference', 'WordingController@addReference');
                Route::post('getReference', 'WordingController@getReference');
                Route::post('editReference', 'WordingController@editReference');
                //Extra Field
                Route::get('extraFieldList', 'WordingController@extraFieldList');
                Route::post('getExtraField', 'WordingController@getExtraField');
                Route::post('editExtraField', 'WordingController@editExtraField');
                //Picture Box
                Route::get('pictureBox', 'WordingController@pictureBox');
                //Picture Box
                Route::post('doUpdatePictureBox/{id}', 'WordingController@doUpdatePictureBox');
            });

            #------------------#
            # Mailbox By Admin #
            #------------------#
            Route::group(['prefix' => 'mailbox'], function () {
                Route::get('dashboard', 'MailboxController@dashboard');
                Route::get('detailMailboxStaff/{id}', 'MailboxController@detailMailboxStaff');
            });

            #------------#
            # Log System #
            #------------#
            Route::group(['prefix' => 'log'], function () {
            });

            #------------------#
            # Group Permission #
            #------------------#
            Route::group(['prefix' => 'permission'], function () {
                Route::get('view', 'GroupPermissionController@viewGroup_Permission');
                Route::post('doUpdatePermission', 'GroupPermissionController@updateGroup_Permission');
            });

            #--------------#
            # Migrate Data #
            #--------------#
            Route::group(['prefix' => 'migdata'], function () {
                Route::get('addfile', 'Migration\Migrate_old_data@index');
                Route::post('uploadsourcedata', 'Migration\Migrate_old_data@getFile');
                Route::get('map', 'Migration\Migrate_old_data@mapUnique_record_picture_record');
                Route::get('addfilethai', 'Migration\MigrateMissingThai@index');
                Route::get('checkfile', 'Migration\Migrate_check@index');

                Route::group(['prefix' => 'v2'], function () {
                    Route::get('import', 'Migration\V2\ImporterController@index');
                });
            });


            #-------------------#
            # System Log Export #
            #-------------------#
            Route::group(['prefix' => 'systemlog'], function () {
                Route::get('search', 'SystemLogController@searchView');
                Route::post('search', 'SystemLogController@getSystemLog');
                Route::get('getLog', function () {
                    $file = public_path('export_systemlog') . "/log.txt";
                    $download_name = basename($file);
                    if (file_exists($file)) {
                        header('Content-Type: application/octet-stream');
                        header('Content-Disposition: attachment; filename=' . $download_name);
                        header('X-Sendfile: ' . $file);
                        readfile($file);
                    }
                });
            });
        });
        /*-- end CheckAdmin --*/


        /*
        *
        * CheckAdminManager
        *
        */
        Route::group(['middleware' => 'CheckAdminManager'], function () {
            #-----------------------#
            # Manage classification #
            #-----------------------#
            Route::get('checkClassificationForm', 'ClassificationController@checkClassificationForm');
            Route::post('addClassificationForm', 'ClassificationController@addClassificationForm');
            Route::post('doAddClassification', 'ClassificationController@doAddClassification');

            #---------------#
            # Manage Record #
            #---------------#
            Route::get('addRecordForm', 'RecordController@addRecordForm');
            Route::post('doAddRecord', 'RecordController@doAddRecord');
            Route::get('addRecordFormTH', 'RecordController@addRecordFormTH');
            Route::post('doAddRecordTH', 'RecordController@doAddRecordTH');
            Route::get('addRecordPicture', 'RecordController@addRecordPicture');
            Route::post('doAddRecordPicture', 'RecordController@doAddRecordPicture');
            Route::post('changeStatus', 'RecordController@ChangeStatus');
            Route::get('list-manageRecord/{type_record}', 'RecordController@getRecordDataTable')->name('list.manage.record');
            Route::get('manageRecord', 'RecordController@manageRecord');
            Route::get('manageRecordPublication', 'RecordController@manageRecordPublication');
            Route::get('manageRecordSpecimens', 'RecordController@manageRecordSpecimens');
            Route::get('editRecordForm/{page}/{record_id}/{type}', 'RecordController@editRecordForm');
            Route::post('doEditRecordForm', 'RecordController@doEditRecordForm');
            Route::get('editRecordFormTH', 'RecordController@editRecordFormTH');
            Route::post('doEditRecordFormTH', 'RecordController@doEditRecordFormTH');
            Route::get('editRecordPicture', 'RecordController@editRecordPicture');
            Route::post('doEditRecordPicture', 'RecordController@doEditRecordPicture');
            Route::get('viewRecord/{id?}', 'RecordController@viewRecord');
            Route::get('approveRecord', 'RecordController@approveRecord');
            Route::get('approveViewRecord/{id?}', 'RecordController@approveViewRecord');
            Route::get('doApproveRecord/{id}', 'RecordController@doApproveRecord');
            Route::post('checkCatalog', 'AjaxController@HeadcheckCatalogIsEmpty');

            #--------------#
            # Ajax Wording #
            #--------------#
            Route::group(['prefix' => 'wording'], function () {
                Route::post('getProvinceInCountry', 'AjaxController@getProvinceInCountry'); //AjaxController
                Route::post('getDistrictInProvince', 'AjaxController@getDistrictInProvince'); //AjaxController
                Route::post('getCountyInDistrict', 'AjaxController@getCountyInDistrict'); //AjaxController
                Route::post('getReferenceByMarineCenterID', 'AjaxController@getReferenceByMarineCenterID'); //AjaxController

            });

            #--------------#
            # Export Label #
            #--------------#
            Route::group(['prefix' => 'export_label'], function () {
                Route::get('form', 'ExportLabelController@form');
                Route::post('export', 'ExportLabelController@export');
            });
        });
        /*-- end CheckAdminManager --*/

        /*
        *
        * CheckManager
        *
        */
        Route::group(['middleware' => 'CheckManager'], function () {
            #--------------------------#
            # Loan Specimen By Manager #
            #--------------------------#
            Route::group(['prefix' => 'loan'], function () {
                # Show Loan Specimen List
                Route::get('dashboard', 'LoanController@managerDashboard');
                # View Loan Specimen Data and Read Comment
                Route::get('view_request/{record_loan_id}', 'LoanController@managerViewRequest');
                # Insert Comment to database
                Route::post('view_request/{record_loan_id}', 'LoanController@managerViewRequestInsert');
                # View Loan Specimen List
                Route::post('update_status/{record_loan_id}', 'LoanController@managerUpdateStatus');
                # View Loan Specimen List
                Route::get('export_loan', 'ExportLoanController@exportLoanManager');
                # Reclaim Record
                Route::post('reclaim/loan_specimen', 'LoanController@emailReclaimRecord');
            });
        });

        /*-- end CheckManager --*/

        /*
        *
        * CheckAdminBoard
        *
        */
        Route::group(['middleware' => 'CheckAdminBoard'], function () {
            #------------------------#
            # Search Category B Type #
            #------------------------#
            Route::group(['prefix' => 'searchCategory'], function () {
                Route::get('viewRecord/{id}', 'SearchTypeBController@viewRecord');
                Route::get('searchDashboard', 'SearchTypeBController@searchBDashboard');
                Route::get('searchByDate', 'SearchTypeBController@searchByDate');
                Route::post('doSearchDate', 'SearchTypeBController@doSearchDate'); //Ajax
                Route::get('searchByDistribution', 'SearchTypeBController@searchByDistribution');
                Route::post('doSearchDistribution', 'SearchTypeBController@doSearchDistribution2');
                Route::get('searchByID', 'SearchTypeBController@searchByID');
                Route::post('doSearchID', 'SearchTypeBController@doSearchID'); //Ajax
                Route::get('searchByKeyword', 'SearchTypeBController@searchByKeyword');
                Route::post('doSearchKeyword', 'SearchTypeBController@doSearchKeyword'); //Ajax
                Route::get('searchByLocality', 'SearchTypeBController@searchByLocality');
                Route::post('doSearchLocality', 'SearchTypeBController@doSearchLocality'); //Ajax
                Route::get('searchByName', 'SearchTypeBController@searchByName');
                Route::post('doSearchName', 'SearchTypeBController@doSearchName'); //Ajax
                Route::get('searchByNameRecord', 'SearchTypeBController@searchByNameRecord');
                Route::post('doSearchNameRecord', 'SearchTypeBController@doSearchNameRecord'); //Ajax
                Route::get('searchByTaxonomy', 'SearchTypeBController@searchByTaxonomy');
                Route::post('doSearchTaxonomy', 'SearchTypeBController@doSearchTaxonomy'); //Ajax
                Route::post('getTaxonomyFromHeaderTaxonomy', 'AjaxController@getTaxonomyFromHeaderTaxonomy'); //AjaxController
                Route::post('getDataLocalityBySearch', 'AjaxController@getDataLocalityBySearch'); //AjaxController
                Route::post('distributiondatatable', 'SearchTypeBController@distributionBAsDataTable')->name('typeb.distribution.datatable'); //Ajax
                Route::post('exportTypeBDistributionSearch', 'ExportRecordController@exportTypeBDistributionSearch')->name('typeb.distribution.export'); //Ajax
                Route::post('nameRecordBAsDataTable', 'SearchTypeBController@nameRecordBAsDataTable')->name('typeb.record.datatable'); //Ajax
            });
        });
        /*-- end CheckAdminBoard --*/

        /*
        *
        * CheckAdminBoard
        *
        */
        Route::group(['middleware' => 'CheckAdminBoardManager'], function () {
            # For View Registration Card
            Route::group(['prefix' => 'searchCategory'], function () {
                Route::get('viewCard/{id}', 'RegistrationCardController@viewRegisterCard'); // View Registration Card
            });

            #--------------------------------#
            # Search Report (Count Specimen) #
            #--------------------------------#
            Route::group(['prefix' => 'searchReport'], function () { //searchReport
                # Show Dashboard
                Route::get('dashboard', 'SearchReportController@dashboard');
                # Show Taxonomy
                Route::get('record_count_chart', 'SearchReportController@taxonomy');
                Route::post('record_count_chart', 'SearchReportController@searchTaxonomy');
                # Show Biogeography
                Route::get('biogeography', 'SearchReportController@biogeography');
                Route::post('biogeography', 'SearchReportController@searchBiogeography');

                # Show Diversity
                Route::get('diversity', 'SearchReportController@diversity');
                Route::post('diversity', 'SearchReportController@searchDiversity');
                Route::get('diversity/get_location/{method}_{id}', 'SearchReportController@getCountryToCounty');
                # Show Count By Place
                Route::get('count_by_place', 'SearchReportController@countByPlace');
                Route::get('count_by_place/count/{type}/{id}', 'SearchReportController@searchCountByPlace');
                # Ajax for Diversity
                Route::post('exportDiversity', 'ExportReportController@exportDiversity');
                # Ajax for Biogeography
                Route::post('exportBiogeography', 'ExportReportController@exportBiogeography');
                # Ajax for Record Count
                Route::post('exportRecordCount', 'ExportReportController@exportRecordCount');

                Route::get('reportBio/{type}', 'SearchReportTaxaController@reportBio_Five_Btn');
                Route::get('reportDiversity', 'SearchReportTaxaController@reportDiver_Long_List');
            });
        });
        /*-- end CheckAdminBoardManager --*/

        /*
        *
        * CheckPGCP
        *
        */
        Route::group(['middleware' => 'CheckPGCP'], function () {
            Route::get('exportRecord', 'ExportRecordController@exportRecord');
            Route::post('doExportRecord', 'ExportRecordController@doExportRecord');
            Route::get('exportRecordSQL', 'ExportRecordController@exportRecordSQL');
            Route::post('doExportRecordSQL', 'ExportRecordController@doExportRecordSQL');
        });
        /*-- end CheckPGCP --*/

        /*
        *
        * CheckManagerUserPGCP
        *
        */
        Route::group(['middleware' => 'CheckManagerUserPGCP'], function () {
            #------------------------#
            # Search Category A Type #
            #------------------------#
            Route::group(['prefix' => 'searchCategory'], function () {
                Route::post('getTaxonomyName', 'AjaxController@getTaxonomyName'); //AjaxController
                Route::get('dashboard', 'SearchTypeAController@searchADashboard');
                Route::get('diversity', 'SearchTypeAController@searchDiversity');
                Route::post('diversityAAsDataTable', 'SearchTypeAController@diversityAAsDataTable')->name('typea.diversity.datatable'); //Ajax
                Route::get('distribution', 'SearchTypeAController@searchDistribution');
                Route::post('distribution', 'SearchTypeAController@getDistribution');
                Route::get('recentrecord', 'SearchTypeAController@searchRecent');
                Route::post('searchdata', 'SearchTypeAController@search'); //Ajax
                Route::get('NameRecord', 'SearchTypeAController@searchByNameRecord');
                Route::post('doNameRecord', 'SearchTypeAController@doSearchNameRecord'); //Ajax
                Route::post('distributionAAsDataTable', 'SearchTypeAController@distributionAAsDataTable')->name('typea.distribution.datatable'); //Ajax
                Route::post('nameRecordAAsDataTable', 'SearchTypeAController@nameRecordAAsDataTable')->name('typea.record.datatable'); //Ajax
                Route::post('recentRecordAAsDataTable', 'SearchTypeAController@recentRecordAAsDataTable')->name('typea.recent.datatable'); //Ajax

                Route::post('exportTypeADistributionSearch', 'ExportRecordController@exportTypeADistributionSearch')->name('typea.distribution.export'); //Ajax

            });
        });
        /*-- end CheckManagerUserPGCP --*/
    });
});

include_once('stat.php');
