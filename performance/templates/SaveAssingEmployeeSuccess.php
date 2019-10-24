<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery.validate.js') ?>"></script>
<script type="text/javascript" src="<?php echo public_path('../../scripts/paginator.js') ?>"></script>
<div class="formpage4col" >
    <div class="navigation">
<style type="text/css">
.active
{
color:#FFF8C6;
background-color:#FFE87C;
border: solid 1px #AF7817;
padding:1px 1px;
margin:1px;
text-decoration:none;
}
.inactive
{
color:#000000;
cursor:default;
text-decoration:none;
border: solid 1px #FFF8C6;
padding:1px 1px;
margin:1px;

}
div.formpage4col select{
width: 50px;
}
.paginator{

    padding-left: 50px;

}

</style>

    </div>
    <div id="status"></div>
    <div class="outerbox">
        <div class="mainHeading"><h2><?php echo __("Assign Employee") ?></h2></div>
        <?php echo message() ?>
        <form name="frmSave" id="frmSave" method="post"  action="">
            <div class="leftCol">
                &nbsp;
            </div>
            <br class="clear"/>
            <div id="bulkemp" style="float: right;">


                <div class="leftCol">
                    <label id="lblemp" class="controlLabel" for="txtLocationCode"><?php echo __("Add Employee") ?> <span class="required">*</span></label>
                </div>
                            
                <div class="centerCol" style="padding-top: 8px;">
                    <input class="button" type="button" value="..." id="empRepPopBtn" name="empRepPopBtn" <?php echo $disabled; ?> /><br>
                    <input  type="hidden" name="txtEmpId" id="txtEmpId" value="<?php echo $etid; ?>"/>
                </div>
                <br class="clear"/>
                <div id="employeeGrid1" class="centerCol" style="margin-left:10px; margin-top: 8px; width: 380px; border-style:  solid; border-color: #FAD163; ">
                    <div style="">
                        <div class="centerCol" style='width:100px; background-color:#FAD163;'>
                            <label class="languageBar" style="padding-left:2px; padding-top:2px;padding-bottom: 1px; background-color:#FAD163; margin-top: 0px;  color:#444444;"><?php echo __("Emp Id") ?></label>
                        </div>
                        <div class="centerCol" style='width:220px;  background-color:#FAD163;'>
                            <label class="languageBar" style="padding-left:2px; padding-top:2px;padding-bottom: 1px; background-color:#FAD163; margin-top: 0px; color:#444444; text-align:inherit"><?php echo __("Employee Name") ?></label>
                        </div>
                        <div class="centerCol" style='width:60px;   background-color:#FAD163;'>
                            <label class="languageBar" style="width:50px; padding-left: 0px; padding-top:2px;padding-bottom: 1px; background-color:#FAD163; margin-top: 0px; color:#444444; text-align:inherit"><?php echo __("Remove") ?></label>
                        </div>

                    </div>
                    <div id="tohide" >
                    

                    </div>
                    <br class="clear"/>
                   
                </div>
            </div>
            <div style="float: left; width: 350px;">
                <div class="leftCol" >
                    <label class=""><?php echo __("Company Evaluation") ?><span class="required">*</span></label>
                </div>
                <div class="centerCol" style="padding-top: 8px;" id="btype">

                    <select name="cmbbtype" id="cmbbtype" onchange="getYear(this.value);" style="width: 150px;">
                        <option value=""><?php echo __("--Select--") ?></option>
                        <?php foreach ($EvaluationList as $Evaluation) {
                        ?>
                            <option value="<?php echo $Evaluation->eval_id; ?>" <?php if ($EVID == $Evaluation->eval_id){ echo "selected";  } ?>> <?php
                                    if ($Culture == 'en') {
                                        echo $Evaluation->eval_name;
                                    } elseif ($Culture == 'si') {
                                        if (($Evaluation->eval_name_si) == null) {
                                            echo $Evaluation->eval_name;
                                        } else {
                                            echo $Evaluation->eval_name_si;
                                        }
                                    } elseif ($Culture == 'ta') {
                                        if (($Evaluation->eval_name_ta) == null) {
                                            echo $Evaluation->eval_name;
                                        } else {
                                            echo $Evaluation->eval_name_ta;
                                        }
                                    }
                        ?></option>
<?php } ?>
                            </select>
                        </div>
                        <br class="clear"/>
                        <div class="leftCol" >
                            <label for="txtLocationCode" ><?php echo __("Year") ?><span class="required">*</span></label>
                        </div>
                        <div class="centerCol" style="padding-top: 8px; ">
                            <input id="txtYear" type="text" name="txtYear" value="<?php echo date("Y"); ?>" maxlength="4" style="width: 140px;" readonly="readonly">
                        </div>
                        <br class="clear"/>
                        <div class="leftCol" >
                    <label class=""><?php echo __("Evaluation Type") ?><span class="required">*</span></label>
                </div>
                <div class="centerCol" style="padding-top: 8px;" id="btype">

                    <select name="cmbEtype" id="cmbEtype" onchange="getData(this.value);" style="width: 150px;">
                        <option value=""><?php echo __("--Select--") ?></option>
                        <?php foreach ($EvaluationTypeList as $EvaluationType) {
                        ?>
                            <option value="<?php echo $EvaluationType->eval_type_id; ?>" <?php if ($ETID == $EvaluationType->eval_type_id){ echo "selected"; } ?>> <?php
                                    if ($Culture == 'en') {
                                        echo $EvaluationType->eval_type_name;
                                    } elseif ($Culture == 'si') {
                                        if (($EvaluationType->eval_type_name_si) == null) {
                                            echo $EvaluationType->eval_type_name;
                                        } else {
                                            echo $EvaluationType->eval_type_name_si;
                                        }
                                    } elseif ($Culture == 'ta') {
                                        if (($EvaluationType->eval_type_name_ta) == null) {
                                            echo $EvaluationType->eval_type_name;
                                        } else {
                                            echo $EvaluationType->eval_type_name_ta;
                                        }
                                    }
                        ?></option>
<?php } ?>
                            </select>
                        </div>
                        <br class="clear"/>
 
                    </div>
                    <br class="clear"/>


                    <br class="clear"/>
                    <div class="formbuttons">
                        <input type="button" class="savebutton" id="editBtn"

                               value="<?php echo __("Save") ?>" tabindex="8" />
                        <input type="button" class="clearbutton"  id="resetBtn"
                               value="<?php echo __("Reset") ?>" tabindex="9" />
