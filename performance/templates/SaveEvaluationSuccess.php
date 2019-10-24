<?php
if ($mode == '1') {
    $editMode = false;
    $disabled = '';
} else {
    $editMode = true;
    $disabled = 'disabled="disabled"';
}
$encrypt = new EncryptionHandler();
?>
<?php
require_once ROOT_PATH . '/lib/common/LocaleUtil.php';
?>
<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery-ui.min.js') ?>"></script>
<link href="<?php echo public_path('../../themes/orange/css/jquery/jquery-ui.css') ?>" rel="stylesheet" type="text/css"/>

<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery.validate.js') ?>"></script>
<script type="text/javascript" src="<?php echo public_path('../../scripts/time.js') ?>"></script>
<div class="formpage4col" >
    <div class="navigation">
        <style type="text/css">
            div.formpage4col input[type="text"]{
                width: 180px;
            }
        </style>

    </div>
    <div id="status"></div>
    <div class="outerbox">
        <?php if ($mode == '1') {
            ?>
            <div class="mainHeading"><h2><?php echo __("Define Evaluation") ?></h2></div>
            <?php echo message(); ?>
        <?php } else {
            ?>
            <div class="mainHeading"><h2><?php echo __("Edit  Evaluation") ?></h2></div>
            <?php echo message(); ?>
        <?php } ?>
        <form name="frmSave" id="frmSave" method="post"  action="">
            <div class="leftCol">
                &nbsp;
            </div>

            <br class="clear"/>

            <div class="leftCol" style="padding-top: 15px;">
                <label for="txtCompanyEvaluationCode"><?php echo __("Company Evaluation") ?> <span class="required">*</span></label>
            </div>
            <div class="centerCol" style="padding-top: 20px;" id="btype">
                <select name="cmbComEvale" id="cmbComEvale" style="width: 300px;">
                    <option value=""><?php echo __("--Select--") ?></option>
                    <?php foreach ($CompanyEvaluationList as $CompanyEvaluation) {
                        ?>
                        <option value="<?php echo $CompanyEvaluation->eval_id; ?>" <?php
                    if ($CompanyEvaluation->eval_id == $disAct->eval_id
                    )
                        echo "selected";
                        ?>> <?php
                            if ($myCulture == 'en') {
                                echo $CompanyEvaluation->eval_name;
                            } elseif ($myCulture == 'si') {
                                if (($CompanyEvaluation->eval_name_si) == null) {
                                    echo $CompanyEvaluationList->eval_name;
                                } else {
                                    echo $CompanyEvaluation->eval_name_si;
                                }
                            } elseif ($myCulture == 'ta') {
                                if (($CompanyEvaluation->eval_name_ta) == null) {
                                    echo $CompanyEvaluation->eval_name;
                                } else {
                                    echo $CompanyEvaluation->eval_name_ta;
                                }
                            }
                        ?></option>
                    <?php } ?>
                </select>
            </div>

            <br class="clear"/>

            <div class="leftCol">
                <label for="txtDesignationCode"><?php echo __("Designation") ?> <span class="required">*</span></label>
            </div>

            <div class="centerCol" style="padding-top: 8px;">
                <select name="cmbComDesignation" id="cmbComDesignation" style="width: 250px;">
                    <option value=""><?php echo __("--Select--") ?></option>
                    <?php foreach ($DesignationList as $Designation) {
                        ?>
                        <option value="<?php echo $Designation->id; ?>" <?php
                    if ($Designation->id == $disAct->jobtit_code
                    )
                        echo "selected";
                        ?>> <?php
                            if ($myCulture == 'en') {
                                echo $Designation->name;
                            } elseif ($myCulture == 'si') {
                                if (($Designation->name_si) == null) {
                                    echo $Designation->name;
                                } else {
                                    echo $Designation->name_si;
                                }
                            } elseif ($myCulture == 'ta') {
                                if (($Designation->name_ta) == null) {
                                    echo $Designation->name;
                                } else {
                                    echo $Designation->name_ta;
                                }
                            }
                        ?></option>
                    <?php } ?>
                </select>
            </div>
            <br class="clear"/>

            <div class="leftCol">
                <label for="txtLevelCode"><?php echo __("Level") ?> <span class="required">*</span></label>
            </div>

            <div class="centerCol" style="padding-top:8px;">
                <select name="cmbComLevel" id="cmbComLevel" style="width: 150px;">
                    <option value=""><?php echo __("--Select--") ?></option>
                    <?php foreach ($LevelList as $Level) {
                        ?>
                        <option value="<?php echo $Level->level_code; ?>" <?php
                    if ($Level->level_code == $disAct->level_code
                    )
                        echo "selected";
                        ?>> <?php
                            if ($myCulture == 'en') {
                                echo $Level->level_name;
                            } elseif ($myCulture == 'si') {
                                if (($Level->level_name_si) == null) {
                                    echo $Level->level_name;
                                } else {
                                    echo $Level->level_name_si;
                                }
                            } elseif ($myCulture == 'ta') {
                                if (($Level->level_name_ta) == null) {
                                    echo $Level->level_name;
                                } else {
                                    echo $Level->level_name_ta;
                                }
                            }
                        ?></option>
                    <?php } ?>
                </select>
            </div>
            <br class="clear"/>

            <div class="leftCol">
                <label for="txtServiceCode"><?php echo __("Service") ?> <span class="required">*</span></label>
            </div>

            <div class="centerCol" style="padding-top:8px;">
                <select name="cmbComService" id="cmbComService" style="width: 150px;" onclick="getJobRoleList()">
                    <option value=""><?php echo __("--Select--") ?></option>
                    <?php foreach ($ServiceList as $Service) {
                        ?>
                        <option value="<?php echo $Service->service_code; ?>" <?php
                    if ($Service->service_code == $disAct->service_code
                    )
                        echo "selected";
                        ?>><?php
                            if ($myCulture == 'en') {
                                echo $Service->service_name;
                            } elseif ($myCulture == 'si') {
                                if (($Service->service_name_si) == null) {
                                    echo $Service->service_name;
                                } else {
                                    echo $Service->service_name_si;
                                }
                            } elseif ($myCulture == 'ta') {
                                if (($Service->service_name_ta) == null) {
                                    echo $Service->service_name;
                                } else {
                                    echo $Service->service_name_ta;
                                }
                            }
                        ?></option>
                    <?php } ?>
                </select>
            </div>
            <br class="clear"/>

            <div class="leftCol">
                <label for="txtLocationCode"><?php echo __("Job Role") ?> <span class="required">*</span></label>
            </div>
            <div class="centerCol" style="padding-top:8px;" id="jobrole" >

                <select multiple="multiple" size="10" style="width:130px;" id="jobRoleList" name="jobrole[]">
                    <?php foreach ($Job_Role_List as $Job_Role) {
                        ?>
                        <option value="<?php echo $Job_Role->jrl_id; ?>"   <?php
                    foreach ($assignJobRoleList as $assignJobRole) {
                        if ($Job_Role->jrl_id == $assignJobRole->jrl_id
                        )
                            echo "selected";
                    }
                        ?>> <?php
                            if ($myCulture == 'en') {
                                echo $Job_Role->jrl_name;
                            } elseif ($myCulture == 'si') {
                                if (($Job_Role->jrl_name_si) == null) {
                                    echo $Job_Role->jrl_name;
                                } else {
                                    echo $Job_Role->jrl_name_si;
                                }
                            } elseif ($myCulture == 'ta') {
                                if (($Job_Role->jrl_name_ta) == null) {
                                    echo $Job_Role->jrl_name;
                                } else {
                                    echo $Job_Role->jrl_name_ta;
                                }
                            }
                        ?></option>
                        <?php } ?>
                </select>
            </div>
            <br class="clear"/><br class="clear"/>
            <div id="dutygroup">
                <div class="centerCol" style="padding-left: 87px;">
                    <label class="languageBar" style="margin-left: 40px;"><?php echo __("Duty Group") ?></label>
                </div>

                <div class="centerCol" >
                    <label class="languageBar" ><?php echo __("Duties") ?></label>
                </div>
                <div class="centerCol" >
                    <label class="languageBar"><?php echo __("Weightage") ?><span class="required">*</span></label>
                </div>
            </div>
            <div class="centerCol" style="padding-left: 125px;" >
                <table cellpadding="0" cellspacing="0" border="0" class="data-table">
                    <?php
                    $row = -1;
                    foreach ($DutyList as $Duty) {
                        $row = $row + 1;
                        ?>
                        <tr>
                            <td>
                                <label class="languageBar"><?php echo $Duty->PerformanceDutyGroup->dtg_name; ?></label></td>
                            <td>

                                <input type='checkbox' class='checkbox innercheckbox'name='chkLocID[]' id="$row" value="<?php echo $Duty->dut_id ?>"<?php
                    foreach ($AssignDutyList as $AssignDuty) {
                        if ($DutyList[$row]['dut_id'] == $AssignDuty['dut_id']) {
                            echo "checked";
                        }
                    }
                        ?> />
                            </td>

                            <td style="width: 185px; float:left; padding-top: 8px; ">
                                <?php echo $Duty->dut_name; ?>
                            </td>

                            <td style="padding-left: 5px;">

                                <input id="txtDutyWeightage" class='textbox innertextbox' name="DutyWeightage[]" type="text" style="width: 52px;" class="txt" value="<?php
                                foreach ($AssignDutyList as $AssignDuty) {
                                    if ($DutyList[$row]['dut_id'] == $AssignDuty['dut_id']) {
                                        echo $AssignDuty->dut_weightage;
                                    }
                                }
                                ?>" maxlength="10"/>
                            </td>

                        </tr>
                    <?php } ?>
                </table>
            </div>

            <br class="clear"/>
            <div class="leftCol">
                <label for="txtProjectCode"><?php echo __("Project Weightage") ?> <span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <input id="txtProjectCode"  name="txtProjectCode" type="text"  style="width: 52px;" class="formInputText" value="<?php echo $disAct->eval_dtl_project_percentage; ?>" maxlength="5" />

            </div>
            <br class="clear"/>
            <div class="leftCol">
                <label for="txtDutieCode"><?php echo __("Duties Weightage") ?> <span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <input id="txtDutieCode"  name="txtDutieCode" type="text" style="width: 52px;"  class="formInputText" value="<?php echo $disAct->eval_dtl_duty_percentage; ?>" maxlength="5" />

                <input id="txtHid

                       denReqID"  name="txtHiddenReqID" type="hidden"  class="inputText" value="<?php echo $disAct->eval_dtl_id; ?>" maxlength="100" />

            </div>

            <br class="clear"/>
            <div class="formbuttons">
                <input type="button" class="<?php echo $editMode ? 'editbutton' : 'savebutton'; ?>" name="EditMain" id="editBtn"
                       value="<?php echo $editMode ? __("Edit") : __("Save"); ?>"
                       title="<?php echo $editMode ? __("Edit") : __("Save"); ?>"
                       onmouseover="moverButton(this);" onmouseout="moutButton(this);"/>
                <input type="reset" class="clearbutton" id="btnClear" tabindex="5"
                       onmouseover="moverButton(this);" onmouseout="moutButton(this);"<?php echo $disabled; ?>
                       value="<?php echo __("Reset"); ?>" />
                <input type="button" class="backbutton" id="btnBack"
                       value="<?php echo __("Back") ?>" tabindex="10" />
            </div>
        </form>
    </div>
    <div class="requirednotice"><?php echo __("Fields marked with an asterisk") ?><span class="required"> * </span> <?php echo __("are required") ?></div>
    <br class="clear" />
