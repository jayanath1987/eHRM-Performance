<?php
if ($lockMode == '1') {
    $editMode = false;
    $disabled = '';
} else {
    $editMode = true;
    $disabled = 'disabled="disabled"';
}
        $encrypt = new EncryptionHandler();

        if($SDOEvaluation->eval_emp_status==2){
             $editMode = true;
             $disabled = 'disabled="disabled"';

        }
?>
<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery.validate.js') ?>"></script>
<script type="text/javascript" src="<?php echo public_path('../../scripts/browersidentifier.js') ?>"></script>
<script type="text/javascript"language="javascript">
           var items=new Array();
           function getRatedetails(id,row){
            $.ajax({
                type: "POST",
                async:false,
                url: "<?php echo url_for('performance/AjaxRateDetails') ?>",
                data: { id: id },
                dataType: "json",
                success: function(data){
                    $('#cmbRate_'+row).empty();
                     $('#cmbRate_'+row).append("<option value=''><?php echo __('--Select--') ?></option>");
                     $('#cmbRate_'+row).append(data);

                }
            });
            
    }
               function getProjectWeightComment(id,row){
            $.ajax({
                type: "POST",
                async:true,
                url: "<?php echo url_for('performance/AjaxProjectWeightComment') ?>",
                data: { id: id, Empno: "<?php echo $SDOEvaluation->emp_number; ?>", EvalId: "<?php echo $SDOEvaluation->eval_dtl_id; ?>" },
                dataType: "json",
                success: function(data){
                    if(data.Weight!=null){
                    $('#txtPrjweitage_'+row).val(data.Weight);
                      }
                    if(data.Comment!=null){
                    $('#txtPrjcomment_'+row).val(data.Comment);
                    }

                }
            });

    }

         function getDutyRateComment(id,row){
            $.ajax({
                type: "POST",
                async:true,
                url: "<?php echo url_for('performance/AjaxDutyRateComment') ?>",
                data: { id: id, Empno: "<?php echo $SDOEvaluation->emp_number; ?>", EvalId: "<?php echo $SDOEvaluation->eval_dtl_id; ?>" },
                dataType: "json",
                success: function(data){
                    if(data.Rate!=null){
                    $("'#cmbRate_"+row+"' option[value="+data.Rate+"]").attr('selected','selected');
                    }
                    if(data.Comment!=null){
                    $('#txtDutycomment_'+row).val(data.Comment);
                    }

                }
            });

    }

         function getSDOProjectRateComment(empno,row){
            $.ajax({
                type: "POST",
                async:true,
                url: "<?php echo url_for('performance/AjaxSDOProjectRateComment') ?>",
                data: { empno: empno, EvalId: "<?php echo $SDOEvaluation->eval_id; ?>" },
                dataType: "json",
                success: function(data){
                    if(data.Rate!=null){
                    $('#lblSDOPrj_'+row).empty();
                    $('#lblSDOPrj_'+row).append(data.Rate);
                    $('#txtSDOPrj_'+row).val(data.Rate);
                    }
                    if(data.SuggestedRate!=null){
                    $('#txtSDOSugestRate_'+row).val(data.SuggestedRate);
                    }
                    if(data.Comment!=null){
                    $('#txtSDOComment_'+row).val(data.Comment);
                    }
                    if(data.Status!=2){
                    $('#lblSDOPrj_'+row).empty();
                    $('#lblSDOPrj_'+row).append("Pending");
                    $('#txtSDOPrj_'+row).val("Pending");
                    }

                }
            });

    }
   </script>
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
        <div class="mainHeading"><h2><?php 

                            if ($myCulture == 'en') {
                                $abcd = "eval_type_name";
                            } else {
                                $abcd = "eval_type_name_" . $myCulture;
                            }
                            if ($SDOEvaluation->PerformanceEvaluationType->$abcd == "") {
                                echo $SDOEvaluation->PerformanceEvaluationType->eval_type_name;
                            } else {
                                echo $SDOEvaluation->PerformanceEvaluationType->$abcd;
                            }




 ?></h2></div>
             <?php echo message() ?>
            <?php echo $form['_csrf_token']; ?>
                <form name="frmSave" id="frmSave" method="post"  action="">



            <br class="clear"/>

                <div id="HeadGrid" class="centerCol" style="margin-left:10px; margin-top: 8px; width: 700px; border-style:  solid; border-color: #FAD163; ">
                    <div style="">
                        <div class="centerCol" style='width:100px; background-color:#FAD163;'>
                            <label class="languageBar" style="width:100px;padding-left:2px; padding-top:2px;padding-bottom: 1px; background-color:#FAD163; margin-top: 0px;  color:#444444;"><?php echo __("Employee ID") ?></label>
                        </div>
                        <div class="centerCol" style='width:200px;  background-color:#FAD163;'>
                            <label class="languageBar" style="width:200px; padding-left:2px; padding-top:2px;padding-bottom: 1px; background-color:#FAD163; margin-top: 0px; color:#444444; text-align:inherit"><?php echo __("Employee Name") ?></label>
                        </div>
                        <div class="centerCol" style='width:150px;   background-color:#FAD163;'>
                            <label class="languageBar" style="width:150px; padding-left: 0px; padding-top:2px;padding-bottom: 1px; background-color:#FAD163; margin-top: 0px; color:#444444; text-align:inherit"><?php echo __("Designation") ?></label>
                        </div>
                        <div class="centerCol" style='width:150px;   background-color:#FAD163;'>
                            <label class="languageBar" style="width:150px; padding-left: 0px; padding-top:2px;padding-bottom: 1px; background-color:#FAD163; margin-top: 0px; color:#444444; text-align:inherit"><?php echo __("Evaluation") ?></label>
                        </div>
                        <div class="centerCol" style='width:100px;   background-color:#FAD163;'>
                            <label class="languageBar" style="width:100px; padding-left: 0px; padding-top:2px;padding-bottom: 1px; background-color:#FAD163; margin-top: 0px; color:#444444; text-align:inherit"><?php echo __("Year") ?></label>
                        </div>

                    </div>
                </div>
                <br class="clear"/>

                <div id="HeadBody" class="centerCol" style="margin-left:14px; margin-top: 8px; width: 700px; ">
                    <div style="">
                        <div class="centerCol" style='width:100px; '>
                            <label class="languageBar" style="width:100px;padding-left:2px; padding-top:2px;padding-bottom: 1px; margin-top: 0px;  color:#444444;"><?php echo $SDOEvaluation->EmployeeSubordinate->employeeId; ?></label>
                        </div>
                        <div class="centerCol" style='width:200px; '>
                            <label class="languageBar" style="width:200px; padding-left:2px; padding-top:2px;padding-bottom: 1px;  margin-top: 0px; color:#444444; text-align:inherit"><?php if ($myCulture == 'en') {
                                $abcd = "emp_display_name";
                            } else {
                                $abcd = "emp_display_name_" . $myCulture;
                            }
                            if ($SDOEvaluation->EmployeeSubordinate->$abcd == "") {
                                echo $SDOEvaluation->EmployeeSubordinate->emp_display_name;
                            } else {
                                echo $SDOEvaluation->EmployeeSubordinate->$abcd;
                            }
 ?></label>
                        </div>
                        <div class="centerCol" style='width:150px;  '>
                            <label class="languageBar" style="width:150px; padding-left: 0px; padding-top:2px;padding-bottom: 1px;  margin-top: 0px; color:#444444; text-align:inherit"><?php if ($myCulture == 'en') {
                                $abcd = "name";
                            } else {
                                $abcd = "name_" . $myCulture;
                            }
                            if ($SDOEvaluation->EmployeeSubordinate->jobTitle->$abcd == "") {
                                echo $SDOEvaluation->EmployeeSubordinate->jobTitle->name;
                            } else {
                                echo $SDOEvaluation->EmployeeSubordinate->jobTitle->$abcd;
                            }  ?></label>
                        </div>
                        <div class="centerCol" style='width:150px;  '>
                            <label class="languageBar" style="width:150px; padding-left: 0px; padding-top:2px;padding-bottom: 1px;  margin-top: 0px; color:#444444; text-align:inherit"><?php
                            if ($myCulture == 'en') {
                                $abcd = "eval_name";
                            } else {
                                $abcd = "eval_name_" . $myCulture;
                            }
                            if ($SDOEvaluation->PerformanceEvaluation->$abcd == "") {
                                echo $SDOEvaluation->PerformanceEvaluation->eval_name;
                            } else {
                                echo $SDOEvaluation->PerformanceEvaluation->$abcd;
                            }

                            ?></label>
                        </div>
                        <div class="centerCol" style='width:100px;  '>
                            <label class="languageBar" style="width:100px; padding-left: 0px; padding-top:2px;padding-bottom: 1px;  margin-top: 0px; color:#444444; text-align:inherit"><?php echo $SDOEvaluation->PerformanceEvaluation->eval_year ; ?></label>
                        </div>

                    </div>
                </div>
