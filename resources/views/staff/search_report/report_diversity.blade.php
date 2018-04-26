<?php

header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=".$header_excel."_".date('d-m-Y_H-i-s').".xls");  //File name extension was wrong
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private",false);

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title></title>
        <style media="screen">
            table {
                border-collapse: collapse;
            }
            table, th, tr, td {
                border: 1px solid black;
            }
        </style>
    </head>
    <body>

        <?php
            $class_list = [];
            $order_list = [];
            $family_list = [];
            $species_list = [];

            $list_report = [];
            $colspan = 5;
        ?>
        <table>
            <thead>
                <tr>
                    <th colspan="{{ $colspan }}">
                        @if($taxa_select !== "")
                            {{ ucfirst(strtolower($taxa_select)) }}
                            <span>: {{ $name_taxa_select }}</span>
                            <span>&nbsp;&nbsp;&nbsp;</span>
                        @endif

                        @if($locality_select !== "")
                            @if(strtolower($locality_select[0]) == "ocean_sea_lake")
                                Ocean Sea Lake
                            @elseif(strtolower($locality_select[0]) == "country")
                                Country
                            @elseif(strtolower($locality_select[0]) == "province")
                                Province
                            @elseif(strtolower($locality_select[0]) == "district")
                                District
                            @elseif(strtolower($locality_select[0]) == "county")
                                County
                            @elseif(strtolower($locality_select[0]) == "locality")
                                Locality
                            @endif
                            <span>: {{ $locality_select[1] }}</span>
                        @endif
                    </th>
                </tr>
                <tr>
                    <th>Class</th>
                    <th>Order</th>
                    <th>Family</th>
                    <th>Species</th>

                    <!-- <th>Locality</th>
                    <th>Oceaen Sea Lake</th>
                    <th>Habitat</th>
                    <th>Country</th>
                    <th>Province</th>
                    <th>district</th>
                    <th>County</th> -->
                </tr>
            </thead>
            <tbody>
                @foreach($results as $result)
                        <tr>
                            <td>
                                <?php
                                    if( !in_array($result->class, $class_list)){
                                        $class_list[]     = $result->class;
                                        echo $result->class;
                                    }
                                ?>
                            </td>
                            <td>
                                <?php
                                    if( !in_array($result->order_o, $order_list)){
                                        $order_list[]     = $result->order_o;
                                        echo $result->order_o;
                                    }
                                ?>
                            </td>
                            <td>
                                <?php
                                    if( !in_array($result->family, $family_list)){
                                        $family_list[]    = $result->family;
                                        echo $result->family;

                                    }
                                ?>
                            </td>
                            <td>
                                <?php
                                    if( !in_array($result->current_scientific_name, $species_list)){
                                        $species_list[]   = $result->current_scientific_name;
                                        echo $result->current_scientific_name;
                                    }
                                ?>
                            </td>

                            <!-- <td>
                                {{ $result->locality }}
                            </td>
                            <td>
                                {{ $result->ocean_sea_lake }}
                            </td>
                            <td>
                                {{ $result->habitat }}
                            </td>
                            <td>
                                {{ $result->country }}
                            </td>
                            <td>
                                {{ $result->province }}
                            </td>
                            <td>
                                {{ $result->district }}
                            </td>
                            <td>
                                {{ $result->county }}
                            </td> -->
                        </tr>
                @endforeach
            </tbody>
        </table>
    </body>
</html>
