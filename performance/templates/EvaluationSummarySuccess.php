<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery.autocomplete.js') ?>"></script>
<?php
$encrypt = new EncryptionHandler();
?>
<div class="outerbox">
    <div class="maincontent">

        <div class="mainHeading"><h2><?php echo __("Evaluation Summary") ?></h2></div>
        <?php echo message() ?>
        <form name="frmSearchBox" id="frmSearchBox" method="post" action="" onsubmit="return validateform();">
            <input type="hidden" name="mode" value="search">
            <div class="searchbox">

                <label class=""><?php echo __("Evaluation") ?><span class="required">*</span></label>

                    <select name="cmbbtype" id="cmbbtype" onchange="getYear(this.value);" style="width: 100px;">
                        <option value=""><?php echo __("--Select--") ?></option>
                        <?php foreach ($EvaluationList as $Evaluation) {

                        foreach ($SuperviserAllow as $Valid) {

                        if($Valid['eval_id'] == $Evaluation->eval_id){
                        ?>
                        <option value="<?php echo $Evaluation->eval_id; ?>" <?php if ($searchEvaluation == $Evaluation->eval_id)echo "selected"; ?> > <?php
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
<?php }}} ?>
                            </select>

                <label class=""><?php echo __("Evaluation Type") ?><span class="required">*</span></label>
                <select name="cmbEtype" id="cmbEtype"  style="width: 100px;">
                        <option value=""><?php echo __("--Select--") ?></option>
                        <?php foreach ($EvaluationTypeList as $EvaluationType) {
                        ?>
                            <option value="<?php echo $EvaluationType->eval_type_id; ?>" <?php if ($searchEvaluationType == $EvaluationType->eval_type_id)echo "selected"; ?> style="width: 100px;"> <?php
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
                 <label for="txtLocationCode" ><?php echo __("Year") ?></label>
                 <input id="txtYear" readonly="readonly" type="text" name="txtYear" value="<?php echo $YEAR; ?>" maxlength="4" style="width: 100px; color: #000">


<!--                <input type="submit" class="plainbtn"
                       value="<?php //echo __("Search") ?>" />
                <input type="reset" class="plainbtn"
                       value="<?php //echo __("Reset") ?>" id="resetBtn"/>-->
<br class="clear"/>
<br class="clear"/>

<label for="searchMode" style="margin-right: 10px;"><?php echo __("Search By") ?></label>


                <select name="searchMode" id="searchMode"  style="width: 100px;">
                    <option value="all"><?php echo __("--Select--") ?></option>
                    <option value="emp_display_name_" <?php if($searchMode=="emp_display_name_"){ echo "selected=selected"; }  ?> ><?php echo __("Employee Name") ?></option>
                    <option value="emp_number" <?php if($searchMode=="emp_number"){ echo "selected=selected"; }  ?> ><?php echo __("Employee ID") ?></option>
<!--                    <option value="eval_id" <?php if($searchMode=="eval_id"){ echo "selected=selected"; }  ?> ><?php echo __("Evaluation") ?></option>-->
                </select>

                <label for="searchValue" style="margin-right: 30px;"><?php echo __("Search For") ?></label>
                <input  type="text" size="20" name="searchValue" id="searchValue" value="<?php echo $searchValue ?>"  style=" width: 100px; border-left: 1px solid #888888; border-right: 1px solid #888888; border-top: 1px solid #888888"   />
                <input type="submit" class="plainbtn" style="margin-left: 40px;"
                       value="<?php echo __("Search") ?>" />
                <input type="reset" class="plainbtn"
                       value="<?php echo __("Reset") ?>" id="resetBtn"/>
                <br class="clear"/>
            </div>
        </form>
        <div class="actionbar" >
            <div class="actionbuttons">

<!--                <input type="button" class="plainbtn" id="buttonAdd"
                       value="<?php echo __("Add") ?>" />


                <input type="button" class="plainbtn" id="buttonRemove"
                       value="<?php echo __("Delete") ?>" />-->

            </div>
            <div class="noresultsbar"></div>
            <div class="pagingbar"><?php echo is_object($pglay) ? $pglay->display() : ''; ?> </div>
            <br class="clear" />
        </div>
        <br class="clear" />
        <form name="standardView" id="standardView" method="post" action="<?php echo url_for('performance/DeleteAssingEmployee') ?>">
            <input type="hidden" name="mode" id="mode" value=""/>
            <table cellpadding="0" cellspacing="0" class="data-table">
                <thead>
                    <tr>
                        <td width="50">

                            <input type="checkbox" class="checkbox" name="allCheck" value="" id="allCheck" />

                        </td>

                        <td scope="col">
                            <?php echo $sorter->sortLink('e.emp_number', __('Employee ID'), '@SDOEvaluation', ESC_RAW); ?>
                        </td>
                        <td scope="col">
                            <?php if ($Culture == 'en') {
                                $btname = 'e.emp_display_name';
                            } else {
                                $btname = 'e.emp_display_name_' . $Culture;
                            } ?>
                            <?php echo $sorter->sortLink($btname, __('Employee Name'), '@SDOEvaluation', ESC_RAW); ?>
                        </td>

                        <td scope="col">
                        <?php if ($Culture == 'en') {
                                $btname = 'EV.eval_name';
                            } else {
                                $btname = 'EV.eval_name_' . $Culture;
                            } ?>
                            <?php echo $sorter->sortLink($btname, __('Evaluation'), '@SDOEvaluation', ESC_RAW); ?>
                        </td>
                       <td scope="col">
                               <?php echo $sorter->sortLink('EV.eval_emp_status', __('Status'), '@SDOEvaluation', ESC_RAW); ?>
                        </td>
                    </tr>
                </thead>

                <tbody>
                    <?php
                            $row = 0;
                            foreach ($AssingEmployeeList as $Employee) {

                               
                               foreach ($subordinates as $sub) {

                                   if($sub['subordinateId']==$Employee->emp_number){
                                $cssClass = ($row % 2) ? 'even' : 'odd';
                                $row = $row + 1;
                    ?>
                                <tr class="<?php echo $cssClass ?>">
                                    <td >
                                        <input type='checkbox' class='checkbox innercheckbox' name='chkLocID[]' id="chkLoc" value='<?php echo $Employee->emp_number.'_'.$Employee->eval_id ?>' />
                                    </td>

                                    <td class="">
                                        <a href="<?php echo url_for('performance/UpdateSDOEvaluation?id=' . $encrypt->encrypt($Employee->emp_number.'_'.$Employee->eval_id)) ?>"><?php echo $Employee->EmployeeSubordinate->employeeId; ?></a>
                                    </td>

                                    <td class="">
                                    <a href="<?php echo url_for('performance/UpdateSDOEvaluation?id=' . $encrypt->encrypt($Employee->emp_number.'_'.$Employee->eval_id)) ?>">
                                                <?php
                                if ($Culture == 'en') {
                                    echo $Employee->EmployeeSubordinate->emp_display_name;
                                } else {
                                    $abc = 'emp_display_name_' . $Culture;
                                    echo $Employee->EmployeeSubordinate->$abc;
                                    if ($Employee->EmployeeSubordinate->$abc == null) {
                                        echo $Employee->EmployeeSubordinate->emp_display_name;
                                    }
                                }
                    ?>
                                    </a>
                        </td>

                          <td class="">

                                                <?php
                                if ($Culture == 'en') {
                                    echo $Employee->PerformanceEvaluation->eval_name;
                                } else {
                                    $abc = 'eval_name_' . $Culture;
                                    echo $Employee->PerformanceEvaluation->$abc;
                                    if ($Employee->PerformanceEvaluation->$abc == null) {
                                        echo $Employee->PerformanceEvaluation->eval_name;
                                    }
                                }
                    ?>

                        </td>
                        <td class="">
                      <?php
                                if ($Employee->eval_emp_status== 0) {
                                    echo "Not Strated";
                                } else if ($Employee->eval_emp_status== 1) {
                                    echo "Pending";
                                } else if ($Employee->eval_emp_status== 2) {
                                    echo "Completed";
                                }
                    ?>
                        </td>
                        <td class="">
                        </td>

                    </tr>
<?php }}} ?>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
        <script type="text/javascript">
           function getYear(id){
                $('#cmbEtype').val("");

                $.post(
                "<?php echo url_for('performance/Year') ?>", //Ajax file

                { id: id },  // create an object will all values
                function(data){
                    $('#txtYear').val(data)

                },
                "json"

            );

            }
             function getLoadYear(id){
                if(id != ""){

                $.post(
                "<?php echo url_for('performance/Year') ?>", //Ajax file

                { id: id },  // create an object will all values
                function(data){
                    $('#txtYear').val(data)

                },
                "json"

            ); }

            }



           function validateform(){

                 if($("#cmbbtype").val()==""){
                    alert("<?php echo __('Please select Evaluation') ?>");
                    return false;
                }
                if($("#cmbEtype").val()==""){
                    alert("<?php echo __('Please select Evaluation Type') ?>");
                    return false;
                }

//                if($("#searchValue").val()=="")
//                {
//
//                    alert("<?php //echo __('Please enter search value') ?>");
//                    return false;
//
//                }
//                if($("#searchMode").val()=="all"){
//                    alert("<?php //echo __('Please select the search mode') ?>");
//                    return false;
//                }


                else{
                    $("#frmSearchBox").submit();
                }

            }
            $(document).ready(function() {

                buttonSecurityCommon("buttonAdd","null","null","buttonRemove");
                //When click add button
                $("#buttonAdd").click(function() {
                    var EVID= $('#cmbbtype').val();
                    var ETID= $('#cmbEtype').val();

                    location.href = "<?php echo url_for(public_path('../../symfony/web/index.php/performance/SaveAssingEmployee')) ?>"+"?EVID="+EVID+"&ETID="+ETID;

                });

                getLoadYear($('#cmbbtype').val());
                // When Click Main Tick box
                $("#allCheck").click(function() {
                    if ($('#allCheck').attr('checked')){

                        $('.innercheckbox').attr('checked','checked');
                    }else{
                        $('.innercheckbox').removeAttr('checked');
                    }
                });

                $(".innercheckbox").click(function() {
                    if($(this).attr('checked'))
                    {

                    }else
                    {
                        $('#allCheck').removeAttr('checked');
                    }
                });


                //When click reset buton
                $("#resetBtn").click(function() {
                    location.href = "<?php echo url_for(public_path('../../symfony/web/index.php/performance/AssingEmployee')) ?>";
                });

                $("#buttonRemove").click(function() {
                    $("#mode").attr('value', 'delete');
                    if($('input[name=chkLocID[]]').is(':checked')){
                        answer = confirm("<?php echo __("Do you really want to Delete?") ?>");
                    }


                    else{
                        alert("<?php echo __("select at least one check box to delete") ?>");

            }

            if (answer !=0)
            {

                $("#standardView").submit();

            }
            else{
                return false;
            }

        });

        //When click Save Button
        $("#buttonRemove").click(function() {
            $("#mode").attr('value', 'save');
        });



    });


</script>