<!-- SDO Project Evaluation-->
                <br class="clear"/>
                 <div class="formbuttons" id="SDOProjectEvaluation">
                <div class="leftCol" >
                    <label style="font-weight: bold"><?php echo __("SDO Project Evaluation") ; ?></label>
                        </div>
                     <br class="clear"/>
                     <div class="leftCol">
                         &nbsp;
                     </div>
                  <div id="SDOProjectGrid" class="centerCol" style="margin-left:10px; margin-top: 8px; width: 500px; border-style:  solid; border-color: #FAD163; background-color:#FAD163;">
                    <div >
                        <div class="centerCol" style='width:200px; background-color:#FAD163;'>
                            <label class="languageBar" style="width:200px;padding-left:2px; padding-top:2px;padding-bottom: 1px; background-color:#FAD163; margin-top: 0px;  color:#444444;"><?php echo __("Employee Name") ?></label>
                        </div>
                        <div class="centerCol" style='width:100px;  background-color:#FAD163;'>
                            <label class="languageBar" style="width:100px; padding-left:2px; padding-top:2px;padding-bottom: 1px; background-color:#FAD163; margin-top: 0px; color:#444444; text-align:inherit"><?php echo __("Rating") ?></label>
                        </div>
                        <div class="centerCol" style='width:100px;   background-color:#FAD163;'>
                            <label class="languageBar" style="width:90px; padding-left: 0px; padding-top:2px;padding-bottom: 1px; background-color:#FAD163; margin-top: 0px; color:#444444; text-align:inherit"><?php echo __("Suggested Rating") ?></label>
                        </div>
                        <div class="centerCol" style='width:100px;   background-color:#FAD163;'>
                            <label class="languageBar" style="width:100px; padding-left: 0px; padding-top:2px;padding-bottom: 1px; background-color:#FAD163; margin-top: 0px; color:#444444; text-align:inherit"><?php echo __("Comment") ?></label>
                        </div>

                    </div>
                </div>
                     <?php if($SDOEMPList!=null){    $h=0;
                     foreach($SDOEMPList as $SDOEMP){ ?>
                   
                    <div class="leftCol">
                         &nbsp;
                     </div>
                  <div id="ProjectGrid" class="centerCol" style="margin-left:10px; width: 500px;">
                    <div style="">
                        <div class="centerCol" style='width:200px;'>
                            <label class="" style="width:200px;padding-left:5px; padding-top:2px;padding-bottom: 1px; margin-top: 0px;  color:#444444;"><?php
                             if ($myCulture == 'en') {
                                $abcd = "emp_display_name";
                            } else {
                                $abcd = "emp_display_name_" . $myCulture;
                            }
                            if ($SDOEMP->EmployeeSubordinate->$abcd == "") {
                                echo $SDOEMP->EmployeeSubordinate->emp_display_name;
                            } else {
                                echo $SDOEMP->EmployeeSubordinate->$abcd;
                            }
                            ?></label>
                        </div>
                        <div class="centerCol" style='width:100px;'>
                            <label id="lblSDOPrj_<?php echo $h;?>" class="" style="width:100px; padding-left:5px; padding-top:2px;padding-bottom: 1px;  margin-top: 0px; color:#444444; text-align:inherit"></label>
                                <input type="hidden" id="txtSDOPrj_<?php echo $h;?>" name="txtSDOPrj_<?php echo $h; ?>"  />
                                <input type="hidden" id="txtSDOPrjEmp_<?php echo $h;?>" name="txtSDOPrjEmp_<?php echo $h; ?>"  value="<?php echo $SDOEMP->emp_number; ?>" />

                        </div>

                        <div class="centerCol" style='width:100px; '>
                            <input type="text" id="txtSDOSugestRate_<?php echo $h; ?>" name="txtSDOSugestRate_<?php echo $h; ?>" style="width:75px; padding-left: 5px; padding-top:2px;padding-bottom: 1px;  margin-top: 0px; color:#444444; text-align:inherit; border-left: 0 none;border-right: 0 none;border-top: 0 none;" maxlength="6"  onblur='return validationWeight(event,this.id)' />
                        </div>
                        <div class="centerCol" style='width:100px; '>
                            <input type="text" id="txtSDOComment_<?php echo $h; ?>" name="txtSDOComment_<?php echo $h; ?>" style="width:90px; padding-left: 5px; padding-top:2px;padding-bottom: 1px;  margin-top: 0px; color:#444444; text-align:inherit; border-left: 0 none; border-right: 0 none;border-top: 0 none;" maxlength="200" onkeypress='return onkeyUpevent(event)'  />
                        </div>
                            <script type="text/javascript"  language="javascript">
                            getSDOProjectRateComment("<?php echo $SDOEMP->emp_number; ?>","<?php echo $h; ?>");
                            </script>
                    </div>
                     
                </div>

                <?php  $h++; } } ?>
                 <br class="clear"/>
                 <br class="clear"/>

                 <input type="button" class="backbutton" id="btnSDOPrjCal"
                   value="<?php echo __("Calculate") ?>" tabindex="18"  onclick="SDOProjectEvaluationTot();"/>
                 <div class="leftCol">
                     &nbsp;
                 </div>
             <div class="centerCol">
                <label for="txtLocationCode"><?php echo __("Project Evaluation Rating") ?></label>
            </div>
            <div class="centerCol">
                <input id="txtSDOProjectEvaluationRating"  name="txtSDOProjectEvaluationRating" type="text"  class="formInputText" value="<?php echo $SDOEvaluation->eval_emp_project_rate; ?>" maxlength="6" style="width: 100px; color: #444444 " readonly="readonly" />
            </div>

                 <br class="clear"/>
                 </div>

                
