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
        <div class="mainHeading"><h2><?php echo __("Edit Rate") ?></h2></div>
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
                <label for="txtLocationCode"><?php echo __("Rating Method Code") ?> <span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <input id="txtRateCode"  name="txtRateCode" type="text"  class="formInputText" value="<?php echo $Rate->rate_code; ?>" maxlength="10" />
            </div>

            <br class="clear"/>

             <div class="leftCol">
                <label for="txtLocationCode"><?php echo __("Rating Method Name") ?> <span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <input id="txtRateName"  name="txtRateName" type="text"  class="formInputText" value="<?php echo $Rate->rate_name; ?>" maxlength="100" />
            </div>


            <div class="centerCol">
                <input id="txtRateNameSi"  name="txtRateNameSi" type="text"  class="formInputText" value="<?php echo $Rate->rate_name_si; ?>" maxlength="100" />

            </div>
            <div class="centerCol">
                <input id="txtRateNameTa"  name="txtRateNameTa" type="text"  class="formInputText" value="<?php echo $Rate->rate_name_ta; ?>" maxlength="100" />

            </div>
            <br class="clear"/>

            <div class="leftCol">
                <label for="txtLocationCode"><?php echo __("Rating Method Description") ?> <span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <textarea id="txtRateDesc"  name="txtRateDesc"  class="formTextArea" rows="3" cols="5" tabindex="1" ><?php echo $Rate->rate_desc; ?></textarea>
            </div>


            <div class="centerCol">
                <textarea id="txtRateDescSi" class="formTextArea" rows="3" cols="5"  tabindex="2" name="txtRateDescSi"><?php echo $Rate->rate_desc_si; ?></textarea>

            </div>
            <div class="centerCol">
                <textarea id="txtRateDescTa" class="formTextArea" rows="3" cols="5"  tabindex="3" name="txtRateDescTa" ><?php echo $Rate->rate_desc_ta; ?></textarea>

            </div>
            <br class="clear"/>
            <?php  $currentConfirm=$Rate->rate_option;  ?>
            <div class="centerCol" style="width: 500px;">
                <label><input type="radio" name="optrate" id="optrate1"   value="1" <?php if ($currentConfirm == 1)echo "checked" ?> /><?php echo __("A - Z"); ?></label>
                <label><input type="radio" name="optrate" id="optrate2"   value="2" <?php if ($currentConfirm == 2)echo "checked" ?> /><?php echo __("Numbers") ?></label>
                <label><input type="radio" name="optrate" id="optrate3"   value="3" <?php if ($currentConfirm == 3)echo "checked" ?> /><?php echo __("Text") ?></label>
            </div>
            <br class="clear"/>
             <div class="leftCol">
                <label for="txtLocationCode"><?php echo __("Number of Rating Method Items") ?> <span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <input id="RatingItems"  name="RatingItems" type="text"  class="formInputText" value="<?php echo $RateDetails->count(); ?>" maxlength="2" />
            </div>

            <br class="clear"/>
                        <div id="bulkemp" >

                <div id="employeeGrid" class="centerCol" style="margin-left:10px; margin-top: 8px; width: 410px; border-style:  solid; border-color: #FAD163; ">
                    <div style="">
                        <div class="centerCol" style='width:100px; background-color:#FAD163;'>
                            <label class="languageBar" style="width:100px; padding-left:2px; padding-top:2px;padding-bottom: 1px; background-color:#FAD163; margin-top: 0px;  color:#444444;"><?php echo __("Grade") ?></label>
                        </div>
                        <div class="centerCol" style='width:100px;  background-color:#FAD163;'>
                            <label class="languageBar" style="width:100px; padding-left:2px; padding-top:2px;padding-bottom: 1px; background-color:#FAD163; margin-top: 0px; color:#444444; text-align:inherit"><?php echo __("Marks") ?></label>
                        </div>
                        <div class="centerCol" style='width:110px;  background-color:#FAD163;'>
                            <label class="languageBar" style="width:100px; padding-left:2px; padding-top:2px;padding-bottom: 1px; background-color:#FAD163; margin-top: 0px; color:#444444; text-align:inherit"><?php echo __("Description") ?></label>
                        </div>
                        <div class="centerCol" style='width:100px;   background-color:#FAD163;'>
                            <label class="languageBar" style="width:100px; padding-left: 0px; padding-top:2px;padding-bottom: 1px; background-color:#FAD163; margin-top: 0px; color:#444444; text-align:inherit"><?php echo __("Remove") ?></label>
                        </div>

                    </div>
                    <div id="tohide">
                        <?php
                        if (strlen($childDiv)) {
                            echo $sf_data->getRaw('childDiv');
                        }
                        ?>

                    </div>
                    <br class="clear"/>
                </div>
            </div>

