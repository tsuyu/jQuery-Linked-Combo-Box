<?php
    
/*

This file is part of jQuery Linked Combo Box.

    jQuery Linked Combo Box is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    jQuery Linked Combo Box is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with jQuery Linked Combo Box.  If not, see <http://www.gnu.org/licenses/>.
	
	tsuyu
	index.php
	generate combo box
*/

?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>jQuery Linked Combo Box</title>
        <script src="jquery.js"></script>
        <script src="jquery.jqote2.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {

                $.ajax({
                    type: "POST",
                    url: "data.php?" + new Date().getTime(),
                    dataType: 'json',
                    cache: false,
                    data: {
                        no: 0
                    },
                    success: function(data) {
                        try {
                            $('#country').jqoteapp('#country_json',data);
                        } catch (e) {
                            alert(e);
                        }
                    }
                });


                $('#country').change(function(event){

                    if($(this).val() != ''){
                        $.ajax({
                            type: "POST",
                            url: "data.php?" + new Date().getTime(),
                            dataType: 'json',
                            cache: false,
                            data: {
                                no: 1,
                                id: $(this).val(),
                                field:0
                            },
                            success: function(data) {
                                $('#state').empty();
                                try {
                                    $('#state').jqoteapp('#state_json',data);
                                } catch (e) {
                                    alert(e);
                                }
                            }
                        });
                    }
                });

                $('#state').change(function(event){

                    if($(this).val() != ''){
                        $.ajax({
                            type: "POST",
                            url: "data.php?" + new Date().getTime(),
                            dataType: 'json',
                            cache: false,
                            data: {
                                no: 2,
                                id: $(this).val(),
                                field:1
                            },
                            success: function(data) {
                                $('#city').empty();
                                try {
                                    $('#city').jqoteapp('#city_json',data);
                                } catch (e) {
                                    alert(e);
                                }
                            }
                        });
                    }
                });

                $.ajaxSetup({
                    error:function(x,e){
                        if(x.status==0){
                            alert('You are offline!!\n Please Check Your Network.');
                        }else if(x.status==404){
                            alert('Requested URL not found.');
                        }else if(x.status==500){
                            alert('Internel Server Error.');
                        }else if(e=='parsererror'){
                            alert('Error.\nParsing JSON Request failed.');
                        }else if(e=='timeout'){
                            alert('Request Time out.');
                        }else {
                            alert('Unknown Error.\n'+x.responseText);
                        }
                    }
                });
            });
        </script>
    </head>
    <body>
        <select id="country">
            <option value="">Select</option>
        </select>

        <select id="state">
            <option value="">Select</option>
        </select>

        <select id="city">
            <option value="">Select</option>
        </select>
        <script type="text/html" id="country_json">
            <![CDATA[
            <%= j+1 %>
        <option value="<%= data[j]['country_id'] %>"><%= data[j]['country_name'] %></option>
        ]]>
    </script>

    <script type="text/html" id="state_json">
        <![CDATA[
        <%= j+1 %>
        <option value="<%= data[j]['state_id'] %>"><%= data[j]['state_name'] %></option>
        ]]>
    </script>
    <script type="text/html" id="city_json">
        <![CDATA[
        <%= j+1 %>
        <option value="<%= data[j]['city_id'] %>"><%= data[j]['city_name'] %></option>
        ]]>
    </script>
</body>
</html>