<!--Project Evaluation-->
                <br class="clear"/>
                 <div class="formbuttons" id="ProjectEvaluation">
                <div class="leftCol" >
                    <label style="font-weight: bold"><?php echo __("Project Evaluation") ; ?></label>
                        </div>
                     <br class="clear"/>
                     <div class="leftCol">
                         &nbsp;
                     </div>
                  <div id="ProjectGrid" class="centerCol" style="margin-left:10px; margin-top: 8px; width: 500px; border-style:  solid; border-color: #FAD163; ">
                    <div style="">
                        <div class="centerCol" style='width:200px; background-color:#FAD163;'>
                            <label class="languageBar" style="width:200px;padding-left:2px; padding-top:2px;padding-bottom: 1px; background-color:#FAD163; margin-top: 0px;  color:#444444;"><?php echo __("Project") ?></label>
                        </div>
                        <div class="centerCol" style='width:100px;  background-color:#FAD163;'>
                            <label class="languageBar" style="width:100px; padding-left:2px; padding-top:2px;padding-bottom: 1px; background-color:#FAD163; margin-top: 0px; color:#444444; text-align:inherit"><?php echo __("Completed") ?></label>
                        </div>
                        <div class="centerCol" style='width:100px;   background-color:#FAD163;'>
                            <label class="languageBar" style="width:100px; padding-left: 0px; padding-top:2px;padding-bottom: 1px; background-color:#FAD163; margin-top: 0px; color:#444444; text-align:inherit"><?php echo __("weightage") ?></label>
                        </div>
                        <div class="centerCol" style='width:100px;   background-color:#FAD163;'>
                            <label class="languageBar" style="width:100px; padding-left: 0px; padding-top:2px;padding-bottom: 1px; background-color:#FAD163; margin-top: 0px; color:#444444; text-align:inherit"><?php echo __("Comment") ?></label>
                        </div>

                    </div>
                </div>
                     <?php  if($ProjectList!=null){   $i=0;
                     foreach($ProjectList as $Project ){ ?>

                    <div class="leftCol">
                         &nbsp;
                     </div>
                  <div id="ProjectGrid" class="centerCol" style="margin-left:10px; width: 500px;">
                    <div style="">
                        <div class="centerCol" style='width:200px;'>
                            <label id="lblSDOName_<?php echo $i; ?>" class="" style="width:200px;padding-left:5px; padding-top:2px;padding-bottom: 1px; margin-top: 0px;  color:#444444;"><?php
                             if ($myCulture == 'en') {
                                $abcd = "eval_prj_name";
                            } else {
                                $abcd = "eval_prj_name_" . $myCulture;
                            }
                            if ($Project->PerformanceEvaluationProject->$abcd == "") {
                                echo $Project->PerformanceEvaluationProject->eval_prj_name;
                            } else {
                                echo $Project->PerformanceEvaluationProject->$abcd;
                            }
                            ?></label>
                        </div>
                        <div class="centerCol" style='width:100px;'>
                            <label class="" style="width:100px; padding-left:5px; padding-top:2px;padding-bottom: 1px;  margin-top: 0px; color:#444444; text-align:inherit"><?php
                            echo $Project->PerformanceEvaluationProject->eval_prj_completed."%";
                            ?></label>
                            <input type="hidden" id="txtPrjId_<?php echo $i;?>" name="txtPrjId_<?php echo $i; ?>" value="<?php echo $Project->PerformanceEvaluationProject->eval_prj_id; ?>" />
                            <input type="hidden" id="txtPrjPers_<?php echo $i;?>" name="txtPrjPers_<?php echo $i; ?>" value="<?php echo $Project->PerformanceEvaluationProject->eval_prj_completed; ?>" />
                        </div>

                        <div class="centerCol" style='width:100px; '>
                            <input type="text" id="txtPrjweitage_<?php echo $i; ?>" name="txtPrjweitage_<?php echo $i; ?>" style="width:75px; padding-left: 5px; padding-top:2px;padding-bottom: 1px;  margin-top: 0px; color:#444444; text-align:inherit; border-left: 0 none;border-right: 0 none;border-top: 0 none;" maxlength="6"  onblur='return validationWeight(event,this.id)' />
                        </div>
                        <div class="centerCol" style='width:100px; '>
                            <input type="text" id="txtPrjcomment_<?php echo $i; ?>" name="txtPrjcomment_<?php echo $i; ?>" style="width:90px; padding-left: 5px; padding-top:2px;padding-bottom: 1px;  margin-top: 0px; color:#444444; text-align:inherit; border-left: 0 none; border-right: 0 none;border-top: 0 none;" maxlength="200" onkeypress='return onkeyUpevent(event)'  />
                        </div>
                            <script type="text/javascript"  language="javascript">
                            getProjectWeightComment("<?php echo $Project->PerformanceEvaluationProject->eval_prj_id; ?>","<?php echo $i; ?>");
                            </script>
                    </div>

                </div>

                <?php  $i++; } }?>
                 <br class="clear"/>
                 <br class="clear"/>

                 <input type="button" class="backbutton" id="btnPrjCal"
                   value="<?php echo __("Calculate") ?>" tabindex="18"  onclick="ProjectEvaluationTot();"/>
                 <div class="leftCol">
                     &nbsp;
                 </div>
             <div class="centerCol">
                <label for="txtLocationCode"><?php echo __("Project Evaluation Rating") ?></label>
            </div>
            <div class="centerCol">
                <input id="txtProjectEvaluationRating"  name="txtProjectEvaluationRating" type="text"  class="formInputText" value="<?php echo $SDOEvaluation->eval_emp_project_rate; ?>" maxlength="6" style="width: 100px; color: #444444 " readonly="readonly" />
            </div>

                 <br class="clear"/>
                 </div>


