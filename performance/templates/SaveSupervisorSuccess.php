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
        <div class="mainHeading"><h2><?php echo __("Assign Supervisor") ?></h2></div>
        <?php echo message() ?>
        <form name="frmSave" id="frmSave" method="post"  action="">
            <div class="leftCol">
                &nbsp;
            </div>
            <br class="clear"/>
            <!--            <div id="bulkemp" style="float: right;">
            
                            
                            <div class="leftCol">
                                <label id="lblemp" class="controlLabel" for="txtLocationCode"><?php echo __("Add Employee") ?> <span class="required">*</span></label>
                            </div>
                                        
                            <div class="centerCol" style="padding-top: 8px;">
                                <input class="button" type="button" value="..." id="empRepPopBtn" name="empRepPopBtn" <?php echo $disabled; ?> /><br>
                                <input  type="hidden" name="txtEmpId" id="txtEmpId" value="<?php echo $etid; ?>"/>
                            </div>
                            <br class="clear"/>
                         
                        </div>-->
            <div style="float: left; width: 380px;">
                <div class="leftCol" >
                    <label class=""><?php echo __("Company Evaluation") ?><span class="required">*</span></label>
                </div>
                <div class="centerCol" style="padding-top: 8px;" id="btype">

                    <select name="cmbbtype" id="cmbbtype" onchange="getYear(this.value);" style="width: 160px;">
                        <option value=""><?php echo __("--Select--") ?></option>
                        <?php foreach ($EvaluationList as $Evaluation) {
                            ?>
                            <option value="<?php echo $Evaluation->eval_id; ?>" <?php if ($EVID == $Evaluation->eval_id) echo "selected"; ?>> <?php
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
                <div class="centerCol" style="padding-top: 8px;">
                    <input id="txtYear" readonly="readonly" type="text" name="txtYear" value="<?php echo date("Y"); ?>" maxlength="4">
                </div>
                <br class="clear"/>

                <div class="leftCol" >
                    <label class=""><?php echo __("Evaluation Type") ?><span class="required">*</span></label>
                </div>
                <div class="centerCol" style="padding-top: 8px;" id="btype">

                    <select name="cmbEtype" id="cmbEtype" onchange="loademployee(this.value);" style="width: 160px;">
                        <option value=""><?php echo __("--Select--") ?></option>
                        <?php foreach ($EvaluationTypeList as $EvaluationType) {
                            ?>
                            <option value="<?php echo $EvaluationType->eval_type_id; ?>" <?php if ($ETID == $EvaluationType->eval_type_id) {
                            echo "selected";
                        } ?>> <?php
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


                <div id="employeeGrid1" class="centerCol" style="margin-left:10px; margin-top: 8px; width: 700px; border-style:  solid; border-color: #FAD163; ">
                    <div style="">
                        <div class="centerCol" style='width:200px; background-color:#FAD163;'>
                            <label class="languageBar" style="padding-left:2px; padding-top:2px;padding-bottom: 1px; background-color:#FAD163; margin-top: 0px;  color:#444444;"><?php echo __("Employee Name") ?></label>
                        </div>
                        <div class="centerCol" style='width:220px;  background-color:#FAD163;'>
                            <label class="languageBar" style="padding-left:2px; padding-top:2px;padding-bottom: 1px; background-color:#FAD163; margin-top: 0px; color:#444444; text-align:inherit"><?php echo __("Supervisor Name") ?></label>
                        </div>
                        <div class="centerCol" style='width:130px;  background-color:#FAD163;'>
                            <label class="languageBar" style="padding-left:2px; padding-top:2px;padding-bottom: 1px; background-color:#FAD163; margin-top: 0px; color:#444444; text-align:inherit"><?php echo __("Supervisor type") ?></label>
                        </div>
                        <div class="centerCol" style='width:150px;   background-color:#FAD163;'>
                            <label class="languageBar" style="width:150px; padding-left: 0px; padding-top:2px;padding-bottom: 1px; background-color:#FAD163; margin-top: 0px; color:#444444; text-align:inherit"><?php echo __("Change supervisor") ?></label>
                        </div>

                    </div>
                    <div id="tohide1">


                    </div>
                    <br class="clear"/>

                </div>


                <!--                                        <div class="leftCol">
                                    <label class="controlLabel" for="txtLocationCode"><?php echo __("Supervisor Name") ?><span class="required">*</span></label>
                                </div>
                                <div class="centerCol" style="padding-top: 8px;" style="width: 160px;">
                                    <input type="text" name="txtSupEmployeeName" disabled="disabled" id="txtSupEmployee" value="" readonly="readonly" style="width: 150px;"/>
                                    <input type="hidden"  name="txtSupEmpId" id="txtSupEmpId" value=""/>
                                </div>
                                <div class="centerCol" style="padding-top: 8px;width: 25px;">
                                    <input class="button" type="button" value="..." id="empRepPopBtn1" name="empRepPopBtn1" <?php echo $disabled; ?> />
                                </div>
                                <br class="clear">-->


                <!--                        <div class="leftCol" >
                                    <label class=""><?php echo __("Evaluation Type") ?><span class="required">*</span></label>
                                </div>
                                <div class="centerCol" style="padding-top: 8px;" id="btype">
                
                                    <select name="cmbEtype" id="cmbEtype" onchange="getData(this.value);" style="width: 150px;">
                                        <option value=""><?php echo __("--Select--") ?></option>
                <?php foreach ($EvaluationTypeList as $EvaluationType) {
                    ?>
                                                <option value="<?php echo $EvaluationType->eval_type_id; ?>" <?php if ($ETID == $EvaluationType->eval_type_id) echo "selected"; ?>> <?php
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
                                        </div>-->
                <br class="clear"/>
                <div class="leftCol" id="options" style="width: 350px;">
                    <div class="leftCol" style="width: 20px;">&nbsp;</div>

                    <div class="centerCol">
                        <input type="radio" value="0" name="Suptype" id="Suptype1" onClick="selectsuperviser(this.value);"><?php echo __("Get Immediate Supervisor"); ?>

                    </div>
                    <div class="centerCol" style="width: 100px;">
                        <input type="radio" value="1" name="Suptype" id="Suptype2" onClick="selectsuperviser(this.value);"><?php echo __("Individual"); ?>

                    </div>
                </div>
            </div>
            <div id="legend" style="float: right;width: 250px;">
                <table border="0" >
                    <tr>
                        <td style="background-color: #FF7F00; width: 20px"></td>
                        <td><?php echo __("Supervisor not assigned for evaluation") ?></td>
                    </tr>
                    <tr>
                        <td style="background-color: #966633;"></td>
                        <td><?php echo __("Not saved employee") ?></td>
                    </tr>
                    <tr>
                        <td style="background-color: black;"></td>
                        <td><?php echo __("Saved employee") ?></td>
                    </tr>
                </table>
            </div>
            <br class="clear"/>
            <br class="clear"/>


            <br class="clear"/>
            <div class="formbuttons" >
                <table>
                    <tr>
                        <td>  
                            <input type="button" class="savebutton" id="editBtn"

                                   value="<?php echo __("Save") ?>"  />
                        </td>
                        <td>
                            <input type="button" class="clearbutton"  id="resetBtn"
                                   value="<?php echo __("Reset") ?>" />
                        </td>
                    </tr>
                </table>
            </div>
        </form>
    </div>
    <div class="requirednotice"><?php echo __("Fields marked with an asterisk") ?><span class="required"> * </span> <?php echo __("are required") ?></div>

    <br class="clear" />
</div>

<script type="text/javascript">
    //ajax start to load to the grid ///
    var Eval="";
    var courseId="";
    var empIDMaster
    var myArray2= new Array();
    var empstatArray= new Array();
    var k;
    var pagination = 0;
    var supArray= new Array();

    var tempEmpId='';

    //Pagination variable
    itemsPerPage = 10;
    paginatorStyle = 2;
    paginatorPosition = 'both';
    enableGoToPage = true;

    var ajaxED = 0;


    function selectsuperviser(id){
                
        if(id!= null){
            $('#bulkemp').show();
            if(id== 0){
                $('#lblemp').hide();
                $('#empRepPopBtn').hide();
            }else{
                $('#lblemp').show();
                $('#empRepPopBtn').show();
            }
        }else{
            $('#bulkemp').hide();
        }

        for(var t=0; t<=k; t++){
            $("#row_"+t).remove();
        }
        myArray2=new Array();
        $.ajax({
            type: "POST",
            async:false,
            url: "<?php echo url_for('performance/SubordinateEmployee') ?>",
            data: { EVid: $('#cmbbtype').val() , id: id ,Empnum: $("#txtSupEmpId").val() },
            dataType: "json",
            success: function(data){
                if(data!=null){
                    SelectEmployee(data);
                    $('#bulkemp').show();
                }else{
                    for(var t=0; t<=k; t++){
                        $("#row_"+t).remove();
                    }
                    k=t;
                    if(pagination >= 1){
                        $("#tohide").depagination();
                    }
                    myArray2=new Array();
                }
            }
        });
    }




    function SelectEmployee1(data){
        supArray = data.split('|');
        if(supArray[0]!=null){
            $("#hiddneSupID_"+tempEmpId).val(supArray[0]);
            $("#supname_"+tempEmpId).html("<b>"+supArray[1]+"</b>");
            $("#type_"+tempEmpId).html("<b><?php echo __('Individual supervisor'); ?></b>");
            //                    $("#options").show();
        }


                }
            function getYear(id){
                Eval=id;
                $('#bulkemp').hide();
                $('#cmbEtype').val("");
                $('#tohide1').html('');
                //$('#editBtn').hide();
                $('#editBtn').attr("disabled", true);
                $.post(
                "<?php echo url_for('performance/Year') ?>", //Ajax file

        { id: id },  // create an object will all values
        function(data){
            ajaxED=data;
            $('#txtYear').val(data);
            // LoadCurrentDep(id);

                   

        },
        "json"
    );
                    
                
    }


function loademployee(id){
    //$('#editBtn').hide();
    $('#editBtn').attr("disabled", true);
    $.post(
                "<?php echo url_for('performance/EmployeeListById') ?>", //Ajax file

        { id: id, Eval:Eval },  // create an object will all values
        function(data){
            count = data.length;
            var childdiv="";
            var i=0;
            $('#tohide1').html('');
            $.each(data, function(key, value) {
                var word=value.split("|");
                if(word[4]=="N"){
                    childdiv="<div class='pagin' id='row_"+i+"' style='padding-top:10px;'>";
                    childdiv+="<div class='centerCol' id='master' style='width:200px;'>";
                    childdiv+="<input type='hidden' id='hiddneEmpID_"+word[6]+"' name='hiddneEmpID_"+word[6]+"' value='"+word[6]+"' />";
                    childdiv+="<div class='centerCol' id='employeename_"+word[6]+"' style='height:35px; padding-left:3px; color:#966633;'><b>"+word[0]+"</b></div>";
                    childdiv+="</div>";

                    childdiv+="<div class='centerCol' id='master' style='width:220px;'>";
                    childdiv+="<input type='hidden'  id='hiddneSupID_"+word[6]+"' class='hiddenSupId'  name='hiddneSupID_"+word[6]+"' value='"+word[2]+"' />";
                    childdiv+="<input type='hidden'  id='hiddneFlag_"+word[6]+"'  name='hiddneFlag_"+word[6]+"' value='"+word[3]+"' />";
                    childdiv+="<div class='centerCol' id='supname_"+word[6]+"' style='height:35px; padding-left:3px; color:#966633;'>";
                    if(word[2]==""){
                        childdiv+="<b>"+"<?php echo __("Not Assigned") ?>"+"</b>";   
                    }else{
                        childdiv+="<b>"+word[1]+"</b>";
                    }
                    childdiv+="</div></div>";
                    childdiv+="<div  class='centerCol' id='type_"+word[6]+"' style='width:130px; height:35px; color:#966633;'>";
                    if(word[2]==""){
                        childdiv+="<b>"+"<?php echo __("Not Assigned") ?>"+"</b>";   
                    }
                    if(word[5]=="1"){
                                        
                        if(word[2]!=""){
                            childdiv+="<b><?php echo __('Immediate supervisor'); ?></b>";
                        }
                    }
                    else{
                        if(word[2]!=""){
                            childdiv+="<b><?php echo __('Individual supervisor'); ?></b>";
                        }
                    }

                    childdiv+="</div>";
                    childdiv+="<div class='centerCol' id='master' style='width:150px; height:35px;'>";
                    childdiv+="<input class='button' type='button' value='...' id='empRepPopBtn_"+word[6]+"' name='empRepPopBtn_"+word[6]+"' onclick='LoadEmpSerachBox("+word[6]+")' />";
                    childdiv+="</div>";
                    childdiv+="</div>";
                    //
                }
                else{
                                     
                    childdiv="<div class='pagin' id='row_"+i+"' style='padding-top:10px;'>";
                    childdiv+="<div class='centerCol' id='master' style='width:200px;'>";
                    childdiv+="<input type='hidden' id='hiddneEmpID_"+word[6]+"' name='hiddneEmpID_"+word[6]+"' value='"+word[6]+"' />";
                    if(word[2]==""){
                        childdiv+="<div id='employeename_"+word[6]+"' style='height:35px; padding-left:3px; color:#FF7F00'><b>"+word[0]+"</b></div>";    
                    }else{
                        childdiv+="<div id='employeename_"+word[6]+"' style='height:35px; padding-left:3px;'>"+word[0]+"</div>";
                    }
                    childdiv+="</div>";

                    childdiv+="<div class='centerCol' id='master' style='width:220px;'>";
                    childdiv+="<input type='hidden'  id='hiddneSupID_"+word[6]+"' class='hiddenSupId'  name='hiddneSupID_"+word[6]+"' value='"+word[2]+"' />";
                    childdiv+="<input type='hidden'  id='hiddneFlag_"+word[6]+"'  name='hiddneFlag_"+word[6]+"' value='"+word[3]+"' />";
                    if(word[2]==""){
                        childdiv+="<div class='centerCol' id='supname_"+word[6]+"' style='height:35px; padding-left:3px; color:#FF7F00'><b>"+"<?php echo __("Not Assigned") ?>"+"</b></div>";   
                    }else{
                        childdiv+="<div class='centerCol' id='supname_"+word[6]+"' style='height:35px; padding-left:3px;'>"+word[1]+"</div>";
                    }
                    childdiv+="</div>";
                    if(word[2]==""){
                        childdiv+="<div class='centerCol' id='type_"+word[6]+"' style='width:130px; height:35px; color:#FF7F00'><b>"+"<?php echo __("Not Assigned") ?>"+"</b>";    
                                    
                    }else{   
                        childdiv+="<div class='centerCol' id='type_"+word[6]+"' style='width:130px; height:35px;'>";
                                    
                        if(word[5]=="1"){
                            if(word[2]!=""){
                                childdiv+="<?php echo __('Immediate supervisor'); ?>";
                            }
                        }
                        else{
                            if(word[2]!=""){
                                childdiv+="<?php echo __('Individual supervisor'); ?>";
                            }
                        }
                    }
                    childdiv+="</div>";
                    childdiv+="<div class='centerCol' id='master' style='width:150px; height:35px;'>";
                    childdiv+="<input class='button' type='button' value='...' id='empRepPopBtn_"+word[6]+"' name='empRepPopBtn_"+word[6]+"' onclick='LoadEmpSerachBox("+word[6]+")' />";
                    childdiv+="</div>";
                    childdiv+="</div>";
                }
                $('#tohide1').append(childdiv);


                k=i;
                i++;
            });
        },
        "json"

    );


//$('#editBtn').fadeIn(6000).show();   
//$('#editBtn').show(); 
$('#editBtn').val("Wait"); 
setTimeout('enableButton()', 5000);
//$('#editBtn').val("Save");
//$('#editBtn').attr("disabled", true);
//$('#editBtn').attr("disabled", false);


    }
function enableButton() {
            $('#editBtn').removeAttr('disabled');
            $('#editBtn').val("Save");
        }

    function LoadEmpSerachBox(empId){
        tempEmpId=empId;
        var popup=window.open('<?php echo public_path('../../symfony/web/index.php/pim/searchEmployee?type=single&method=SelectEmployee1'); ?>','Locations','height=450,width=800,resizable=1,scrollbars=1');

        if(!popup.opener) popup.opener=self;
        popup.focus();
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

                childdiv="<div class='pagin' id='row_"+i+"' style='padding-top:10px;'>";
                childdiv+="<div class='centerCol' id='master' style='width:100px;'>";
                childdiv+="<div id='employeename' style='height:35px; padding-left:3px;'>"+word[0]+"</div>";
                childdiv+="</div>";

                childdiv+="<div class='centerCol' id='master' style='width:220px;'>";
                childdiv+="<div id='employeename' style='height:35px; padding-left:3px;'>"+word[1]+"</div>";
                childdiv+="</div>";

                childdiv+="<div class='centerCol' id='master' style='width:60px;'>";
                childdiv+="<div id='employeename' style='height:35px; padding-left:3px;'><a href='#' style='width:50px;' onclick='deleteCRow("+i+","+word[4]+")'><?php echo __('Remove') ?></a><input type='hidden' name='hiddenEmpNumber[]' value="+word[4]+" ></div>";
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

            $.ajax({
                type: "POST",
                async:false,
                url: "<?php echo url_for('performance/AjaxRemoveSupervisor') ?>",
                data: { EVid: $('#cmbbtype').val() , Enum:value, ESup: $('#txtSupEmpId').val()},
                dataType: "json",
                success: function(data){
                    if(data=="1"){
                        $("#row_"+id).remove();
                        removeByValue(myArray2, value);

                        $('#hiddeni').val(Number($('#hiddeni').val())-1);

                        $(function () {
                            $("#tohide").depagination();
                            $("#tohide").pagination();
                        });
                    }else{
                        alert("Can't Remove this Employee");
                    }
                }

            });

        }
        else{
            return false;
        }

    }




            $(document).ready(function() {
                buttonSecurityCommon("null","editBtn","null","null");
                $('#bulkemp').hide();
                //$('#editBtn').hide();
                $('#editBtn').attr("disabled", true);
                <?php if($EVID!= null && $ETID!= null){ ?>
                  Eval="<?php echo $EVID; ?>";      
                loademployee("<?php echo $ETID; ?>");
               <?php } ?>
                $('#empRepPopBtn').click(function() {
                    var EVid=$('#cmbEtype').val();
                    var ETid=$('#cmbbtype').val();
                    var popup=window.open('<?php echo public_path('../../symfony/web/index.php/pim/searchEmployee?EVid=1&ETid=1&type=multiple&method=SelectEmployee'); ?>','Locations','height=450,width=800,resizable=1,scrollbars=1');

                   if(!popup.opener) popup.opener=self;
                   popup.focus();
               });
               getData(1);
               //Validate the form
               $("#frmSave").validate({

                   rules: {

                       cmbbtype: { required: true}

                   },
                   messages: {
                       cmbbtype: { required:"<?php echo __("Evaluation is required ") ?>"}
                   }
               });

               $("#options").hide();

               $('#empRepPopBtn1').click(function() {

                   var popup=window.open('<?php echo public_path('../../symfony/web/index.php/pim/searchEmployee?type=single&method=SelectEmployee1'); ?>','Locations','height=450,width=800,resizable=1,scrollbars=1');

                   if(!popup.opener) popup.opener=self;
                   popup.focus();
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

                   if($('#txtSupEmpId').val()==""){
                       alert("<?php echo __("Please Select an Employee as a Supervisor.") ?>");
                       return false;
                   }else{

                       $("#txtEmpId").val(myArray2);
                       //alert($('#txtEmpId').val());
                       var Fla=0;
                       $("input:hidden.hiddenSupId").each(function(i){

                           if(this.value==""){
                               Fla=1;
                           }



                        });
                            //if(Fla==0){
                        $('#editBtn').unbind('click').click(function() {return false}).val("<?php echo __('Wait..'); ?>");
                        $('#frmSave').submit();
                     //});
                                //$('#frmSave').submit();
                            //}
                            //else{
                                //alert("<?php  echo __('Please select the supervisor(s) before save');?>");
                            //}

                          
                   }

                    
               });

               //When click reset buton
               $("#resetBtn").click(function() {
                   location.href = "<?php echo url_for(public_path('../../symfony/web/index.php/performance/SaveSupervisor')) ?>";
               });



           });
</script>
