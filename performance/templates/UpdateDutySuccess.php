<?php
if ($lockMode == '1') {
    $editMode = false;
    $disabled = '';
} else {
    $editMode = true;
    $disabled = 'disabled="disabled"';
}
        $encrypt = new EncryptionHandler();
?>
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
        <div class="mainHeading"><h2><?php echo __("Edit Duty") ?></h2></div>
             <?php echo message() ?>
            <?php echo $form['_csrf_token']; ?>
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
                <label for="txtLocationCode"><?php echo __("Duty Code") ?> <span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <input id="txtDutyCode"  name="txtDutyCode" type="text"  class="formInputText" value="<?php echo $Duty->dut_code ?>" maxlength="10" />
            </div>

            <br class="clear"/>

             <div class="leftCol">
                <label for="txtLocationCode"><?php echo __("Duty Name") ?> <span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <input id="txtDutyName"  name="txtDutyName" type="text"  class="formInputText" value="<?php echo $Duty->dut_name ?>" maxlength="100" />
            </div>


            <div class="centerCol">
                <input id="txtDutyNameSi"  name="txtDutyNameSi" type="text"  class="formInputText" value="<?php echo $Duty->dut_name_si ?>" maxlength="100" />

            </div>
            <div class="centerCol">
                <input id="txtDutyNameTa"  name="txtDutyNameTa" type="text"  class="formInputText" value="<?php echo $Duty->dut_name_ta ?>" maxlength="100" />

            </div>
            <br class="clear"/>

            <div class="leftCol">
                <label for="txtLocationCode"><?php echo __("Duty Description") ?> <span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <textarea id="txtDutyDesc"  name="txtDutyDesc"  class="formTextArea" rows="3" cols="5" tabindex="1" ><?php echo $Duty->dut_desc ?></textarea>
            </div>


            <div class="centerCol">
                <textarea id="txtDutyDescSi" class="txtDutyDescSi" rows="3" cols="5"  tabindex="2" name="txtDutyGroupDescSi"><?php echo $Duty->dut_desc_si ?></textarea>

            </div>
            <div class="centerCol">
                <textarea id="txtDutyDescTa" class="txtDutyDescTa" rows="3" cols="5"  tabindex="3" name="txtDutyGroupDescTa" ><?php echo $Duty->dut_desc_ta ?></textarea>

            </div>
            <br class="clear"/>
            <div class="leftCol">
                <label for="txtLocationCode"><?php echo __("Duty Group") ?> <span class="required">*</span></label>
            </div>
            <div class="centerCol">
                 <select name="cmbDutyGroup" class="formSelect" style="width: 150px;" tabindex="4">
                    <option value=""><?php echo __("--Select--") ?></option>
                    <?php foreach ($DutyGroupList as $DutyGroup) {
 ?>
                            <option value="<?php echo $DutyGroup->dtg_id ?>" <?php if($Duty->dtg_id== $DutyGroup->dtg_id){ echo " selected=selected"; }  ?> ><?php
                            if ($myCulture == 'en') {
                                $abcd = "dtg_name";
                            } else {
                                $abcd = "dtg_name_" . $myCulture;
                            }
                            if ($DutyGroup->$abcd == "") {
                                echo $DutyGroup->dtg_name;
                            } else {
                                echo $DutyGroup->$abcd;
                            }
                    ?></option>
<?php                     } ?>
                </select>
            </div>
            <br class="clear"/>
            <div class="leftCol">
                <label for="txtLocationCode"><?php echo __("Rating Method") ?> <span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <select name="cmbRate" class="formSelect" style="width: 150px;" tabindex="4">
                    <option value=""><?php echo __("--Select--") ?></option>
                    <?php foreach ($RateList as $Rate) {
 ?>
                            <option value="<?php echo $Rate->rate_id ?>" <?php if($Rate->rate_id== $Duty->rate_id){ echo " selected=selected"; }  ?> ><?php
                            if ($myCulture == 'en') {
                                $abcd = "rate_name";
                            } else {
                                $abcd = "rate_name_" . $myCulture;
                            }
                            if ($Rate->$abcd == "") {
                                echo $Rate->rate_name;
                            } else {
                                echo $Rate->$abcd;
                            }
                    ?></option>
<?php                     } ?>
                </select>
            </div>
            <br class="clear"/>
            <br class="clear"/>
        <div class="formbuttons">
            <input type="button" class="<?php echo $editMode ? 'editbutton' : 'savebutton'; ?>" name="EditMain" id="editBtn"
                   value="<?php echo $editMode ? __("Edit") : __("Save"); ?>"
                   title="<?php echo $editMode ? __("Edit") : __("Save"); ?>"
                   onmouseover="moverButton(this);" onmouseout="moutButton(this);"/>
            <input type="reset" class="clearbutton" id="btnClear" tabindex="5"
                   onmouseover="moverButton(this);" onmouseout="moutButton(this);"	<?php echo $disabled; ?>
                   value="<?php echo __("Reset"); ?>" />
            <input type="button" class="backbutton" id="btnBack"
                   value="<?php echo __("Back") ?>" tabindex="18"  onclick="goBack();"/>
        </div>
        </form>

    </div>
    <div class="requirednotice"><?php echo __("Fields marked with an asterisk") ?><span class="required"> * </span> <?php echo __("are required") ?></div>
    <br class="clear" />