<!--Duty Evaluation-->


                <div class="formbuttons" id="DutyEvaluation">
                <div class="leftCol" >
                            <label style="font-weight: bold"><?php echo __("Duty Evaluation") ; ?></label>
                        </div>
                     <br class="clear"/>
                                      <div class="leftCol">
                         &nbsp;
                     </div>
                  <div id="ProjectGrid" class="centerCol" style="margin-left:10px; margin-top: 8px; width: 500px; border-style:  solid; border-color: #FAD163; ">
                    <div style="">
                        <div class="centerCol" style='width:150px; background-color:#FAD163;'>
                            <label class="languageBar" style="width:150px;padding-left:2px; padding-top:2px;padding-bottom: 1px; background-color:#FAD163; margin-top: 0px;  color:#444444;"><?php echo __("Duty Group") ?></label>
                        </div>
                        <div class="centerCol" style='width:150px;  background-color:#FAD163;'>
                            <label class="languageBar" style="width:150px; padding-left:2px; padding-top:2px;padding-bottom: 1px; background-color:#FAD163; margin-top: 0px; color:#444444; text-align:inherit"><?php echo __("Duty") ?></label>
                        </div>
                        <div class="centerCol" style='width:100px;   background-color:#FAD163;'>
                            <label class="languageBar" style="width:100px; padding-left: 0px; padding-top:2px;padding-bottom: 1px; background-color:#FAD163; margin-top: 0px; color:#444444; text-align:inherit"><?php echo __("Rating") ?></label>
                        </div>
                        <div class="centerCol" style='width:100px;   background-color:#FAD163;'>
                            <label class="languageBar" style="width:100px; padding-left: 0px; padding-top:2px;padding-bottom: 1px; background-color:#FAD163; margin-top: 0px; color:#444444; text-align:inherit"><?php echo __("Comment") ?></label>
                        </div>

                    </div>
                </div>
                     <?php     $j=0;
                     foreach($DutyList as $Duty ){ ?>

                    <div class="leftCol">
                         &nbsp;
                     </div>
                  <div id="ProjectGrid" class="centerCol" style="margin-left:10px; width: 500px;">
                    <div style="">
                        <div class="centerCol" style='width:150px;'>
                            <label class="" style="width:150px;padding-left:5px; padding-top:2px;padding-bottom: 1px; margin-top: 0px;  color:#444444;"><?php
                             if ($myCulture == 'en') {
                                $abcd = "dtg_name";
                            } else {
                                $abcd = "dtg_name_" . $myCulture;
                            }
                            if ($Duty->PerformanceDuty->PerformanceDutyGroup->$abcd == "") {
                                echo $Duty->PerformanceDuty->PerformanceDutyGroup->dtg_name;
                            } else {
                                echo $Duty->PerformanceDuty->PerformanceDutyGroup->$abcd;
                            }
                            ?></label>
                        </div>
                        <div class="centerCol" style='width:150px;'>
                            <label class="" style="width:150px; padding-left:5px; padding-top:2px;padding-bottom: 1px;  margin-top: 0px; color:#444444; text-align:inherit"><?php
                             if ($myCulture == 'en') {
                                $abcd = "dut_name";
                            } else {
                                $abcd = "dut_name_" . $myCulture;
                            }
                            if ($Duty->PerformanceDuty->$abcd == "") {
                                echo $Duty->PerformanceDuty->dut_name;
                            } else {
                                echo $Duty->PerformanceDuty->$abcd;
                            }
                            ?></label>
                            <input type="hidden" id="txtDuty_<?php echo $j;?>" name="txtDuty_<?php echo $j; ?>" value="<?php echo $Duty->dut_id; ?>" />
                            <input type="hidden" id="txtDutyRate_<?php echo $j;?>" name="txtDutyRate_<?php echo $j; ?>" value="<?php echo $Duty->dut_weightage; ?>" />
                        </div>
                        <div class="centerCol" style='width:100px; '>
<!--                            <script type="text/javascript"  language="javascript">
                                if(BrowserDetect.browser=="Firefox"){
                                     getRatedetails("<?php echo $Duty->PerformanceDuty->PerformanceRate->rate_id; ?>","<?php echo $j; ?>");
                                }
                           </script>-->
                            <select name="cmbRate_<?php echo $j; ?>" id="cmbRate_<?php echo $j; ?>" style="width:75px; padding-left: 5px; padding-top:2px;padding-bottom: 1px;  margin-top: 0px;"  >
                                <option value=""><?php echo __("--Select--") ?></option>
                            <script type="text/javascript"  language="javascript">
                                //if(BrowserDetect.browser!="Firefox"){
                            getRatedetails("<?php echo $Duty->PerformanceDuty->PerformanceRate->rate_id; ?>","<?php echo $j; ?>");
                            //}
                            </script>
                            </select>


                        </div>
                        <div class="centerCol" style='width:100px; '>
                            <input type="text" id="txtDutycomment_<?php echo $j; ?>" name="txtDutycomment_<?php echo $j; ?>" style="width:90px; padding-left: 5px; padding-top:2px;padding-bottom: 1px;  margin-top: 0px; color:#444444; text-align:inherit; border-left: 0 none; border-right: 0 none;border-top: 0 none;" maxlength="200" onkeypress='return onkeyUpevent(event)'  />
                        </div>
                            <script type="text/javascript"  language="javascript">
                            getDutyRateComment("<?php echo $Duty->dut_id; ?>","<?php echo $j; ?>");
                            </script>
                    </div>

                </div>

                <?php  $j++; } ?>
                 <br class="clear"/>
                 <br class="clear"/>

                 <input type="button" class="backbutton" id="btnPrjCal"
                   value="<?php echo __("Calculate") ?>" tabindex="18"  onclick="DutyEvaluationTot();"/>
                 <div class="leftCol">
                     &nbsp;
                 </div>
             <div class="centerCol">
                <label for="txtLocationCode"><?php echo __("Duty Evaluation Rating") ?></label>
            </div>
            <div class="centerCol">
                <input id="txtDutyEvaluationRating" value="<?php echo $SDOEvaluation->eval_emp_duty_rate; ?>"  name="txtDutyEvaluationRating" type="text"  class="formInputText" value="" maxlength="6" style="width: 100px; color: #444444 " readonly="readonly" />
                <input id="txtProjectType" value="<?php echo $SDOEvaluation->eval_type_id; ?>"  name="txtProjectType" type="hidden"  class="formInputText" value="" maxlength="6" style="width: 100px; color: #444444 " />
            </div>

                 <br class="clear"/>
                 <br class="clear"/>
