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
            $colspan = 11 - $column_taxa_excel;
        ?>
        <table>
            <thead>
                <tr>
                    <th colspan="{{ $colspan }}">
                        @if(strtolower($taxa_select) == "phylum")
                        Phylum
                        @elseif(strtolower($taxa_select) == "class")
                        Class
                        @elseif(strtolower($taxa_select) == "order")
                        Order
                        @elseif(strtolower($taxa_select) == "family")
                        Family
                        @elseif(strtolower($taxa_select) == "species")
                        Species
                        @endif
                        <span>: {{ $name_taxa_select }}</span>
                    </th>
                </tr>
                <tr>
                    @if(in_array($column_taxa_excel,[0]))
                    <th>Class</th>
                    @endif
                    @if(in_array($column_taxa_excel,[0,1]))
                    <th>Order</th>
                    @endif
                    @if(in_array($column_taxa_excel,[0,1,2]))
                    <th>Family</th>
                    @endif
                    @if(in_array($column_taxa_excel,[0,1,2,3]))
                    <th>Species</th>
                    @endif
                    <th>Locality</th>
                    <th>Oceaen Sea Lake</th>
                    <th>Habitat</th>
                    <th>Country</th>
                    <th>Province</th>
                    <th>district</th>
                    <th>County</th>
                </tr>
            </thead>
            <tbody>
                @foreach($results as $result)
                    @if( $result->locality != "" || $result->habitat != "" || $result->province != "" )
                        <tr>
                            @if(in_array($column_taxa_excel,[0]))
                                <td>
                                    <?php
                                        if( !in_array($result->class, $class_list)){
                                            $class_list[]     = $result->class;
                                            echo $result->class;
                                        }
                                    ?>
                                </td>
                            @endif
                            @if(in_array($column_taxa_excel,[0,1]))
                                <td>
                                    <?php
                                        if( !in_array($result->order_o, $order_list) && in_array($column_taxa_excel,[0,1])){
                                            $order_list[]     = $result->order_o;
                                            echo $result->order_o;
                                        }
                                    ?>
                                </td>
                            @endif
                            @if(in_array($column_taxa_excel,[0,1,2]))
                                <td>
                                    <?php
                                        if( !in_array($result->family, $family_list) && in_array($column_taxa_excel,[0,1,2])){
                                            $family_list[]    = $result->family;
                                            echo $result->family;

                                        }
                                    ?>
                                </td>
                            @endif
                            @if(in_array($column_taxa_excel,[0,1,2,3]))
                                <td>
                                    <?php
                                        if( !in_array($result->species, $species_list) && in_array($column_taxa_excel,[0,1,2,3])){
                                            $species_list[]   = $result->species;
                                            echo $result->species;
                                        }
                                    ?>
                                </td>
                            @endif
                            <td>
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
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </body>
</html>
