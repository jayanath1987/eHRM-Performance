<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery.validate.js') ?>"></script>
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
        <div class="mainHeading"><h2><?php echo __("Define Duty Group") ?></h2></div>
        <form name="frmSave" id="frmSave" method="post"  action="">
            <div class="leftCol">
                &nbsp;
            </div>
            <div class="centerCol">
                <label class="languageBar"><?php echo __("English") ?></label>
            </div>
            <div class="centerCol">
                <label class="languageBar"><?php echo __("Sinhala") ?></label>
            </div>
            <div class="centerCol">
                <label class="languageBar"><?php echo __("Tamil") ?></label>
            </div>
            <br class="clear"/>
            <div class="leftCol">
                <label for="txtLocationCode"><?php echo __("Duty Group Code") ?> <span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <input id="txtDutyGroupCode"  name="txtDutyGroupCode" type="text"  class="formInputText" value="" maxlength="10" />
            </div>

            <br class="clear"/>

             <div class="leftCol">
                <label for="txtLocationCode"><?php echo __("Duty Group Name") ?> <span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <input id="txtDutyGroupName"  name="txtDutyGroupName" type="text"  class="formInputText" value="" maxlength="100" />
            </div>


            <div class="centerCol">
                <input id="txtDutyGroupNameSi"  name="txtDutyGroupNameSi" type="text"  class="formInputText" value="" maxlength="100" />

            </div>
            <div class="centerCol">
                <input id="txtDutyGroupNameTa"  name="txtDutyGroupNameTa" type="text"  class="formInputText" value="" maxlength="100" />

            </div>
            <br class="clear"/>
            
            <div class="leftCol">
                <label for="txtLocationCode"><?php echo __("Duty Group Description") ?> <span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <textarea id="txtDutyGroupDesc"  name="txtDutyGroupDesc"  class="formTextArea" rows="3" cols="5" tabindex="1" ></textarea>
            </div>


            <div class="centerCol">
                <textarea id="txtDutyGroupDescSi" class="txtDutyGroupDescSi" rows="3" cols="5"  tabindex="2" name="txtDutyGroupDescSi"></textarea>

            </div>
            <div class="centerCol">
                <textarea id="txtDutyGroupDescTa" class="txtDutyGroupDescTa" rows="3" cols="5"  tabindex="3" name="txtDutyGroupDescTa" ></textarea>

            </div>
            <br class="clear"/>
            <br class="clear"/>
            <div class="formbuttons">
                <input type="button" class="savebutton" id="editBtn"

                       value="<?php echo __("Save") ?>" tabindex="8" />
                <input type="button" class="clearbutton"  id="resetBtn"
                       value="<?php echo __("Reset") ?>" tabindex="9" />
                <input type="button" class="backbutton" id="btnBack"
                       value="<?php echo __("Back") ?>" tabindex="10" />
            </div>
        </form>
    </div>
    <div class="requirednotice"><?php echo __("Fields marked with an asterisk") ?><span class="required"> * </span> <?php echo __("are required") ?></div>
    <br class="clear" />
</div>

<script type="text/javascript">

    $(document).ready(function() {
        buttonSecurityCommon("null","editBtn","null","null");


        //Validate the form
        $("#frmSave").validate({

            rules: {
                txtDutyGroupCode:{required: true,noSpecialCharsOnly: true, maxlength:10},
                txtDutyGroupName: { required: true,noSpecialCharsOnly: true, maxlength:100 },
                txtDutyGroupNameSi: {noSpecialCharsOnly: true, maxlength:100 },
                txtDutyGroupNameTa: {noSpecialCharsOnly: true, maxlength:100 },
                txtDutyGroupDesc: { required: true,noSpecialCharsOnly: true, maxlength:200 },
                txtDutyGroupDescSi: {noSpecialCharsOnly: true, maxlength:200 },
                txtDutyGroupDescTa: {noSpecialCharsOnly: true, maxlength:200 }
            },
            messages: {
                txtDutyGroupCode:{required:"<?php echo __("This field is required") ?>",maxlength:"<?php echo __("Maximum 10 Characters") ?>",noSpecialCharsOnly:"<?php echo __("Special Characters are not allowed") ?>"},
                txtDutyGroupName: {required:"<?php echo __("This field is required") ?>",maxlength:"<?php echo __("Maximum 100 Characters") ?>",noSpecialCharsOnly:"<?php echo __("Special Characters are not allowed") ?>"},
                txtDutyGroupNameSi:{maxlength:"<?php echo __("Maximum 100 Characters") ?>",noSpecialCharsOnly:"<?php echo __("Special Characters are not allowed") ?>"},
                txtDutyGroupNameTa:{maxlength:"<?php echo __("Maximum 100 Characters") ?>",noSpecialCharsOnly:"<?php echo __("Special Characters are not allowed") ?>"},
                txtDutyGroupDesc: {required:"<?php echo __("This field is required") ?>",maxlength:"<?php echo __("Maximum 200 Characters") ?>",noSpecialCharsOnly:"<?php echo __("Special Characters are not allowed") ?>"},
                txtDutyGroupDescSi:{maxlength:"<?php echo __("Maximum 200 Characters") ?>",noSpecialCharsOnly:"<?php echo __("Special Characters are not allowed") ?>"},
                txtDutyGroupDescTa:{maxlength:"<?php echo __("Maximum 200 Characters") ?>",noSpecialCharsOnly:"<?php echo __("Special Characters are not allowed") ?>"}
                                        
            }
        });

        // When click edit button
        $("#editBtn").click(function() {
            $('#frmSave').submit();
        });

        //When click reset buton
        $("#resetBtn").click(function() {
            document.forms[0].reset('');
        });

        //When Click back button
        $("#btnBack").click(function() {
            location.href = "<?php echo url_for(public_path('../../symfony/web/index.php/performance/DutyGroup')) ?>";
        });

    });
</script>