<div class="leftCol">
                <label for="txtLocationCode"><?php echo __("Comment") ?></label>
            </div>
            <div class="centerCol">
                <textarea id="txtComment"  name="txtComment"  class="formTextArea" rows="3" cols="5" tabindex="1" style="width: 500px;"><?php echo $SDOEvaluation->eval_emp_duty_comment; ?></textarea>
            </div>
                 <br class="clear"/>
                 <div class="leftCol">&nbsp;</div><div class="centerCol">&nbsp;</div>
            <input type="button" class="backbutton" id="btnOverallPerf"
                   value="<?php echo __("Calculate Overall Performance") ?>" tabindex="18"  onclick="FinalEvaluationTot();"/>

                 </div>
                <div class="formbuttons" id="OverallEvaluation">
            <div class="leftCol">
                <label for="txtLocationCode"><?php echo __("Overall Performance Rating ") ?></label>
            </div>
                    <div class="centerCol" style="width: 150px;" >
                        <label id="lblFinalRate" for="txtLocationCode" style="width: 150px;"><?php echo $SDOEvaluation->eval_emp_overall_rate; ?></label>
                        <input id="txtFinalRate"  name="txtFinalRate" type="hidden" value="<?php echo $SDOEvaluation->eval_emp_overall_rate; ?>" />

            </div>
                    <label for="txtLocationCode" style="width: 50px;"><?php echo __("Grade -") ?></label>
                    <label for="txtLocationCode" id="lblFinalGrade" style="width: 50px;"><?php echo $SDOEvaluation->eval_emp_overall_grade; ?></label>
                    <input id="txtFinalGrade"  name="txtFinalGrade" type="hidden" value="<?php echo $SDOEvaluation->eval_emp_overall_grade; ?>"  />
                    <label for="txtLocationCode" style="width: 75px;"><?php echo __("Description -") ?></label>
                    <label for="txtLocationCode" id="lblFinalDesc" style="width: 150px;"></label>
                    <br class="clear">
                    <div class="leftCol">
                <label for="txtLocationCode"><?php echo __("Overall Comment") ?></label>
            </div>
            <div class="centerCol">
                <textarea id="txtOverallComment"  name="txtOverallComment"  class="formTextArea" rows="3" cols="5" tabindex="1" style="width: 500px;"><?php echo $SDOEvaluation->eval_emp_overall_comment; ?></textarea>
            </div>
                 <br class="clear"/>
                </div>
                <input id="txtStatus"  name="txtStatus" type="hidden"  value="1" />

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
            <input type="button" class="backbutton" id="btnSubmit"
                   value="<?php echo __("Submit") ?>" tabindex="20"  onclick="submitstaus();"/>
        </div>
        </form>

    </div>
    <div class="requirednotice"><?php echo __("Fields marked with an asterisk") ?><span class="required"> * </span> <?php echo __("are required") ?></div>
    <br class="clear" />