</div>


<script type="text/javascript">

    $(document).ready(function() {
        buttonSecurityCommon("null","null","editBtn","null");
<?php if ($editMode == true) { ?>
                              $('#frmSave :input').attr('disabled', true);
                              $('#editBtn').removeAttr('disabled');
                              $('#btnBack').removeAttr('disabled');
<?php } ?>

                       //Validate the form
        $("#frmSave").validate({

            rules: {
                cmbDutyGroup:{required: true},
                cmbRate:{required: true},
                txtDutyCode:{required: true,noSpecialCharsOnly: true, maxlength:10},
                txtDutyName: { required: true,noSpecialCharsOnly: true, maxlength:100 },
                txtDutyNameSi: {noSpecialCharsOnly: true, maxlength:100 },
                txtDutyNameTa: {noSpecialCharsOnly: true, maxlength:100 },
                txtDutyDesc: { required: true,noSpecialCharsOnly: true, maxlength:200 },
                txtDutyDescSi: {noSpecialCharsOnly: true, maxlength:200 },
                txtDutyDescTa: {noSpecialCharsOnly: true, maxlength:200 }
            },
            messages: {
                cmbDutyGroup:{required:"<?php echo __("This field is required") ?>"},
                cmbRate:{required:"<?php echo __("This field is required") ?>"},
                txtDutyCode:{required:"<?php echo __("This field is required") ?>",maxlength:"<?php echo __("Maximum 10 Characters") ?>",noSpecialCharsOnly:"<?php echo __("Special Characters are not allowed") ?>"},
                txtDutyName: {required:"<?php echo __("This field is required") ?>",maxlength:"<?php echo __("Maximum 100 Characters") ?>",noSpecialCharsOnly:"<?php echo __("Special Characters are not allowed") ?>"},
                txtDutyNameSi:{maxlength:"<?php echo __("Maximum 100 Characters") ?>",noSpecialCharsOnly:"<?php echo __("Special Characters are not allowed") ?>"},
                txtDutyNameTa:{maxlength:"<?php echo __("Maximum 100 Characters") ?>",noSpecialCharsOnly:"<?php echo __("Special Characters are not allowed") ?>"},
                txtDutyDesc: {required:"<?php echo __("This field is required") ?>",maxlength:"<?php echo __("Maximum 200 Characters") ?>",noSpecialCharsOnly:"<?php echo __("Special Characters are not allowed") ?>"},
                txtDutyDescSi:{maxlength:"<?php echo __("Maximum 200 Characters") ?>",noSpecialCharsOnly:"<?php echo __("Special Characters are not allowed") ?>"},
                txtDutyDescTa:{maxlength:"<?php echo __("Maximum 200 Characters") ?>",noSpecialCharsOnly:"<?php echo __("Special Characters are not allowed") ?>"}

            }
        });

                       // When click edit button
                       $("#frmSave").data('edit', <?php echo $editMode ? '1' : '0' ?>);

                       $("#editBtn").click(function() {

                           var editMode = $("#frmSave").data('edit');
                           if (editMode == 1) {
                               // Set lock = 1 when requesting a table lock

            location.href="<?php echo url_for('performance/UpdateDuty?id=' . $encrypt->encrypt($Duty->dut_id) . '&lock=1') ?>";
                           }
                           else {

                               $('#frmSave').submit();
                           }


                       });

                       //When Click back button
                       $("#btnBack").click(function() {
                           location.href = "<?php echo url_for(public_path('../../symfony/web/index.php/performance/Duty')) ?>";
                       });

                       //When click reset buton
                       $("#btnClear").click(function() {
                           // Set lock = 0 when resetting table lock
                           location.href="<?php echo url_for('performance/UpdateDuty?id=' . $encrypt->encrypt($Duty->dut_id) . '&lock=0') ?>";
                       });
                   });
</script>
