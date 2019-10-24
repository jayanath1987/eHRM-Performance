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
                <label for="searchMode"><?php echo __("Search By") ?></label>


                <select name="searchMode" id="searchMode">
                    <option value="all"><?php echo __("--Select--") ?></option>
                    <option value="eval_dtl_id" <?php
        if ($searchMode == "eval_dtl_id") {
            echo "selected=selected";
        }
        ?> ><?php echo __("Evaluation Code") ?></option>
                    <option value="eval_name_" <?php
                            if ($searchMode == "eval_name_") {
                                echo "selected=selected";
                            }
        ?> ><?php echo __("Evaluation") ?></option>
                    <option value="jobtit_name_" <?php
                            if ($searchMode == "jobtit_name_") {
                                echo "selected=selected";
                            }
        ?> ><?php echo __("JobTitle") ?></option>
                    <option value="level_name_" <?php
                            if ($searchMode == "level_name_") {
                                echo "selected=selected";
                            }
        ?> ><?php echo __("Level") ?></option>
                    /option>
                    <option value="service_name_" <?php
                            if ($searchMode == "service_name_") {
                                echo "selected=selected";
                            }
        ?> ><?php echo __("Service") ?></option>
                </select>

                <label for="searchValue"><?php echo __("Search For") ?></label>
                <input type="text" size="20" name="searchValue" id="searchValue" value="<?php echo $searchValue ?>" />
                <input type="submit" class="plainbtn"
                       value="<?php echo __("Search") ?>" />
                <input type="reset" class="plainbtn"
                       value="<?php echo __("Reset") ?>" id="resetBtn"/>
                <br class="clear"/>
            </div>
        </form>
        <div class="actionbar">
            <div class="actionbuttons">

                <input type="button" class="plainbtn" id="buttonAdd"
                       value="<?php echo __("Add") ?>" />


                <input type="button" class="plainbtn" id="buttonRemove"
                       value="<?php echo __("Delete") ?>" />

            </div>
            <div class="noresultsbar"></div>
            <div class="pagingbar"><?php echo is_object($pglay) ? $pglay->display() : ''; ?> </div>
            <br class="clear" />
        </div>
        <br class="clear" />

        <form name="standardView" id="standardView" method="post" action="<?php echo url_for('performance/DeleteEvaluation') ?>">
            <input type="hidden" name="mode" id="mode" value=""/>
            <table cellpadding="0" cellspacing="0" class="data-table">
                <thead>
                    <tr>
                        <td width="50">

                            <input type="checkbox" class="checkbox" name="allCheck" value="" id="allCheck" />

                        </td>
                        <td scope="col">
                            <?php
                            if ($Culture == 'en') {
                                $ename = 'p.eval_name';
                            } else {
                                $ename = 'p.eval_name_' . $Culture;
                            }
                            ?>
                            <?php echo $sorter->sortLink($ename, __('Company Evaluation'), '@EvaluationDetails', ESC_RAW); ?>
                        </td>
                        <td scope="col">
                            <?php
                            if ($Culture == 'en') {
                                $jtname = 'j.jobtit_name';
                            } else {
                                $jtname = 'j.jobtit_name_' . $Culture;
                            }
                            ?>
                            <?php echo $sorter->sortLink($jtname, __('JobTitle'), '@EvaluationDetails', ESC_RAW); ?>
                        </td>

                        <td scope="col">
                            <?php
                            if ($Culture == 'en') {
                                $ltname = 'l.level_name';
                            } else {
                                $ltname = 'l.level_name_' . $Culture;
                            }
                            ?>
                            <?php echo $sorter->sortLink($ltname, __('Level'), '@EvaluationDetails', ESC_RAW); ?>

                        </td>
                        <td scope="col">
                            <?php
                            if ($Culture == 'en') {
                                $stname = 's.service_name';
                            } else {
                                $stname = 's.service_name_' . $Culture;
                            }
                            ?>
                            <?php echo $sorter->sortLink($stname, __('Service Name'), '@EvaluationDetails', ESC_RAW); ?>
                        </td>
                    </tr>
                </thead>

                <tbody>
                    <?php
                            $row = 0;
                            foreach ($EvaluationList as $Evaluation) {
                                $cssClass = ($row % 2) ? 'even' : 'odd';
                                $row = $row + 1;
                    ?>
                                <tr class="<?php echo $cssClass ?>">
                                    <td >
                                        <input type='checkbox' class='checkbox innercheckbox' name='chkLocID[]' id="chkLoc" value='<?php echo $Evaluation->eval_dtl_id ?>' />
                                    </td>
                               
                        <td class="">
<a href="<?php echo url_for('performance/SaveEvaluation?id=' . $Evaluation->eval_dtl_id) ?>"><?php
                                if ($Culture == 'en') {
                                    echo $Evaluation->PerformanceEvaluation->eval_name;
                                } else {
                                    $abc = 'eval_name_' . $Culture;
                                    echo $Evaluation->PerformanceEvaluation->$abc;
                                    if ($Evaluation->PerformanceEvaluation->$abc == null) {
                                        echo $Evaluation->PerformanceEvaluation->eval_name;
                                    }
                                }
?></a>
                        
                            </td>

                            <td class="">
                            <?php
                                if ($Culture == 'en') {
                                    echo $Evaluation->JobTitle->name;
                                } else {
                                    $abc = 'name_' . $Culture;
                                    echo $Evaluation->JobTitle->$abc;
                                    if ($Evaluation->JobTitle->$abc == null) {
                                        echo $Evaluation->JobTitle->name;
                                    }
                                }
                            ?>
                            </td>

                            <td class="">
                            <?php
                                if ($Culture == 'en') {
                                    echo $Evaluation->Level->level_name;
                                } else {
                                    $abc = 'level_name_' . $Culture;
                                    echo $Evaluation->Level->$abc;
                                    if ($Evaluation->Level->$abc == null) {
                                        echo $Evaluation->Level->level_name;
                                    }
                                }
                            ?>
                            </td>
                            <td class="">
                            <?php
                                if ($Culture == 'en') {
                                    echo $Evaluation->ServiceDetails->service_name;
                                } else {
                                    $abc = 'service_name_' . $Culture;
                                    echo $Evaluation->ServiceDetails->$abc;
                                    if ($Evaluation->ServiceDetails->$abc == null) {
                                        echo $Evaluation->ServiceDetails->service_name;
                                    }
                                }
                            ?>
                            </td>

                        </tr>
<?php } ?>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
        <script type="text/javascript">
            function validateform(){

                if($("#searchValue").val()=="")
                {

                    alert("<?php echo __('Please enter search value') ?>");
                    return false;

                }
                if($("#searchMode").val()=="all"){
                    alert("<?php echo __('Please select the search mode') ?>");
                    return false;
                }
                else{
                    $("#frmSearchBox").submit();
                }

            }
            $(document).ready(function() {
                buttonSecurityCommon("buttonAdd","null","null","buttonRemove");
                //When click add button
                $("#buttonAdd").click(function() {
                    location.href = "<?php echo url_for(public_path('../../symfony/web/index.php/performance/SaveEvaluation')) ?>";

                });

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
                    location.href = "<?php echo url_for(public_path('../../symfony/web/index.php/performance/Evaluation')) ?>";
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