</div>

<script type="text/javascript">
var config=0;
function submitstaus(){
   $('#txtStatus').val("2");
   $("#editBtn").click();
}

function SDOProjectEvaluationTot(){
    var k="<?php echo $h;?>";
if(k==0){
alert("<?php echo __("Employee not assigned any SDO project")?>");
config++;
return false;
}
var weitagetot= 0;
var calweitagetot=0;
var projectrate=0;
for(var l=0; l< k; l++){
           if($("#txtSDOPrj_"+l).val()=="" || $("#txtSDOPrj_"+l).val()=="Pending"){
                 alert("<?php echo __("Subordinates evaluation not completed. Can not continue.")?>");
                 $("#editBtn").hide();
                 $("#btnSubmit").hide();
                 config++;
                 return false;
            }
            //if($("#txtSDOPrj_"+l).val()!="" || $("#txtSDOPrj_"+l).val()!="Pending"){
            weitagetot+=parseFloat($("#txtSDOSugestRate_"+l).val());
            calweitagetot+=parseFloat($("#txtSDOPrj_"+l).val())*parseFloat($("#txtSDOSugestRate_"+l).val());
            //}
      }
      if(weitagetot != 100){
                 alert("<?php echo __("Projects suggested rate should be equal to 100")?>");
                 return false;
       }
       projectrate= (parseFloat(calweitagetot/100)).toFixed(2);
       $("#txtSDOProjectEvaluationRating").val(projectrate);
       
}

