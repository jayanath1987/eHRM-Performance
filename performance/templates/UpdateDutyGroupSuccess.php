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
        <div class="mainHeading"><h2><?php echo __("Edit Duty Group") ?></h2></div>
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
                <label for="txtLocationCode"><?php echo __("Duty Group Code") ?> <span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <input id="txtDutyGroupCode"  name="txtDutyGroupCode" type="text"  class="formInputText" maxlength="10" value="<?php echo $DutyGroup->dtg_code; ?>" />
            </div>

            <br class="clear"/>

             <div class="leftCol">
                <label for="txtLocationCode"><?php echo __("Duty Group Name") ?> <span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <input id="txtDutyGroupName"  name="txtDutyGroupName" type="text"  class="formInputText" value="<?php echo $DutyGroup->dtg_name; ?>" maxlength="100" />
            </div>


            <div class="centerCol">
                <input id="txtDutyGroupNameSi"  name="txtDutyGroupNameSi" type="text"  class="formInputText" value="<?php echo $DutyGroup->dtg_name_si; ?>" maxlength="100" />

            </div>
            <div class="centerCol">
                <input id="txtDutyGroupNameTa"  name="txtDutyGroupNameTa" type="text"  class="formInputText" value="<?php echo $DutyGroup->dtg_name_ta; ?>" maxlength="100" />

            </div>
            <br class="clear"/>

            <div class="leftCol">
                <label for="txtLocationCode"><?php echo __("Duty Group Description") ?> <span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <textarea id="txtDutyGroupDesc"  name="txtDutyGroupDesc"  class="formTextArea" rows="3" cols="5" tabindex="1" ><?php echo $DutyGroup->dtg_desc; ?></textarea>
            </div>


            <div class="centerCol">
                <textarea id="txtDutyGroupDescSi" class="txtDutyGroupDescSi" rows="3" cols="5"  tabindex="2" name="txtDutyGroupDescSi"><?php echo $DutyGroup->dtg_desc_si; ?></textarea>

            </div>
            <div class="centerCol">
                <textarea id="txtDutyGroupDescTa" class="txtDutyGroupDescTa" rows="3" cols="5"  tabindex="3" name="txtDutyGroupDescTa" ><?php echo $DutyGroup->dtg_desc_ta; ?></textarea>

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
                       $("#frmSave").data('edit', <?php echo $editMode ? '1' : '0' ?>);

                       $("#editBtn").click(function() {

                           var editMode = $("#frmSave").data('edit');
                           if (editMode == 1) {
                               // Set lock = 1 when requesting a table lock

            location.href="<?php echo url_for('performance/UpdateDutyGroup?id=' . $encrypt->encrypt($DutyGroup->dtg_id) . '&lock=1') ?>";
                           }
                           else {

                               $('#frmSave').submit();
                           }


                       });

                       //When Click back button
                       $("#btnBack").click(function() {
                           location.href = "<?php echo url_for(public_path('../../symfony/web/index.php/performance/DutyGroup')) ?>";
                       });

                       //When click reset buton
                       $("#btnClear").click(function() {
                           // Set lock = 0 when resetting table lock
                           location.href="<?php echo url_for('performance/UpdateDutyGroup?id=' . $encrypt->encrypt($DutyGroup->dtg_id) . '&lock=0') ?>";
                       });
                   });
</script>