</div>


<script type="text/javascript">

    //load JobRoleList
    function getJobRoleList(){     
        var level_code = $('#cmbComLevel').val();
        var service_code =  $('#cmbComService').val();
        var designation_code = $('#cmbComDesignation').val();
   
        $.post(
        
        "<?php echo url_for('performance/ajaxloadJobRoleList') ?>", //Ajax file
                
        { level_code: level_code, service_code:service_code, designation_code:designation_code },  // create an object will all values

        //function that is called when server returns a value.
        function(data){     

            var selectbox="<select name='jobrole[]' multiple='multiple' id='jobRoleList'size='10'; style='width: 130px;' >";
            $.each(data, function(key, value) {
                selectbox=selectbox +"<option value="+key+">"+value+"</option>";
            });
            selectbox=selectbox +"</select>";
            $('#jobrole').html(selectbox);
            
        },
        //How you want the data formated when it is returned from the server.
        "json"

    );
    }

    $(document).ready(function() {


        buttonSecurityCommon(null,"editBtn",null,null);

        //disable Copy and past
        $(":input").live("cut copy paste",function(e) {
            e.preventDefault();
        });

        //page load time disable DutyWeightage
        $(function(){
            $('.innertextbox').each(function(){
                if ($(this).val() === '') {
                    $(this).attr('disabled', 'disabled');
                }
            });
        });

        validateText(".innertextbox");
        validateText(".formInputText");

        //vlidate textboxes have text value
        function validateText(type) {
            $(type).change(function() {
                if(isNaN(this.value)){
                    $(this).val("");
                    return false;
                }
                else if($(this).val()>100){
                    $(this).val("");
                    $(this).val("100.00");
                    return false;                          
                }        
                else if($(this).val() < 1){
                    $(this).val("");
                    $(this).val("0.00");
                    return false;       
                }});
        }
        //enable DutyWeightage textbox
        $(".innercheckbox").click(function() {
            var index = $(this).index(".innercheckbox");
            $(".innertextbox:eq("+index+")").attr('disabled',! this.checked)
            if(!this.checked){
                $(".innertextbox:eq("+index+")").val("");
            }
        });

        //Calculate DutyWeightage Total
        $(".innertextbox").each(function() {
            $(this).change(function(){
                calculateSum(".innertextbox");
            });
        });

        //Calculate Project and Duties Total
        $(".formInputText").each(function() {
            $(this).change(function(){
                calculateSum(".formInputText");
            });
        });

        //Calculate DutyWeightage Total
        function calculateSum(type) {

            var sum = 0;
            //iterate through each textboxes and add the values

            $(type).each(function() {
                //add only if the value is number
                if(!isNaN(this.value) && this.value.length!=0) {
                    sum += parseFloat(this.value);
                }

            });

            if(sum > 100){
                return false;
            }else if(sum == 100){
                return true;
            }else if(sum < 100){
                return false;
            }

        }

        function calculateSumCheck() {
            alert("sdfsdfsdf");
            calculateSum(".innertextbox");
            calculateSum(".formInputText");
        }
<?php if ($mode == 0) { ?>
            $("#editBtn").show();
            buttonSecurityCommon(null,null,"editBtn",null);
            $('#frmSave :input').attr('disabled', true);
            $('#editBtn').removeAttr('disabled');
            $('#btnBack').removeAttr('disabled');
<?php } ?>

        //Validate the fo9990rm
        $("#frmSave").validate({

            rules: {
                cmbComEvale:{required: true},
                cmbComDesignation:{required: true},
                cmbComLevel:{required: true},
                cmbComService:{required: true},
                                jobRoleList:{required: true},
                txtDutieCode:{required: true,noSpecialCharsOnly: true, maxlength:6}
            },
            messages: {
                cmbComEvale:{required:"<?php echo __("This field is required") ?>"},
                cmbComDesignation:{required:"<?php echo __("This field is required") ?>"},
                cmbComLevel:{required:"<?php echo __("This field is required") ?>"},
                cmbComService:{required:"<?php echo __("This field is required") ?>"},
                                jobRoleList:{required:"<?php echo __("This field is required") ?>"},
                txtDutieCode:{required:"<?php echo __("This field is required") ?>",maxlength:"<?php echo __("Maximum 6 Characters") ?>"}

            }
        });

        // When click edit button
        $("#frmSave").data('edit', <?php echo $editMode ? '1' : '0' ?>);

        // When click edit button
        $("#editBtn").click(function() {
            var editMode = $("#frmSave").data('edit');
            if (editMode == 1) {
                // Set lock = 1 when requesting a table lock
                location.href="<?php echo url_for('performance/SaveEvaluation?id=' . $disAct->eval_dtl_id . '&lock=1') ?>";
            }
            else {
                var count = 0;
                $(".innercheckbox").each(function() {
                    var index = $(this).index(".innercheckbox");

                    $(".innertextbox:eq("+index+")").attr('disabled', !this.checked)
                    if(this.checked && isEmpty($(".innertextbox:eq("+index+")").val()))
                    {
                        count ++;
                    }
                });
                if(count.valueOf() > 0){
                    alert("Please Enter Weightage.");
                }
                else
                {
                    
                    if($('#cmbComEvale').val()==''){
                            alert("<?php echo __('Please Select Evaluation') ?>");
                            return false;
                        }
                        if($('#cmbComDesignation').val()==''){
                            alert("<?php echo __('Please Select Designation') ?>");
                            return false;
                        }
                        if($('#cmbComLevel').val()==''){
                            alert("<?php echo __('Please Select Level') ?>");
                            return false;
                        }
                        if($('#cmbComService').val()==''){
                            alert("<?php echo __('Please Select Service') ?>");
                            return false;
                        }
                        //alert(document.getElementById("jobRoleList").value);
                        var foo = []; 
                        $('#jobRoleList').each(function(i, selected){ 
                          foo[i] = $(selected).val(); 

                        });


                        if(foo == ""){                                                     
                            alert("<?php echo __('Please Select Job Role') ?>");
                            return false;                           
                        }

                    
                    //if(calculateSum(".innertextbox") && calculateSum(".formInputText")){
                    if(calculateSum(".innertextbox")){
                        var project=parseFloat($('#txtProjectCode').val());
                        var Duties=parseFloat($('#txtDutieCode').val());
                        var tot= project+Duties;
                        
                        if(tot!='100'){
                            alert("<?php echo __('Duty Weightage & Project Weightage Total Should equal to 100') ?>");
                            return false;
                        }else{
                        
                        $('#frmSave').submit();
                        }
                    }else{
                        alert("<?php echo __('Duty Weightage Total Should equal to 100') ?>");
                    }
                }
            }

        });

        //When click reset buton
        $("#btnClear").click(function() {
            <?php if($disAct->eval_dtl_id!=null){ ?>
            location.href="<?php echo url_for('performance/SaveEvaluation?id=' . $disAct->eval_dtl_id . '&lock=0') ?>";
            <?php }else{ ?>
            location.href="<?php echo url_for('performance/SaveEvaluation') ?>";
            <?php } ?>
        });

        //When Click back button
        $("#btnBack").click(function() {
            location.href = "<?php echo url_for(public_path('../../symfony/web/index.php/performance/Evaluation')) ?>";
        });

    });
</script>