function FinalEvaluationTot(){
     var Evaltype="<?php echo $SDOEvaluation->eval_type_id;?>";
     var EvalDtlID="<?php echo $EvaluationDtlID->eval_dtl_id; ?>";
     var DutyEval=0;
     var ProjectEval=0;
     if(Evaltype==3){
         if($('#txtDutyEvaluationRating').val()==""){
            alert("<?php echo __('Please calculate duty evaluation.') ?>");
            return false;
         }else{
            DutyEval=$('#txtDutyEvaluationRating').val();
         }
         
     }else if(Evaltype==1){
         if($('#txtProjectEvaluationRating').val()==""){
             alert("<?php echo __('Please calculate project evaluation.') ?>");
            return false;
         }else{
            ProjectEval=$('#txtProjectEvaluationRating').val();
         }

         if($('#txtDutyEvaluationRating').val()==""){
            alert("<?php echo __('Please calculate duty evaluation.') ?>");
            return false;
         }else{
           DutyEval=$('#txtDutyEvaluationRating').val();
         }

}else if(Evaltype==2){
         if($('#txtSDOProjectEvaluationRating').val()==""){
             alert("<?php echo __('Please calculate SDO project evaluation.') ?>");
            return false;
         }else{
            ProjectEval=$('#txtSDOProjectEvaluationRating').val();
         }

         if($('#txtDutyEvaluationRating').val()==""){
            alert("<?php echo __('Please calculate duty evaluation.') ?>");
            return false;
         }else{
           DutyEval=$('#txtDutyEvaluationRating').val();
         }
}
        

         $('#lblFinalRate').empty();
         $('#txtFinalRate').empty();
         $('#lblFinalGrade').empty();
         $('#txtFinalGrade').empty();
         $('#lblFinalDesc').empty();
                $.ajax({
                type: "POST",
                async:false,
                url: "<?php echo url_for('performance/AjaxFinalEvaluationCalculation') ?>",
                data: { EvalDtlID: EvalDtlID, ProjectEval: ProjectEval, DutyEval: DutyEval,Evaltype: Evaltype },
                dataType: "json",
                success: function(data){
                     $('#lblFinalRate').append(data.FinalRate);
                     $('#txtFinalRate').val(data.FinalRate);
                     $('#lblFinalGrade').append(data.FinalGrade);
                     $('#txtFinalGrade').val(data.FinalGrade);
                     $('#lblFinalDesc').append(data.FinalDesc);

                }
            });
            
 }

 function validationWeight(e,id){

            if(isNaN($('#'+id).val())){
                alert("<?php echo __('Please enter digits') ?>");
                $('#'+id).val("");
                return false;
            }
            if($('#'+id).val()>100){
                $('#'+id).val("");
                $('#'+id).val("100.00");
            }
            if($('#'+id).val()< 0){
                $('#'+id).val("");
                $('#'+id).val("0.00");
            }
        }