<?php foreach($RateDetails as $Item){
                        $Rates[]=$Item['rdt_grade'];

                    }    ?>
<script language="javascript">
                     myArray2= new Array();
                     phparray = new Array(); // initializing the javascript array
<?php
                //In the below lines we get the values of the php array one by one and update it in the script array.

if($Rates){
               foreach($Rates as $key => $value){
                    print "phparray.push(\"$key\");";  //This line updates the script array with new entry
                }

                }
?>

                </script>

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
            <input type="button" class="backbutton" id="Addtogridbutton"
                       value="<?php echo __("Generate Rating Method") ?>" onmouseover="moverButton(this);" onmouseout="moutButton(this);"	<?php echo $disabled; ?> onclick="addtoGrid($('#RatingItems').val())" tabindex="10" />
            <input type="button" class="backbutton" id="btnBack"
                   value="<?php echo __("Back") ?>" tabindex="18"  onclick="goBack();"/>
        </div>
        </form>

        
    </div>
    <div class="requirednotice"><?php echo __("Fields marked with an asterisk") ?><span class="required"> * </span> <?php echo __("are required") ?></div>
    <br class="clear" />
</div>


<script type="text/javascript">
//var myArray2= new Array();
//var empstatArray= new Array();
//var phparray = new Array();
var i;
            function validationComment(event,id){
                 var code = event.which || event.keyCode;

            // 65 - 90 for A-Z and 97 - 122 for a-z 95 for _ 45 for - 46 for .
            if (!((code >= 48 && code <= 57) || (code >= 65 && code <= 90) || (code >= 97 && code <= 122) || code == 95 || code == 46 || code == 45 || code == 32 || code == 43 || code == 107 || code == 9 || code == 13 || code == 20))
            {
                        $('#'+id).val("");
                        return false;
            }
            if($('#'+id).val().length>10){
                alert("<?php echo __('Maximum length should be 10 characters') ?>");
                $('#'+id).val("");
                return false;
            }
            }

           function validationDesc(event,id){
                 var code = event.which || event.keyCode;

            // 65 - 90 for A-Z and 97 - 122 for a-z 95 for _ 45 for - 46 for .
            if (!((code >= 48 && code <= 57) || (code >= 65 && code <= 90) || (code >= 97 && code <= 122) || code == 95 || code == 46 || code == 45 || code == 32 || code == 9 || code == 13 || code == 20 ))
            {
                        $('#'+id).val("");
                        return false;
            }
            if($('#'+id).val().length>100){
                alert("<?php echo __('Maximum length should be 100 characters') ?>");
                $('#'+id).val("");
                return false;
            }
            }
            function validationGradeMinMax(e,id){
             if($('#'+id).val()>100){
                $('#'+id).val("");
                $('#'+id).val("100.00");
            }
            if($('#'+id).val()< 0){
                $('#'+id).val("");
                $('#'+id).val("0.00");
            }
            }
           function validationGrade(e,id){

            if(isNaN($('#'+id).val())){
                alert("<?php echo __('Please enter Digits') ?>");
                $('#'+id).val("");
                return false;
            }

            if($('#'+id).val().length>6){
                alert("<?php echo __('Maximum Exceded') ?>");
                $('#'+id).val("");
                return false;
            }else {
                return true;
            }

            }


        function onkeyUpevent(event,id){

        }



            function addtoGrid(empid){
                if($('#RatingItems').val()==""){
                   alert('<?php echo __("Number of Rating Method Items Can not be blank.")?>');
                   return false;
                }
                var UserItems=$('#RatingItems').val();

                if(UserItems!=parseFloat(UserItems)){
                   alert('<?php echo __("Number of Rating Method Items Should be Digit.")?>');
                   return false;
                }
                if (undefined === $("input[name='optrate']:checked").val()) {
                   alert('<?php echo __("Please Select Rating Method")?>');
                   return false;
                }



                    var bConfirmed = confirm("<?php echo __("Are you sure want to Generate Items ?") ?>");
                    if (bConfirmed){
                    $.each(myArray2,function(key, value1){
                    $("#row_"+key).remove();
                    });
                    //myArray2.length = 0;
                    myArray2 = new Array();
                    }else{
                        return false;
                    }
                    

                var arraycp=new Array();

                var arraycp = $.merge([], myArray2);

                var items= new Array();

                for(var d=0; d<=$('#RatingItems').val(); d++){
                items[d]=d;
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

                "<?php echo url_for('admin/LoadGrid') ?>", //Ajax file



                { 'empid[]' : arraycp },  // create an object will all values

                //function that is c    alled when server returns a value.
                function(data){
                    //alert(data);

                    var childdiv="";
                     i=0;
                    var items=$('#RatingItems').val();
                    var Mark=(100/items);
                    //Mark=Math.round(Mark*100)/100;
                        if (1 == $("input[name='optrate']:checked").val()) {
                          var Grade= new Array("","A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");
                          var Max= 26;
                          var Min= 1;

                     }else if(2 == $("input[name='optrate']:checked").val()) {
                          var Grade= new Array();
                          for(var a=0; a<=100; a++ ){
                            Grade[a]=a;
                          }
                          var Max= 100;
                          var Min= 1;
                        }else if (3 == $("input[name='optrate']:checked").val()) {
                         var Grade= new Array();
                          for(var a=0; a<=100; a++ ){
                            Grade[a]="";
                          }
                          var Max= 100;
                          var Min= 1;
                        }
                    $.each(arraycp, function(key, value) {
                        if(Max >= i && Min <= i){

                                    childdiv="<div id='row_"+value+"' style='padding-top:0px;'>";
                                    childdiv+="<div class='centerCol' id='master' style='width:100px;'>";
                                    childdiv+="<div id='employeename' style='height:25px; padding-left:3px;'><input type='text'  style='width:90px; color:#444444;' name='txtGrade_"+value+"' id='txtGrade_"+value+"' value='"+Grade[value]+"' onkeypress='return validationComment(event,this.id)'  /></div>";
                                    childdiv+="</div>";

                                    childdiv+="<div class='centerCol' id='master' style='width:100px;'>";
                                    childdiv+="<div id='employeename' style='height:25px; padding-left:3px;'><input type='text'  onkeypress='return validationGrade(event,this.id)' onblur='return validationGradeMinMax(event,this.id)' style='width:90px; color:#444444;' name='txtMarks_"+value+"' id='txtMarks_"+value+"' maxlength='6'";
                                        if($("input[name='optrate']:checked").val() ==1 ){
                                    childdiv+="value="+Math.round(Mark*(items-(value-1)));
                                        }else{
                                    childdiv+="value="+Math.round(Mark*value);
                                        }
                                    childdiv+="></div></div>";


                                    childdiv+="<div class='centerCol' id='master' style='width:110px;'>";
                                    childdiv+="<div style='height:25px; padding-left:3px;'><input type='text'  style='width:90px; color:#444444;' name='txtRIDesc_"+value+"' id='txtRIDesc_"+value+"'";

                                    childdiv+="";
                                    childdiv+=" onkeypress='return validationDesc(event,this.id)'  /></div></div>";

                                    childdiv+="<div class='centerCol' id='master' style='width:100px;'>";
                                    childdiv+="<div id='employeename' style='height:25px; padding-left:3px;'><a href='#' style='width:100px;' onclick='deleteCRow("+value+","+value+")'><?php echo __('Remove') ?></a><input type='hidden' name='ITEMS_["+value+"]' value='' ></div>";
                                    childdiv+="</div>";
                                    childdiv+="<input type='hidden' name='noofhead' value="+value+" ></div>";

$('#employeeGrid').append(childdiv); }
                        i++;
                        //}
                    });
                    k=i;


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

            <?php if($disabled==''){ ?>
            var max=Math.max.apply(null, myArray2);
            if(max==id){
                answer = confirm("<?php echo __("Do you really want to Delete?") ?>");

                if (answer !=0)
                {

                    $("#row_"+id).remove();
                    removeByValue(myArray2, value);

                    $('#hiddeni').val(Number($('#hiddeni').val())-1);

                }
                else{
                    return false;
                }
                }else{
                    alert("<?php echo __("Please remove Last Rate Item first.") ?>");
                    return false;
                }
                
                <?php } ?>
            }

                        function addtoGridLoad(){

                            var childdiv="";
                             i=0;
                            <?php foreach($RateDetails as $RateItem){  ?>

                                            childdiv="<div id='row_"+i+"' style='padding-top:0px;'>";
                                            childdiv+="<div class='centerCol' id='master' style='width:100px;'>";
                                            childdiv+="<div id='employeename' style='height:25px; padding-left:3px;'><input type='text' calss='GridText' style='width:90px; color:#444444;' name='txtGrade_"+i+"' id='txtGrade_"+i+"' value='<?php  if($RateItem['rdt_grade']!= null){ echo $RateItem['rdt_grade']; } ?>'";
                                            childdiv+='<?php echo $disabled; ?>';
                                            childdiv+="maxlength='10' /></div></div>";

                                            childdiv+="<div class='centerCol' id='master' style='width:100px;'>";
                                            childdiv+="<div id='employeename' style='height:25px; padding-left:3px;'><input type='text' calss='GridText' onkeypress='return validationGrade(event,this.id)' style='width:90px; color:#444444;' name='txtMarks_"+i+"' id='txtMarks_"+i+"' maxlength='6' onblur='return validationGradeMinMax(event,this.id)'";
//                                                if($("input[name='optrate']:checked").val() ==1 ){
//                                            childdiv+="value="+Math.round(Mark*(items-(value-1)));
//                                                }else{
//                                            childdiv+="value="+Math.round(Mark*value);
//                                                }
                                            childdiv+="value='<?php if($RateItem['rdt_mark']!= null) echo $RateItem['rdt_mark']; ?>'";
                                            childdiv+='<?php echo $disabled; ?>';
                                            childdiv+="></div></div>";


                                            childdiv+="<div class='centerCol' id='master' style='width:110px;'>";
                                            childdiv+="<div style='height:25px; padding-left:3px;'><input type='text' calss='GridText' style='width:90px; color:#444444;' name='txtRIDesc_"+i+"' id='txtRIDesc_"+i+"'";

                                            childdiv+="value='<?php if($RateItem['rdt_description']!= null){ echo $RateItem['rdt_description']; }?>'";
                                            childdiv+='<?php echo $disabled; ?>';
                                            childdiv+=" onkeypress='return validationDesc(event,this.id)' maxlength='100' /></div></div>";

                                            childdiv+="<div class='centerCol' id='master' style='width:100px;'>";
                                            childdiv+="<div id='employeename' style='height:25px; padding-left:3px;'><a ";
                                            childdiv+="href='#'";

                                            childdiv+=" style='width:100px;' onclick='deleteCRow("+i+","+i+")'";
                                            childdiv+='><?php echo __('Remove'); ?>';
                                            childdiv+="</a><input type='hidden' name='ITEMS_["+i+"]' value='' ></div>";
                                            childdiv+="</div>";
                                            childdiv+="<input type='hidden' name='noofhead' value="+i+" ></div>";

        $('#employeeGrid').append(childdiv);
                    i++;
                <?php } ?>
                                
                                //}
                           


                        }


            
    $(document).ready(function() {
        buttonSecurityCommon("null","null","editBtn","null");
<?php if ($editMode == true) { ?>
                              $('#frmSave :input').attr('disabled', true);
                              $('#editBtn').removeAttr('disabled');
                              $('#btnBack').removeAttr('disabled');
<?php } ?>
    myArray2=phparray;
    arraycp=phparray;
    items=phparray;
    addtoGridLoad();
                       //Validate the form
                       $("#frmSave").validate({

            rules: {
                txtRateCode:{required: true,noSpecialCharsOnly: true, maxlength:10},
                txtRateName: { required: true,noSpecialCharsOnly: true, maxlength:100 },
                txtRateNameSi: {noSpecialCharsOnly: true, maxlength:100 },
                txtRateNameTa: {noSpecialCharsOnly: true, maxlength:100 },
                txtRateDesc: { required: true,noSpecialCharsOnly: true, maxlength:200 },
                txtRateDescSi: {noSpecialCharsOnly: true, maxlength:200 },
                txtRateDescTa: {noSpecialCharsOnly: true, maxlength:200 }
            },
            messages: {
                txtRateCode:{required:"<?php echo __("This field is required") ?>",maxlength:"<?php echo __("Maximum 10 Characters") ?>",noSpecialCharsOnly:"<?php echo __("Special Characters are not allowed") ?>"},
                txtRatepName: {required:"<?php echo __("This field is required") ?>",maxlength:"<?php echo __("Maximum 100 Characters") ?>",noSpecialCharsOnly:"<?php echo __("Special Characters are not allowed") ?>"},
                txtRateNameSi:{maxlength:"<?php echo __("Maximum 100 Characters") ?>",noSpecialCharsOnly:"<?php echo __("Special Characters are not allowed") ?>"},
                txtRateNameTa:{maxlength:"<?php echo __("Maximum 100 Characters") ?>",noSpecialCharsOnly:"<?php echo __("Special Characters are not allowed") ?>"},
                txtRateDesc: {required:"<?php echo __("This field is required") ?>",maxlength:"<?php echo __("Maximum 200 Characters") ?>",noSpecialCharsOnly:"<?php echo __("Special Characters are not allowed") ?>"},
                txtRateDescSi:{maxlength:"<?php echo __("Maximum 200 Characters") ?>",noSpecialCharsOnly:"<?php echo __("Special Characters are not allowed") ?>"},
                txtRateDescTa:{maxlength:"<?php echo __("Maximum 200 Characters") ?>",noSpecialCharsOnly:"<?php echo __("Special Characters are not allowed") ?>"}

            }
        });

                       // When click edit button
                       $("#frmSave").data('edit', <?php echo $editMode ? '1' : '0' ?>);

                       $("#editBtn").click(function() {

                           var editMode = $("#frmSave").data('edit');
                           if (editMode == 1) {
                               // Set lock = 1 when requesting a table lock

            location.href="<?php echo url_for('performance/UpdateRate?id=' . $encrypt->encrypt($Rate->rate_id) . '&lock=1') ?>";
                           }
                           else {
                               for(var k=0; k<=i; k++){
                                if($("input[name='txtGrade_"+k+"']:text").val()=='' ){
                                    alert("<?php echo __("Rating Method Items Grades can not be Blank") ?>");
                                    return false;
                                }
                                if($("input[name='txtMarks_"+k+"']:text").val()=='' ){
                                    alert("<?php echo __("Rating Method Items Marks can not be Blank") ?>");
                                    return false;
                                }
                                if($("input[name='txtRIDesc_"+k+"']:text").val()=='' ){
                                    alert("<?php echo __("Rating Method Items Description can not be Blank") ?>");
                                    return false;
                                }
                               }
                               
                               if(myArray2=='' || myArray2=='0' ){
                                    alert("<?php echo __("Rating Method Items can not be Blank") ?>");
                                    return false;
                                 }
                               
                               $('#frmSave').submit();
                                
                           }


                       });

                       //When Click back button
                       $("#btnBack").click(function() {
                           location.href = "<?php echo url_for(public_path('../../symfony/web/index.php/performance/Rate')) ?>";
                       });

                       //When click reset buton
                       $("#btnClear").click(function() {
                           // Set lock = 0 when resetting table lock
                           location.href="<?php echo url_for('performance/UpdateRate?id=' . $encrypt->encrypt($Rate->rate_id) . '&lock=0') ?>";
                       });
                   });
</script>