<!--                        <input type="button" class="backbutton" id="btnBack"
                               value="<?php echo __("Back") ?>" tabindex="10" />-->
                    </div>
                </form>
            </div>
            <div class="requirednotice"><?php echo __("Fields marked with an asterisk") ?><span class="required"> * </span> <?php echo __("are required") ?></div>

            <br class="clear" />
        </div>

        <script type="text/javascript">
            //ajax start to load to the grid ///
            var courseId="";
            var empIDMaster
            var myArray2= new Array();
            var empstatArray= new Array();
            var k;
            var pagination = 0;

            //Pagination variable
            itemsPerPage = 10;
            paginatorStyle = 2;
            paginatorPosition = 'both';
            enableGoToPage = true;

            var ajaxED = 0;
//            function LoadCurrentDep(id){
//                $.post(
//
//                "<?php //echo url_for('Leave/AjaxEmpType') ?>", //Ajax file
//
//                { id: id },  // create an object will all values
//                function(data){
//                    var i = 0;
//                    empstatArray=data;
//                    $.each(data, function(key,value) {
//                        $.each(value, function(key,value) {
//
//                        });
//                    });
//                    i++;
//                },
//                "json"
//
//            );
//            }
            function getYear(id){
                $('#bulkemp').hide();
                $('#cmbEtype').val("");
                $.post(
                "<?php echo url_for('performance/Year') ?>", //Ajax file

                { id: id },  // create an object will all values
                function(data){
                    ajaxED=data;
                    $('#txtYear').val(data)
                   // LoadCurrentDep(id);

                    for(var t=0; t<=k; t++){
                        $("#row_"+t).remove();
                    }
                    myArray2=new Array();

                },
                "json"

            );

            }

        function getData(id){

       if($('#cmbEtype').val()!='' && $('#cmbbtype').val()!=''){
        $.ajax({
            type: "POST",
            async:false,
            url: "<?php echo url_for('performance/CurrentEmployee') ?>",
            data: { EVid: $('#cmbbtype').val() , ETid: $('#cmbEtype').val() },
            dataType: "json",
            success: function(data){
                myArray2=new Array();
                for(var t=0; t<=k; t++){
                    $("#row_"+t).remove();
                    }

                    if(pagination >= 1){
                       $("#tohide").depagination();
                   }
                    if(data!=null){
                        SelectEmployee(data);
                        $('#bulkemp').show();
                    }else{
                    for(var t=0; t<=k; t++){
                        $("#row_"+t).remove();
                    }
                    
                    if(pagination >= 1){
                       $("#tohide").depagination();
                       }
                    myArray2=new Array();
                    }
                }
        });


            $('#bulkemp').show();
            }else{
               $('#bulkemp').hide();
            }



            }


            function SelectEmployee(data){

                myArr=new Array();
                lol=new Array();
                myArr = data.split('|');

                addtoGrid(myArr);
                if(myArr != null){
                }
            }

            function addtoGrid(empid){

                var arraycp=new Array();

                var arraycp = $.merge([], myArray2);

                var items= new Array();
                for(i=0;i<empid.length;i++){

                    items[i]=empid[i];
                }

                var u=1;
                $.each(items,function(key, value){

                    if(jQuery.inArray(value, arraycp)!=-1)
                    {

                        // ie of array index find bug sloved here//
                        if(!Array.indexOf){
                            Array.prototype.indexOf = function(obj){
                                for(var i=0; i<this.length; i++){
                                    if(this[i]==obj){
                                        return i;
                                    }
                                }
                                return -1;
                            }
                        }

                        var idx = arraycp.indexOf(value);
                        if(idx!=-1) arraycp.splice(idx, 1); // Remove it if really found!
                        u=0;

                    }
                    else{

                        arraycp.push(value);

                    }


                }


            );

                $.each(myArray2,function(key, value){
                    if(jQuery.inArray(value, arraycp)!=-1)
                    {

                        // ie of array index find bug sloved here//
                        if(!Array.indexOf){
                            Array.prototype.indexOf = function(obj){
                                for(var i=0; i<this.length; i++){
                                    if(this[i]==obj){
                                        return i;
                                    }
                                }
                                return -1;
                            }
                        }

                        var idx = arraycp.indexOf(value); // Find the index
                        if(idx!=-1) arraycp.splice(idx, 1); // Remove it if really found!
                        u=0;

                    }
                    else{


                    }


                }


            );
                $.each(arraycp,function(key, value){
                    myArray2.push(value);
                }


            );if(u==0){

                }
                var courseId1=$('#courseid').val();
                $.post(

                "<?php echo url_for('performance/LoadGrid') ?>", //Ajax file



                { 'empid[]' : arraycp },  // create an object will all values

                //function that is c    alled when server returns a value.
                function(data){
                    //alert(data);

                    //var childDiv;
                    var childdiv="";
                    var i=0;

                    $.each(data, function(key, value) {
                        var word=value.split("|");

                                    childdiv="<div class='pagin' id='row_"+i+"' style='padding-top:5px; '>";
                                    childdiv+="<div class='centerCol' id='master' style='width:100px;'>";
                                    childdiv+="<div id='employeename' style='height:30px; padding-left:3px;'>"+word[0]+"</div>";
                                    childdiv+="</div>";

                                    childdiv+="<div class='centerCol' id='master' style='width:220px;'>";
                                    childdiv+="<div id='employeename' style='height:30px; padding-left:3px;'>"+word[1]+"</div>";
                                    childdiv+="</div>";

                                    childdiv+="<div class='centerCol' id='master' style='width:60px;'>";
                                    childdiv+="<div id='employeename' style='height:30px; padding-left:3px;'><a href='#' style='width:50px;' onclick='deleteCRow("+i+","+word[4]+")'><?php echo __('Remove') ?></a><input type='hidden' name='hiddenEmpNumber[]' value="+word[4]+" ></div>";
                                    childdiv+="</div>";
                                    childdiv+="</div>";
                                    //

                                    $('#tohide').append(childdiv);


                        k=i;
                        i++;
                    });
                    pagination++;

                    $(function () {

                       if(pagination > 1){
                       $("#tohide").depagination();
                       }
                        $("#tohide").pagination();
                    });
                

                },

                //How you want the data formated when it is returned from the server.
                "json"

            );


            }
            function removeByValue(arr, val) {
                for(var i=0; i<arr.length; i++) {
                    if(arr[i] == val) {

                        arr.splice(i, 1);

                        break;

                    }
                }
            }
            function deleteCRow(id,value){

                answer = confirm("<?php echo __("Do you really want to Delete?") ?>");

                if (answer !=0)
                {

                    $("#row_"+id).remove();
                    removeByValue(myArray2, value);

                    $('#hiddeni').val(Number($('#hiddeni').val())-1);
                    

            $.ajax({
            type: "POST",
            async:false,
            url: "<?php echo url_for('performance/AjaxDeleteAssignEmployee') ?>",
            data: { EVid: $('#cmbbtype').val() , ETid: $('#cmbEtype').val() , Empno:value },
            dataType: "json",
            success: function(data){
            }
            });
                    $(function () {
                        $("#tohide").depagination();
                        $("#tohide").pagination();
                    });

                }
                else{
                    return false;
                }

            }



            $(document).ready(function() {
                buttonSecurityCommon("null","editBtn","null","null");
                $('#bulkemp').hide();
                $('#empRepPopBtn').click(function() {
                    var EVid=$('#cmbEtype').val();
                    var ETid=$('#cmbbtype').val();
                   // var popup=window.open('<?php echo public_path('../../symfony/web/index.php/performance/searchEmployee?EVid='+EVid+'&ETid='+ETid+'&type=multiple&method=SelectEmployee'); ?>','Locations','height=450,width=800,resizable=1,scrollbars=1');
                
                var popup=window.open("<?php echo public_path('../../symfony/web/index.php/performance/searchEmployee?EVid=') ?>" + EVid + "&ETid="+ETid +"&type=multiple&method=SelectEmployee",'Locations','height=450,width=800,resizable=1,scrollbars=1');
                
                if(!popup.opener) popup.opener=self;
                    popup.focus();
                });
                //getData(1);
                //Validate the form
                $("#frmSave").validate({

                    rules: {

                        cmbbtype: { required: true},
                        txtYear: { required: true,number: true }


                    },
                    messages: {
                        cmbbtype: { required:"<?php echo __("Leave Type is required ") ?>"},
                        txtYear:{ required:"<?php echo __("This is required") ?>",number:"<?php echo __("Please Enter Digit") ?>"}

                    }
                });

                // When click edit button
                $("#editBtn").click(function() {
                    var entdate=parseInt($('#txtEntitleDays').val());
                    var enttdate=parseInt($('#txtEnTakenDays').val());
                    var entrem=entdate < enttdate;
                    
                    if($('#cmbbtype').val()==""){
                        alert("<?php echo __("Please Select an Evaluation.") ?>");
                        return false;
                    }
                    if($('#cmbEtype').val()==""){
                        alert("<?php echo __("Please Select an Evaluation Type.") ?>");
                        return false;
                    }
                    if($('#txtEmpId').val()==null){
                        alert("<?php echo __("Please Select an Employee.") ?>");
                        return false;
                    }else{
                            
                            $("#txtEmpId").val(myArray2);
                            //alert($('#txtEmpId').val());
                            if($('#txtEmpId').val()==""){
                                alert("<?php echo __("Please Select an Employee.") ?>");
                                return false;
                            }else{
                                $('#frmSave').submit();
                            }
                        }

                    
                });

                //When click reset buton
                $("#resetBtn").click(function() {
                    location.href = "<?php echo url_for(public_path('../../symfony/web/index.php/performance/SaveAssingEmployee')) ?>";
                });

                //When Click back button
                $("#btnBack").click(function() {
                    location.href = "<?php echo url_for(public_path('../../symfony/web/index.php/performance/AssingEmployee')) ?>";
        });

    });
</script>