function onkeyUpevent(e){
                             

                                 var keynum;
                                 var keychar;
                                 var numcheck;


                                 if(window.event) // IE
                                 {
                                     keynum = e.keyCode;
                                 }
                                 else if(e.which) // Netscape/Firefox/Opera
                                 {
                                     keynum = e.which;
                                 }
                                 keychar = String.fromCharCode(keynum);
                                 numcheck = /^[^@\*\!#\$%\^&()~`\+=]+$/i;

                                 if(!numcheck.test(keychar)){
                                  alert("<?php echo __('No invalid characters are allowed')?>");
                                  return false;
                                 }
                             }

function DutyEvaluationTot(){

var i="<?php echo $j;?>";
if(i==0){
alert("<?php echo __("Employee not assigned any duty")?>");
config++;
return false;
}
var weitagetot= 0;
var calweitagetot=0;
var projectrate=0;
for(var j=0; j< i; j++){
           if($("#cmbRate_"+j).val()==""){
                 alert("<?php echo __("Duty rates can not be blank")?>");
                 return false;
            }
            //if($("#cmbRate_"+j).val()!=""){
            weitagetot+=parseFloat($("#cmbRate_"+j).val());
            calweitagetot+=parseFloat($("#txtDutyRate_"+j).val())*parseFloat($("#cmbRate_"+j).val());
            //}
      }

       projectrate= (parseFloat(calweitagetot/100)).toFixed(2);
       $("#txtDutyEvaluationRating").val(projectrate);

}


function ProjectEvaluationTot(){

var i="<?php echo $i;?>";
if(i==0){
alert("<?php echo __("Project(s) have not been assigned for selected employee")?>");
config++;
return false;
}
var weitagetot= 0;
var calweitagetot=0;
var projectrate=0;
for(var j=0; j< i; j++){
           if($("#txtPrjweitage_"+j).val()==""){
                 alert("<?php echo __("Projects weightage can not be blank")?>");
                 return false;
            }
            //if($("#txtPrjweitage_"+j).val()!=""){
            weitagetot+=parseFloat($("#txtPrjweitage_"+j).val());
            calweitagetot+=parseFloat($("#txtPrjweitage_"+j).val())*parseFloat($("#txtPrjPers_"+j).val());
            //}
      }
      if(weitagetot != 100){
                 alert("<?php echo __("Projects weightage should be equal to 100")?>");
                 return false;
       }
       projectrate= (parseFloat(calweitagetot/100)).toFixed(2);
       $("#txtProjectEvaluationRating").val(projectrate);
       
}


    $(document).ready(function() { 
        var Evaltype="<?php echo $SDOEvaluation->eval_type_id;?>";
        if(Evaltype==3){
            $('#ProjectEvaluation').hide();
            $('#SDOProjectEvaluation').hide();
        }else if(Evaltype==2){
            $('#ProjectEvaluation').hide();
            $('#SDOProjectEvaluation').show();           
        }else if(Evaltype==1){
            $('#ProjectEvaluation').show();
            $('#SDOProjectEvaluation').hide();
        }
if($('#txtFinalGrade').val()!=""){        
FinalEvaluationTot();
}
        buttonSecurityCommon("null","null","editBtn","null");
<?php if ($editMode == true) { ?>
                              $('#frmSave :input').attr('disabled', true);
                              $('#editBtn').removeAttr('disabled');
                              $('#btnBack').removeAttr('disabled');
<?php } ?>
                                                    //BrowserDetect.init();

                       //Validate the form
        $("#frmSave").validate({


        });

                       // When click edit button
                       $("#frmSave").data('edit', <?php echo $editMode ? '1' : '0' ?>);

                       $("#editBtn").click(function() {

                           var editMode = $("#frmSave").data('edit');
                           if (editMode == 1) {
                               // Set lock = 1 when requesting a table lock

            location.href="<?php echo url_for('performance/UpdateSDOEvaluation?id=' . $encrypt->encrypt($SDOEvaluation->emp_number.'_'.$SDOEvaluation->eval_id) . '&lock=1') ?>";
                           }
                           else {
//                               if(config!=0){
//                                   alert("<?php echo __('Unable to save record! \nEither duty evaluation or project evaluation has not assigned for the selected employee.') ?>");
//                                   return false;
//                               }
//
//                                    var Evaltype="<?php echo $SDOEvaluation->eval_type_id;?>";
//                                    var EvalDtlID="<?php echo $EvaluationDtlID->eval_dtl_id; ?>";
//                                    if(Evaltype==3){
//                                        if($('#txtDutyEvaluationRating').val()==""){
//                                            alert("<?php echo __('Please calculate duty evaluation.') ?>");
//                                            return false;
//                                        }
//
//                                    }else if(Evaltype==1){
//                                        if($('#txtProjectEvaluationRating').val()==""){
//                                            alert("<?php echo __('Please calculate project evaluation.') ?>");
//                                            return false;
//                                        }
//
//                                        if($('#txtDutyEvaluationRating').val()==""){
//                                            alert("<?php echo __('Please calculate duty evaluation.') ?>");
//                                            return false;
//                                        }
//
//                                    }else if(Evaltype==2){
//                                        if($('#txtSDOProjectEvaluationRating').val()==""){
//                                            alert("<?php echo __('Please calculate SDO project evaluation.') ?>");
//                                            return false;
//                                        }
//
//                                        if($('#txtDutyEvaluationRating').val()==""){
//                                            alert("<?php echo __('Please calculate duty evaluation.') ?>");
//                                            return false;
//                                        }
//                                    }
                                    //FinalEvaluationTot();

                               $('#frmSave').submit();
                               
                           }


                       });

                       //When Click back button
                       $("#btnBack").click(function() {
                           location.href = "<?php echo url_for(public_path('../../symfony/web/index.php/performance/SDOEvaluation')) ?>";
                       });

                       //When click reset buton
                       $("#btnClear").click(function() {
                           // Set lock = 0 when resetting table lock
                           location.href="<?php echo url_for('performance/UpdateSDOEvaluation?id=' . $encrypt->encrypt($SDOEvaluation->emp_number.'_'.$SDOEvaluation->eval_id) . '&lock=0') ?>";
                       });
                   });
</script>
