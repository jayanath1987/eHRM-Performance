<?php

/**
 * OrangeHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for any enterprise.
 * Copyright (C) 2006 OrangeHRM Inc., http://www.orangehrm.com
 *
 * OrangeHRM is free software; you can redistribute it and/or modify it under the terms of
 * the GNU General Public License as published by the Free Software Foundation; either
 * version 2 of the License, or (at your option) any later version.
 *
 * OrangeHRM is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
 * without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with this program;
 * if not, write to the Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor,
 * Boston, MA  02110-1301, USA
 */
/**
 * Actions class for Performance module
 *
 * -------------------------------------------------------------------------------------------------------
 *  Author    - Jayanath Liyanage,Givantha Kalansuriya
 *  On (Date) - 27 July 2011 
 *  Comments  - Employee Performance Functions 
 *  Version   - Version 1.0
 * -------------------------------------------------------------------------------------------------------
 * */
include ('../../lib/common/LocaleUtil.php');
include ('../../lib/common/Struct.php');
class performanceActions extends sfActions {

    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    //DutyGroup
    public function executeDutyGroup(sfWebRequest $request) {


        try {
            $this->Culture = $this->getUser()->getCulture();
            $performanceSearchService = new PerformanceSearchService();


            $this->sorter = new ListSorter('DutyGroup', 'performance', $this->getUser(), array('dg.dtg_id', ListSorter::ASCENDING));
            $this->sorter->setSort(array($request->getParameter('sort'), $request->getParameter('order')));

            if ($request->getParameter('mode') == 'search') {
                if (($request->getParameter('searchMode') == 'all') && (trim($request->getParameter('searchValue')) != '')) {
                    $this->setMessage('NOTICE', array('Select the field to search'));
                    $this->redirect('performance/DutyGroup');
                }
                $this->var = 1;
            }

            $this->searchMode = ($request->getParameter('searchMode') == null) ? 'all' : $request->getParameter('searchMode');
            $this->searchValue = ($request->getParameter('searchValue') == null) ? '' : $request->getParameter('searchValue');

            $this->sort = ($request->getParameter('sort') == '') ? 'dg.dtg_id' : $request->getParameter('sort');
            $this->order = ($request->getParameter('order') == '') ? 'ASC' : $request->getParameter('order');
            $res = $performanceSearchService->searchDutyGroup($this->searchMode, $this->searchValue, $this->Culture, $this->sort, $this->order, $request->getParameter('page'));
            $this->DutyGroupList = $res['data'];
            $this->pglay = $res['pglay'];
            $this->pglay->setTemplate('<a href="{%url}">{%page}</a>');
            $this->pglay->setSelectedTemplate('{%page}');
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
            $this->redirect('default/error');
        }
    }

    public function executeSaveDutyGroup(sfWebRequest $request) {
        $this->myCulture = $this->getUser()->getCulture();
       
        $performanceSaveService=new PerformanceSaveService();
        
        $DutyGroup = new PerformanceDutyGroup();
        if ($request->isMethod('post')) {


            (strlen($request->getParameter('txtDutyGroupCode')  ? $DutyGroup->setDtg_code(trim($request->getParameter('txtDutyGroupCode'))) : $DutyGroup->setDtg_code(null))); // returns true

            (strlen($request->getParameter('txtDutyGroupName')  ? $DutyGroup->setDtg_name(trim($request->getParameter('txtDutyGroupName'))) : $DutyGroup->setDtg_name(null))); // returns true

            (strlen($request->getParameter('txtDutyGroupNameSi')  ? $DutyGroup->setDtg_name_si(trim($request->getParameter('txtDutyGroupNameSi'))) : $DutyGroup->setDtg_name_si(null))); // returns true

            (strlen($request->getParameter('txtDutyGroupNameTa')  ? $DutyGroup->setDtg_name_ta(trim($request->getParameter('txtDutyGroupNameTa'))) : $DutyGroup->setDtg_name_ta(null))); // returns true

            (strlen($request->getParameter('txtDutyGroupDesc')  ? $DutyGroup->setDtg_desc(trim($request->getParameter('txtDutyGroupDesc'))) : $DutyGroup->setDtg_desc(null))); // returns true

            (strlen($request->getParameter('txtDutyGroupDescSi')  ? $DutyGroup->setDtg_desc_si(trim($request->getParameter('txtDutyGroupDescSi'))) : $DutyGroup->setDtg_desc_si(null))); // returns true

            (strlen($request->getParameter('txtDutyGroupDescTa')  ? $DutyGroup->setDtg_desc_ta(trim($request->getParameter('txtDutyGroupDescTa'))) : $DutyGroup->setDtg_desc_ta(null))); // returns true
            
      
           

            try {
                $performanceSaveService->saveDutyGroup($DutyGroup);
            } catch (Doctrine_Connection_Exception $e) {
                $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('performance/DutyGroup');
            } catch (Exception $e) {
                $errMsg = new CommonException($e->getMessage(), $e->getCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('performance/DutyGroup');
            }
            $this->setMessage('SUCCESS', array($this->getContext()->getI18N()->__("Successfully Saved", $args, 'messages')));
            $this->redirect('performance/DutyGroup');
        }
    }

    public function executeUpdateDutyGroup(sfWebRequest $request) {
        //Table Lock code is Open

        $encrypt = new EncryptionHandler();
        if (!strlen($request->getParameter('lock'))) {
            $this->lockMode = 0;
        } else {
            $this->lockMode = $request->getParameter('lock');
        }
        $PGID = $encrypt->decrypt($request->getParameter('id'));
        if (isset($this->lockMode)) {
            if ($this->lockMode == 1) {

                $conHandler = new ConcurrencyHandler();

                $recordLocked = $conHandler->setTableLock('hs_hr_perf_duty_group', array($PGID), 1);

                if ($recordLocked) {
                    // Display page in edit mode
                    $this->lockMode = 1;
                } else {
                    $this->setMessage('WARNING', array($this->getContext()->getI18N()->__('Can not update. Record locked by another user.', $args, 'messages')), false);
                    $this->lockMode = 0;
                }
            } else if ($this->lockMode == 0) {
                $conHandler = new ConcurrencyHandler();
                $recordLocked = $conHandler->resetTableLock('hs_hr_perf_duty_group', array($PGID), 1);
                $this->lockMode = 0;
            }
        }

        //Table lock code is closed
        $this->myCulture = $this->getUser()->getCulture();
        $performanceService = new PerformanceService();
            $performanceSaveService=new PerformanceSaveService();
        $DutyGroup = new PerformanceDutyGroup();

        $DutyGroup = $performanceService->readDutyGroup($encrypt->decrypt($request->getParameter('id')));
        if (!$DutyGroup) {
            $this->setMessage('WARNING', array($this->getContext()->getI18N()->__('Can not update. Record has been Deleted', $args, 'messages')));
            $this->redirect('performance/DutyGroup');
        }

        $this->DutyGroup = $DutyGroup;
        if ($request->isMethod('post')) {

            (strlen($request->getParameter('txtDutyGroupCode')  ? $DutyGroup->setDtg_code(trim($request->getParameter('txtDutyGroupCode'))) : $DutyGroup->setDtg_code(null))); // returns true

            (strlen($request->getParameter('txtDutyGroupName')  ? $DutyGroup->setDtg_name(trim($request->getParameter('txtDutyGroupName'))) : $DutyGroup->setDtg_name(null))); // returns true

            (strlen($request->getParameter('txtDutyGroupNameSi')  ? $DutyGroup->setDtg_name_si(trim($request->getParameter('txtDutyGroupNameSi'))) : $DutyGroup->setDtg_name_si(null))); // returns true

            (strlen($request->getParameter('txtDutyGroupNameTa')  ? $DutyGroup->setDtg_name_ta(trim($request->getParameter('txtDutyGroupNameTa'))) : $DutyGroup->setDtg_name_ta(null))); // returns true

            (strlen($request->getParameter('txtDutyGroupDesc')  ? $DutyGroup->setDtg_desc(trim($request->getParameter('txtDutyGroupDesc'))) : $DutyGroup->setDtg_desc(null))); // returns true

            (strlen($request->getParameter('txtDutyGroupDescSi')  ? $DutyGroup->setDtg_desc_si(trim($request->getParameter('txtDutyGroupDescSi'))) : $DutyGroup->setDtg_desc_si(null))); // returns true

            (strlen($request->getParameter('txtDutyGroupDescTa')  ? $DutyGroup->setDtg_desc_ta(trim($request->getParameter('txtDutyGroupDescTa'))) : $DutyGroup->setDtg_desc_ta(null))); // returns true
           
            
          

            try {
                $performanceSaveService->saveDutyGroup($DutyGroup);
            } catch (Doctrine_Connection_Exception $e) {
                $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('performance/UpdateDutyGroup?id=' . $encrypt->encrypt($DutyGroup->dtg_id) . '&lock=0');
            } catch (Exception $e) {
                $errMsg = new CommonException($e->getMessage(), $e->getCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('performance/UpdateDutyGroup?id=' . $encrypt->encrypt($DutyGroup->dtg_id) . '&lock=0');
            }
            $this->setMessage('SUCCESS', array($this->getContext()->getI18N()->__("Successfully Updated", $args, 'messages')));
            $this->redirect('performance/UpdateDutyGroup?id=' . $encrypt->encrypt($DutyGroup->dtg_id) . '&lock=0');
        }
    }

    public function executeDeleteDutyGroup(sfWebRequest $request) {
        if (count($request->getParameter('chkLocID')) > 0) {
           $performanceSaveService=new PerformanceSaveService();
            try {
                $conn = Doctrine_Manager::getInstance()->connection();
                $conn->beginTransaction();
                $ids = array();
                $ids = $request->getParameter('chkLocID');

                $countArr = array();
                $saveArr = array();
                for ($i = 0; $i < count($ids); $i++) {
                    $conHandler = new ConcurrencyHandler();
                    $isRecordLocked = $conHandler->isTableLocked('hs_hr_perf_duty_group', array($ids[$i]), 1);
                    if ($isRecordLocked) {

                        $countArr = $ids[$i];
                    } else {
                        $saveArr = $ids[$i];
                        $performanceSaveService->deleteDutyGroup($ids[$i]);
                        $conHandler->resetTableLock('hs_hr_perf_duty_group', array($ids[$i]), 1);
                    }
                }

                $conn->commit();
            } catch (Doctrine_Connection_Exception $e) {
                $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('performance/DutyGroup');
            } catch (Exception $e) {
                $conn->rollBack();
                $errMsg = new CommonException($e->getMessage(), $e->getCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('performance/DutyGroup');
            }
            if (count($saveArr) > 0 && count($countArr) == 0) {
                $this->setMessage('SUCCESS', array($this->getContext()->getI18N()->__("Successfully Deleted", $args, 'messages')));
            } elseif (count($saveArr) > 0 && count($countArr) > 0) {
                $this->setMessage('WARNING', array($this->getContext()->getI18N()->__("Some records are can not be deleted as them  Locked by another user ", $args, 'messages')));
            } elseif (count($saveArr) == 0 && count($countArr) > 0) {
                $this->setMessage('WARNING', array($this->getContext()->getI18N()->__("Can not delete as them  Locked by another user ", $args, 'messages')));
            }
        } else {
            $this->setMessage('NOTICE', array('Select at least one record to delete'));
        }
        $this->redirect('performance/DutyGroup');
    }

    //Duty
    public function executeDuty(sfWebRequest $request) {

        try {
            $this->Culture = $this->getUser()->getCulture();
             $performanceSearchService = new PerformanceSearchService();

            $this->sorter = new ListSorter('Duty', 'performance', $this->getUser(), array('d.dut_id', ListSorter::ASCENDING));
            $this->sorter->setSort(array($request->getParameter('sort'), $request->getParameter('order')));

            if ($request->getParameter('mode') == 'search') {
                if (($request->getParameter('searchMode') == 'all') && (trim($request->getParameter('searchValue')) != '')) {
                    $this->setMessage('NOTICE', array('Select the field to search'));
                    $this->redirect('performance/Duty');
                }
                $this->var = 1;
            }

            $this->searchMode = ($request->getParameter('searchMode') == null) ? 'all' : $request->getParameter('searchMode');
            $this->searchValue = ($request->getParameter('searchValue') == null) ? '' : $request->getParameter('searchValue');

            $this->sort = ($request->getParameter('sort') == '') ? 'd.dut_id' : $request->getParameter('sort');
            $this->order = ($request->getParameter('order') == '') ? 'ASC' : $request->getParameter('order');
            $res = $performanceSearchService->searchDuty($this->searchMode, $this->searchValue, $this->Culture, $this->sort, $this->order, $request->getParameter('page'));
            $this->DutyList = $res['data'];
            $this->pglay = $res['pglay'];
            $this->pglay->setTemplate('<a href="{%url}">{%page}</a>');
            $this->pglay->setSelectedTemplate('{%page}');
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
            $this->redirect('default/error');
        }
    }

    public function executeSaveDuty(sfWebRequest $request) {
        $this->myCulture = $this->getUser()->getCulture();
        $performanceService = new PerformanceService();
        $this->DutyGroupList = $performanceService->readDutyGroupList();
        $this->RateList = $performanceService->readRateList();
        $Duty = new PerformanceDuty();
        if ($request->isMethod('post')) {

            

            try {
                $performanceService->saveDuty($Duty,$request);
            } catch (Doctrine_Connection_Exception $e) {
                $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('performance/Duty');
            } catch (Exception $e) {
                $errMsg = new CommonException($e->getMessage(), $e->getCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('performance/Duty');
            }
            $this->setMessage('SUCCESS', array($this->getContext()->getI18N()->__("Successfully Saved", $args, 'messages')));
            $this->redirect('performance/Duty');
        }
    }

    public function executeUpdateDuty(sfWebRequest $request) {
        //Table Lock code is Open

        $encrypt = new EncryptionHandler();
        if (!strlen($request->getParameter('lock'))) {
            $this->lockMode = 0;
        } else {
            $this->lockMode = $request->getParameter('lock');
        }
        $PGID = $encrypt->decrypt($request->getParameter('id'));
        if (isset($this->lockMode)) {
            if ($this->lockMode == 1) {

                $conHandler = new ConcurrencyHandler();

                $recordLocked = $conHandler->setTableLock('hs_hr_perf_duty', array($PGID), 1);

                if ($recordLocked) {
                    // Display page in edit mode
                    $this->lockMode = 1;
                } else {
                    $this->setMessage('WARNING', array($this->getContext()->getI18N()->__('Can not update. Record locked by another user.', $args, 'messages')), false);
                    $this->lockMode = 0;
                }
            } else if ($this->lockMode == 0) {
                $conHandler = new ConcurrencyHandler();
                $recordLocked = $conHandler->resetTableLock('hs_hr_perf_duty', array($PGID), 1);
                $this->lockMode = 0;
            }
        }

        //Table lock code is closed
        $this->myCulture = $this->getUser()->getCulture();
        $performanceService = new PerformanceService();
        $Duty = new PerformanceDuty();

        $Duty = $performanceService->readDuty($encrypt->decrypt($request->getParameter('id')));
        if (!$Duty) {
            $this->setMessage('WARNING', array($this->getContext()->getI18N()->__('Can not update. Record has been Deleted', $args, 'messages')));
            $this->redirect('performance/Duty');
        }

        $this->Duty = $Duty;
        $this->DutyGroupList = $performanceService->readDutyGroupList();
        $this->RateList = $performanceService->readRateList();
        if ($request->isMethod('post')) {
            $performanceSearchService = new PerformanceSearchService();
            $dutyObj=$performanceSearchService->getUpdatedutyObj($request,$Duty);
            
            try {
                $performanceService->saveDuty($dutyObj,$request);
            } catch (Doctrine_Connection_Exception $e) {
                $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('performance/UpdateDuty?id=' . $encrypt->encrypt($Duty->dut_id) . '&lock=0');
            } catch (sfStopException $e) {
                
            } catch (Exception $e) {
                $errMsg = new CommonException($e->getMessage(), $e->getCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('performance/UpdateDuty?id=' . $encrypt->encrypt($Duty->dut_id) . '&lock=0');
            }
            $this->setMessage('SUCCESS', array($this->getContext()->getI18N()->__("Successfully Updated", $args, 'messages')));
            $this->redirect('performance/UpdateDuty?id=' . $encrypt->encrypt($Duty->dut_id) . '&lock=0');
        }
    }

    public function executeDeleteDuty(sfWebRequest $request) {
        if (count($request->getParameter('chkLocID')) > 0) {
            $performanceSaveService=new PerformanceSaveService();
            try {
                $conn = Doctrine_Manager::getInstance()->connection();
                $conn->beginTransaction();
                $ids = array();
                $ids = $request->getParameter('chkLocID');

                $countArr = array();
                $saveArr = array();
                for ($i = 0; $i < count($ids); $i++) {
                    $conHandler = new ConcurrencyHandler();
                    $isRecordLocked = $conHandler->isTableLocked('hs_hr_perf_duty', array($ids[$i]), 1);
                    if ($isRecordLocked) {
                        $countArr = $ids[$i];
                    } else {
                        $saveArr = $ids[$i];
                        $performanceSaveService->deleteDuty($ids[$i]);
                        $conHandler->resetTableLock('hs_hr_perf_duty', array($ids[$i]), 1);
                    }
                }

                $conn->commit();
            } catch (Doctrine_Connection_Exception $e) {
                $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('performance/Duty');
            } catch (Exception $e) {
                $conn->rollBack();
                $errMsg = new CommonException($e->getMessage(), $e->getCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('performance/Duty');
            }
            if (count($saveArr) > 0 && count($countArr) == 0) {
                $this->setMessage('SUCCESS', array($this->getContext()->getI18N()->__("Successfully Deleted", $args, 'messages')));
            } elseif (count($saveArr) > 0 && count($countArr) > 0) {
                $this->setMessage('WARNING', array($this->getContext()->getI18N()->__("Some records are can not be deleted as them  Locked by another user ", $args, 'messages')));
            } elseif (count($saveArr) == 0 && count($countArr) > 0) {
                $this->setMessage('WARNING', array($this->getContext()->getI18N()->__("Can not delete as them  Locked by another user ", $args, 'messages')));
            }
        } else {
            $this->setMessage('NOTICE', array('Select at least one record to delete'));
        }
        $this->redirect('performance/Duty');
    }

    //Rate
    public function executeRate(sfWebRequest $request) {

        try {
            $this->Culture = $this->getUser()->getCulture();
            $performanceSearchService = new PerformanceSearchService();

            $this->sorter = new ListSorter('Rate', 'performance', $this->getUser(), array('r.rate_id', ListSorter::ASCENDING));
            $this->sorter->setSort(array($request->getParameter('sort'), $request->getParameter('order')));

            if ($request->getParameter('mode') == 'search') {
                if (($request->getParameter('searchMode') == 'all') && (trim($request->getParameter('searchValue')) != '')) {
                    $this->setMessage('NOTICE', array('Select the field to search'));
                    $this->redirect('performance/Rate');
                }
                $this->var = 1;
            }

            $this->searchMode = ($request->getParameter('searchMode') == null) ? 'all' : $request->getParameter('searchMode');
            $this->searchValue = ($request->getParameter('searchValue') == null) ? '' : $request->getParameter('searchValue');

            $this->sort = ($request->getParameter('sort') == '') ? 'r.rate_id' : $request->getParameter('sort');
            $this->order = ($request->getParameter('order') == '') ? 'ASC' : $request->getParameter('order');
            $res = $performanceSearchService->searchRate($this->searchMode, $this->searchValue, $this->Culture, $this->sort, $this->order, $request->getParameter('page'));
            $this->RateList = $res['data'];
            $this->pglay = $res['pglay'];
            $this->pglay->setTemplate('<a href="{%url}">{%page}</a>');
            $this->pglay->setSelectedTemplate('{%page}');
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
            $this->redirect('default/error');
        }
    }

    public function executeSaveRate(sfWebRequest $request) {
        $this->myCulture = $this->getUser()->getCulture();
        try {
            $performanceService = new PerformanceService();
            $performanceSaveService=new PerformanceSaveService();
            $Rate = new PerformanceRate();

            if ($request->isMethod('post')) {
                $conn = Doctrine_Manager::getInstance()->connection();
                $conn->beginTransaction();

               $rateObj=$performanceSaveService->getRatesObj($request,$Rate);

              

                $performanceService->saveRate($rateObj);
                $RateCode = $performanceService->getLastRateID();


                $exploed = array();
                $count_rows = array();

                foreach ($_POST as $key => $value) {


                    $exploed = explode("_", $key);


                    if (strlen($exploed[1])) {

                        $count_rows[] = $exploed[1];

                        $arrname = "a_" . $exploed[1];

                        if (!is_array($$arrname)) {
                            $$arrname = Array();
                        }

                        ${$arrname}[$exploed[0]] = $value;
                    }
                }

                $uniqueRowIds = array_unique($count_rows);
                $uniqueRowIds = array_values($uniqueRowIds);

                for ($i = 0; $i < count($uniqueRowIds); $i++) {
                    $RateDetail = new PerformanceRateDetails();
                    $RateDetail->setRate_id($RateCode[0]['MAX']);



                    $v = "a_" . $uniqueRowIds[$i];



                    if (!strlen(${$v}[txtGrade])) {
                        $RateDetail->setRdt_grade(null);
                    } else {
                        $RateDetail->setRdt_grade(${$v}[txtGrade]);
                    }
                    if (!strlen(${$v}[txtMarks])) {

                        $RateDetail->setRdt_mark(null);
                    } else {
                        $RateDetail->setRdt_mark(${$v}[txtMarks]);
                    }
                    if (!strlen(${$v}[txtRIDesc])) {

                        $RateDetail->setRdt_description(null);
                    } else {
                        $RateDetail->setRdt_description(${$v}[txtRIDesc]);
                    }
                    $performanceService->saveRateDetail($RateDetail);
                }
                //---------------

                $conn->commit();
                $this->setMessage('SUCCESS', array($this->getContext()->getI18N()->__("Successfully Saved", $args, 'messages')));
                $this->redirect('performance/Rate');
            }
        } catch (sfStopException $sf) {
            
        } catch (Doctrine_Connection_Exception $e) {
            $conn->rollBack();
            $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
            $this->setMessage('WARNING', $errMsg->display());
            $this->redirect('performance/Rate');
        } catch (Exception $e) {
            $conn->rollBack();
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
            $this->redirect('performance/Rate');
        }
    }

    public function executeUpdateRate(sfWebRequest $request) {
        //Table Lock code is Open

        $encrypt = new EncryptionHandler();
        if (!strlen($request->getParameter('lock'))) {
            $this->lockMode = 0;
        } else {
            $this->lockMode = $request->getParameter('lock');
        }
        $RateID = $encrypt->decrypt($request->getParameter('id'));
        if (isset($this->lockMode)) {
            if ($this->lockMode == 1) {

                $conHandler = new ConcurrencyHandler();

                $recordLocked = $conHandler->setTableLock('hs_hr_perf_rate', array($RateID), 1);

                if ($recordLocked) {
                    // Display page in edit mode
                    $this->lockMode = 1;
                } else {
                    $this->setMessage('WARNING', array($this->getContext()->getI18N()->__('Can not update. Record locked by another user.', $args, 'messages')), false);
                    $this->lockMode = 0;
                }
            } else if ($this->lockMode == 0) {
                $conHandler = new ConcurrencyHandler();
                $conHandler->resetTableLock('hs_hr_perf_rate', array($RateID), 1);
                $this->lockMode = 0;
            }
        }

        //Table lock code is closed
        $this->myCulture = $this->getUser()->getCulture();
        $performanceService = new PerformanceService();
        $performanceSaveService=new PerformanceSaveService();
        $Rate = new PerformanceRate();

        $Rate = $performanceService->readRate($encrypt->decrypt($request->getParameter('id')));
        if (!$Rate) {
            $this->setMessage('WARNING', array($this->getContext()->getI18N()->__('Can not update. Record has been Deleted', $args, 'messages')));
            $this->redirect('performance/Rate');
        }

        $this->Rate = $Rate;
        $this->RateDetails = $performanceService->readRateDetailList($RateID,$Rate->rate_option);

        try {
            if ($request->isMethod('post')) {
                $conn = Doctrine_Manager::getInstance()->connection();
                $conn->beginTransaction();

               $Rate=$performanceSaveService->GetUpdateRateObj($request,$Rate);



                $performanceService->saveRate($Rate);
                $performanceSaveService->deleteRateDetail($RateID);


                $exploed = array();
                $count_rows = array();

                foreach ($_POST as $key => $value) {


                    $exploed = explode("_", $key);


                    if (strlen($exploed[1])) {

                        $count_rows[] = $exploed[1];

                        $arrname = "a_" . $exploed[1];

                        if (!is_array($$arrname)) {
                            $$arrname = Array();
                        }

                        ${$arrname}[$exploed[0]] = $value;
                    }
                }

                $uniqueRowIds = array_unique($count_rows);
                $uniqueRowIds = array_values($uniqueRowIds);

                for ($i = 0; $i < count($uniqueRowIds); $i++) {
                    $RateDetail = new PerformanceRateDetails();
                    $RateDetail->setRate_id($RateID);



                    $v = "a_" . $uniqueRowIds[$i];



                    if (!strlen(${$v}[txtGrade])) {
                        $RateDetail->setRdt_grade(null);
                    } else {
                        $RateDetail->setRdt_grade(${$v}[txtGrade]);
                    }
                    if (!strlen(${$v}[txtMarks])) {

                        $RateDetail->setRdt_mark(null);
                    } else {
                        $RateDetail->setRdt_mark(${$v}[txtMarks]);
                    }
                    if (!strlen(${$v}[txtRIDesc])) {

                        $RateDetail->setRdt_description(null);
                    } else {
                        $RateDetail->setRdt_description(${$v}[txtRIDesc]);
                    }
                    $performanceService->saveRateDetail($RateDetail);
                }
                //---------------

                $conn->commit();
                $this->setMessage('SUCCESS', array($this->getContext()->getI18N()->__("Successfully Updated", $args, 'messages')));
                $this->redirect('performance/UpdateRate?id=' . $encrypt->encrypt($Rate->rate_id) . '&lock=0');
            }
        } catch (sfStopException $sf) {
            
        } catch (Doctrine_Connection_Exception $e) {
            $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
            $this->setMessage('WARNING', $errMsg->display());
            $this->redirect('performance/UpdateRate?id=' . $encrypt->encrypt($Rate->rate_id) . '&lock=0');
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
            $this->redirect('performance/UpdateRate?id=' . $encrypt->encrypt($Rate->rate_id) . '&lock=0');
        }
    }

    public function executeDeleteRate(sfWebRequest $request) {
        if (count($request->getParameter('chkLocID')) > 0) {
                $performanceSaveService=new PerformanceSaveService();
            try {
                $conn = Doctrine_Manager::getInstance()->connection();
                $conn->beginTransaction();
                $ids = array();
                $ids = $request->getParameter('chkLocID');

                $countArr = array();
                $saveArr = array();
                for ($i = 0; $i < count($ids); $i++) {
                    $conHandler = new ConcurrencyHandler();
                    $isRecordLocked = $conHandler->isTableLocked('hs_hr_perf_rate', array($ids[$i]), 1);
                    if ($isRecordLocked) {

                        $countArr = $ids[$i];
                    } else {
                        $saveArr = $ids[$i];
                        $performanceSaveService->deleteRateDetail($ids[$i]);
                        $performanceSaveService->deleteRate($ids[$i]);
                        $conHandler->resetTableLock('hs_hr_perf_rate', array($ids[$i]), 1);
                    }
                }

                $conn->commit();
            } catch (Doctrine_Connection_Exception $e) {
                $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('performance/Rate');
            } catch (Exception $e) {
                $conn->rollBack();
                $errMsg = new CommonException($e->getMessage(), $e->getCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('performance/Rate');
            }
            if (count($saveArr) > 0 && count($countArr) == 0) {
                $this->setMessage('SUCCESS', array($this->getContext()->getI18N()->__("Successfully Deleted", $args, 'messages')));
            } elseif (count($saveArr) > 0 && count($countArr) > 0) {
                $this->setMessage('WARNING', array($this->getContext()->getI18N()->__("Some records are can not be deleted as them  Locked by another user ", $args, 'messages')));
            } elseif (count($saveArr) == 0 && count($countArr) > 0) {
                $this->setMessage('WARNING', array($this->getContext()->getI18N()->__("Can not delete as them  Locked by another user ", $args, 'messages')));
            }
        } else {
            $this->setMessage('NOTICE', array('Select at least one record to delete'));
        }
        $this->redirect('performance/Rate');
    }

    /*
     *  load Company Evaluation Information
     */

    public function executeCompanyEvaluationInfo(sfWebRequest $request) {
        try {
            $this->Culture = $this->getUser()->getCulture();
           $performanceSearchService = new PerformanceSearchService();
            $this->sorter = new ListSorter('Evaluation', 'performance', $this->getUser(), array('e.eval_id', ListSorter::ASCENDING));
            $this->sorter->setSort(array($request->getParameter('sort'), $request->getParameter('order')));
            if ($request->getParameter('mode') == 'search') {
                if (($request->getParameter('searchMode') == 'all') && (trim($request->getParameter('searchValue')) != '')) {
                    $this->setMessage('NOTICE', array('Select the field to search'));
                    $this->redirect('performance/CompanyEvaluationInfo');
                }
                $this->var = 1;
            }
            $this->searchMode = ($request->getParameter('searchMode') == null) ? 'all' : $request->getParameter('searchMode');
            $this->searchValue = ($request->getParameter('searchValue') == null) ? '' : $request->getParameter('searchValue');
            $this->sort = ($request->getParameter('sort') == '') ? 'e.rate_id' : $request->getParameter('sort');
            $this->order = ($request->getParameter('order') == '') ? 'ASC' : $request->getParameter('order');
            $res = $performanceSearchService->searchEvaluationCompanyInfo($this->searchMode, $this->searchValue, $this->Culture, $this->sort, $this->order, $request->getParameter('page'));
            $this->EvaluationList = $res['data'];
            $this->pglay = $res['pglay'];
            $this->pglay->setTemplate('<a href="{%url}">{%page}</a>');
            $this->pglay->setSelectedTemplate('{%page}');
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
            $this->redirect('default/error');
        }
    }

    public function executeSaveCompanyEvaluationInfo(sfWebRequest $request) {
        $this->myCulture = $this->getUser()->getCulture();
        $performanceService = new PerformanceService();
        $this->RateList = $performanceService->readRateList();
        $this->YearList = $performanceService->readYearList();
        $EvaluationComInfo = new PerformanceEvaluation();
        if ($request->isMethod('post')) {
        

            try {
                $performanceService->saveEvaluationCompanyInfo($EvaluationComInfo,$request);
            } catch (Doctrine_Connection_Exception $e) {
                $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('performance/CompanyEvaluationInfo');
            } catch (Exception $e) {
                $errMsg = new CommonException($e->getMessage(), $e->getCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('performance/CompanyEvaluationInfo');
            }
            $this->setMessage('SUCCESS', array($this->getContext()->getI18N()->__("Successfully Saved", $args, 'messages')));
            $this->redirect('performance/CompanyEvaluationInfo');
        }
    }

    /*
     *  Delete Company Evaluation Information
     */

    public function executeDeleteCompanyEvaluationInfo(sfWebRequest $request) {
        if (count($request->getParameter('chkLocID')) > 0) {
            $performanceSearchService = new PerformanceSearchService();
            $PerformanceSaveService = new PerformanceSaveService();
            try {
                $conn = Doctrine_Manager::getInstance()->connection();
                $conn->beginTransaction();
                $ids = array();
                $ids = $request->getParameter('chkLocID');

                $countArr = array();
                $saveArr = array();
                for ($i = 0; $i < count($ids); $i++) {
                    $conHandler = new ConcurrencyHandler();
                    $isRecordLocked = $conHandler->isTableLocked('hs_hr_perf_evaluation', array($ids[$i]), 1);
                    if ($isRecordLocked) {
                        $countArr = $ids[$i];
                    } else {
                        $saveArr = $ids[$i];
                        $PerformanceSaveService->deleteEvaluationCompanyInfo($ids[$i]);
                        $conHandler->resetTableLock('hs_hr_perf_evaluation', array($ids[$i]), 1);
                    }
                }

                $conn->commit();
            } catch (Doctrine_Connection_Exception $e) {
                $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('performance/CompanyEvaluationInfo');
            } catch (Exception $e) {
                $conn->rollBack();
                $errMsg = new CommonException($e->getMessage(), $e->getCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('performance/CompanyEvaluationInfo');
            }
            if (count($saveArr) > 0 && count($countArr) == 0) {
                $this->setMessage('SUCCESS', array($this->getContext()->getI18N()->__("Successfully Deleted", $args, 'messages')));
            } elseif (count($saveArr) > 0 && count($countArr) > 0) {
                $this->setMessage('WARNING', array($this->getContext()->getI18N()->__("Some records are can not be deleted as them  Locked by another user ", $args, 'messages')));
            } elseif (count($saveArr) == 0 && count($countArr) > 0) {
                $this->setMessage('WARNING', array($this->getContext()->getI18N()->__("Can not delete as them  Locked by another user ", $args, 'messages')));
            }
        } else {
            $this->setMessage('NOTICE', array('Select at least one record to delete'));
        }
        $this->redirect('performance/CompanyEvaluationInfo');
    }

    /*
     *  Update Company Evaluation Information
     */

    public function executeUpdateCompanyEvaluationInfo(sfWebRequest $request) {
        //Table Lock code is Open
        $encrypt = new EncryptionHandler();
        if (!strlen($request->getParameter('lock'))) {
            $this->lockMode = 0;
        } else {
            $this->lockMode = $request->getParameter('lock');
        }
        $PGID = $encrypt->decrypt($request->getParameter('id'));
        if (isset($this->lockMode)) {
            if ($this->lockMode == 1) {

                $conHandler = new ConcurrencyHandler();

                $recordLocked = $conHandler->setTableLock('hs_hr_perf_evaluation', array($PGID), 1);

                if ($recordLocked) {
                    // Display page in edit mode
                    $this->lockMode = 1;
                } else {
                    $this->setMessage('WARNING', array($this->getContext()->getI18N()->__('Can not update. Record locked by another user.', $args, 'messages')), false);
                    $this->lockMode = 0;
                }
            } else if ($this->lockMode == 0) {
                $conHandler = new ConcurrencyHandler();
                $conHandler->resetTableLock('hs_hr_perf_evaluation', array($PGID), 1);
                $this->lockMode = 0;
            }
        }

        //Table lock code is closed
        $this->myCulture = $this->getUser()->getCulture();
        $performanceService = new PerformanceService();
        $EvaluationComInfo = new PerformanceEvaluation();

        $EvaluationComInfo = $performanceService->readEvaluationCompanyInfo($encrypt->decrypt($request->getParameter('id')));
        if (!$EvaluationComInfo) {
            $this->setMessage('WARNING', array($this->getContext()->getI18N()->__('Can not update. Record has been Deleted', $args, 'messages')));
            $this->redirect('performance/CompanyEvaluationInfo');
        }

        $this->Evaluation = $EvaluationComInfo;
        $this->YearList = $performanceService->readYearList();
        $this->RateList = $performanceService->readRateList();
        if ($request->isMethod('post')) {
            

            try {
                $performanceService->saveEvaluationCompanyInfo($EvaluationComInfo,$request);
            } catch (Doctrine_Connection_Exception $e) {
                $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('performance/UpdateCompanyEvaluationInfo?id=' . $encrypt->encrypt($EvaluationComInfo->eval_id) . '&lock=0');
            } catch (sfStopException $e) {
                
            } catch (Exception $e) {
                $errMsg = new CommonException($e->getMessage(), $e->getCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('performance/UpdateCompanyEvaluationInfo?id=' . $encrypt->encrypt($EvaluationComInfo->eval_id) . '&lock=0');
            }
            $this->setMessage('SUCCESS', array($this->getContext()->getI18N()->__("Successfully Updated", $args, 'messages')));
            $this->redirect('performance/UpdateCompanyEvaluationInfo?id=' . $encrypt->encrypt($EvaluationComInfo->eval_id) . '&lock=0');
        }
    }

    //Assign Employee
    public function executeAssingEmployee(sfWebRequest $request) {
        $performanceService = new PerformanceService();
         $performanceSearchService = new PerformanceSearchService();
        $this->Culture = $this->getUser()->getCulture();
        $this->EvaluationList = $performanceService->getEvaluationList();
        $this->EvaluationTypeList = $performanceService->getEvaluationTypeList();
        try {
            $this->sorter = new ListSorter('AssingEmployee', 'performance', $this->getUser(), array('e.emp_number', ListSorter::ASCENDING));
            $this->sorter->setSort(array($request->getParameter('sort'), $request->getParameter('order')));

            $this->searchEvaluation = ($request->getParameter('cmbbtype') == null) ? $request->getParameter('searchEvaluation') : $request->getParameter('cmbbtype');
            $this->searchEvaluationType = ($request->getParameter('cmbEtype') == null) ? $request->getParameter('searchEvaluationType') : $request->getParameter('cmbEtype');
            $this->searchMode = ($request->getParameter('searchMode') == null) ? 'all' : $request->getParameter('searchMode');
            $this->searchValue = ($request->getParameter('searchValue') == null) ? '' : $request->getParameter('searchValue');
            $this->YEAR = ($request->getParameter('txtYear') == null) ? $request->getParameter('txtYear') : $request->getParameter('txtYear');
            $this->sort = ($request->getParameter('sort') == '') ? 'e.emp_number' : $request->getParameter('sort');
            $this->order = ($request->getParameter('order') == '') ? 'ASC' : $request->getParameter('order');
            $res = $performanceSearchService->searchAssingEmployee($this->searchMode, $this->searchValue, $this->Culture, $this->sort, $this->order, $request->getParameter('page'), $this->searchEvaluation, $this->searchEvaluationType);
            $this->AssingEmployeeList = $res['data'];
            $this->pglay = $res['pglay'];
            $this->pglay->setTemplate('<a href="{%url}">{%page}</a>');
            $this->pglay->setSelectedTemplate('{%page}');
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
            $this->redirect('default/error');
        }
    }

    public function executeSaveAssingEmployee(sfWebRequest $request) {
        $performanceService = new PerformanceService();
        $this->Culture = $this->getUser()->getCulture();
        $this->EvaluationList = $performanceService->getEvaluationList();
        $this->EvaluationTypeList = $performanceService->getEvaluationTypeList();
        $this->EVID = $request->getParameter('EVID');
        $this->ETID = $request->getParameter('ETID');
        try {
            if ($request->isMethod('post')) {
                $conn = Doctrine_Manager::getInstance()->connection();
                $conn->beginTransaction();
                $count = 0;
        $this->EVID = $request->getParameter('cmbbtype');
        $this->ETID = $request->getParameter('cmbEtype');
         $performanceService = new PerformanceService();
                foreach ($_POST['hiddenEmpNumber'] as $row) {

                    if (strlen($row)) {
                        $EmployeeData = $performanceService->readEmployee($row);
                        $JobTitle = $EmployeeData->job_title_code;
                        $Level = $EmployeeData->level_code;
                        $Service = $EmployeeData->service_code;
                        $EvaluationDtlID = $performanceService->readEvalDetailID($JobTitle, $Level, $Service, $this->EVID);
                        $performanceService->getDeleteEvaluationEmpList($request->getParameter('cmbbtype'), $request->getParameter('cmbEtype'), $row, $EvaluationDtlID->eval_dtl_id);
                        $EvalEmployee = new PerformanceEvaluationEmployee();
                        $EvalEmployee->setEval_id($request->getParameter('cmbbtype'));
                        $EvalEmployee->setEval_type_id($request->getParameter('cmbEtype'));
                        $EvalEmployee->setEval_emp_status("0");
                        $EvalEmployee->setEmp_number($row);
                        $EvalEmployee->setEval_dtl_id($EvaluationDtlID->eval_dtl_id);
                        if ($EvaluationDtlID->eval_dtl_id != null) {
                            $performanceService->saveEvaluationEmpList($EvalEmployee);
                        } else {
                            $count++;
                        }

//                        $empSuperData=$performanceService->readSuperViceData($request->getParameter('cmbbtype'),$row);
//
//                        if(!$empSuperData){
//                            $supObj=new PerformanceEvaluationSupervisor();
//
//                            $getDirectSuperVice=$performanceService->getDirectSupervicerName($row);
//                            if(strlen($getDirectSuperVice->supervisorId)){
//                            $supObj->setEval_id($request->getParameter('cmbbtype'));
//                            $supObj->setEmp_number($row);
//                            $supObj->setSup_num($getDirectSuperVice->supervisorId);
//                            $supObj->setEval_sup_flag(1);//direct sup by default
//                            $supObj->save();
//                            }
//
//                        }

                    }



                }
                $conn->commit();
                if ($count == 0) {
                    $this->setMessage('SUCCESS', array($this->getContext()->getI18N()->__("Successfully Saved.", $args, 'messages')));
                } else {
                    $this->setMessage('WARNING', array($this->getContext()->getI18N()->__("Some employee(s) were not added due to the company evaluation not defined for their designation,level,service and job role.", $args, 'messages')));
                }
            }
        } catch (sfStopException $sf) {
            
        } catch (Doctrine_Connection_Exception $e) {
            $conn->rollback();
            $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
            $this->setMessage('WARNING', $errMsg->display());
            $this->redirect('performance/SaveAssingEmployee');
        } catch (Exception $e) {
            $conn->rollback();
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
            $this->redirect('performance/SaveAssingEmployee');
        }
    }

    public function executeLoadGrid(sfWebRequest $request) {
        $this->culture = $this->getUser()->getCulture();
        $performanceService = new PerformanceService();
        $empId = $request->getParameter('empid');

        $this->emplist = $performanceService->getEmployee($empId);
    }

    public function executeCurrentEmployee(sfWebRequest $request) {

        $performanceService = new PerformanceService();
        $EVid = $request->getParameter('EVid');
        $ETid = $request->getParameter('ETid');

        $emplist = $performanceService->getEvaluationEmpList($EVid, $ETid);

        foreach ($emplist as $emp) {
            if ($emplist[0] == $emp) {
                $Employee.=$emp['emp_number'];
            } else {
                $Employee.="|" . $emp['emp_number'];
            }
        }
        echo json_encode($Employee);
        die;
    }

    public function executeYear(sfWebRequest $request) {

        $ID = $request->getParameter('id');
        $performanceService = new PerformanceService();
        $Year = $performanceService->getEvaluationYear($ID);
        echo json_encode($Year[0]['eval_year']);
        die;
    }
    
    public function executeEmployeeListById(sfWebRequest $request) {

        $ID = $request->getParameter('Eval');
        $Type = $request->getParameter('id');
        $performanceService = new PerformanceService();
       
        
        $chcekSavedBefore=$performanceService->CheckEvalIdExsist($ID);
        $returnArr=array();
        $empArr=array();
        $EmpListArr=$performanceService->getEvalEmpListById2($ID,$Type);
        $i=0;
                       foreach($EmpListArr as $key){
//                 echo $key->EmployeeSubordinate->emp_display_name;

                 //Use this code to the Name display in sinhala
//                  $n = "td_course_name_" . $culture;
//                    if ($row[$n] == null) {
//                     $n = "td_course_name_en";
//                } else {
//                      $n = "td_course_name_" . $culture;
//                    }
//                $arr[$row['td_course_id']] = $row[$n];
                
               

                $empArr[]=$key->emp_number;
                if(strlen($key->SuperVice->empNumber)){
                       $isDirectSuperVicer=$performanceService->isDirectSuperVicer($key->SuperVice->empNumber,$key->emp_number);
                      
                }


                $returnArr[$i]=$key->Employee->emp_display_name."|".$key->SuperVice->emp_display_name."|".$key->SuperVice->empNumber."|".$key->eval_sup_flag."|".'O'."|".$isDirectSuperVicer."|".$key->emp_number;
                $i++;
            }

            
            $EmpListArr2=$performanceService->getEvalEmpListByIdNotInSup($ID,$empArr,$Type);
            if(count($EmpListArr2)>0){
            foreach($EmpListArr2 as $key1){
                 $getDirectSuperVice=$performanceService->getDirectSupervicerName($key1->emp_number);
                if(strlen($getDirectSuperVice->supervisor->empNumber)){
                       $isDirectSuperVicer1=$performanceService->isDirectSuperVicer($getDirectSuperVice->supervisor->empNumber,$key1->emp_number);
                      
                }

           
                $returnArr[$i]=$key1->EmployeeSubordinate->emp_display_name."|".$getDirectSuperVice->supervisor->emp_display_name."|".$getDirectSuperVice->supervisor->empNumber."|".'1'."|".'N'."|".$isDirectSuperVicer1."|".$key1->emp_number;
            $i++;
                
            }
            
           }
           


//            print_r($returnArr);die;
//            die;

//        die(print_r($returnArr));
//        if($chcekSavedBefore[0][evalCount]>0){
//            $supObj=new PerformanceEvaluationSupervisor();
//        }else{
//            $EmpListArr=$performanceService->getEvalEmpListById($id);
//        }

        //uasort($returnArr, 'cmp');   
        echo json_encode($returnArr);
        die;
    }

    public function executeSearchEmployee(sfWebRequest $request) {
        try {

            $this->userCulture = $this->getUser()->getCulture();
            
            $performanceSearchService = new PerformanceSearchService();
            $this->type = $request->getParameter('type', isset($_SESSION["type"]) ? $_SESSION["type"] : 'single');
            $this->method = $request->getParameter('method', isset($_SESSION["method"]) ? $_SESSION["method"] : '');
            $reason = $request->getParameter('reason');
            if (strlen($reason)) {
                $this->reason = $reason;
            } else {
                $this->reason = '';
            }

            $att = $request->getParameter('att');
            if (strlen($att)) {
                $this->att = $att;
            } else {
                $this->att = '';
            }
            $EVid = $request->getParameter('EVid');
            if (strlen($EVid)) {
                $this->EVid = $EVid;
            } else {
                $this->EVid = '';
            }
            $ETid = $request->getParameter('ETid');
            if (strlen($ETid)) {
                $this->ETid = $ETid;
            } else {
                $this->ETid = '';
            }


            //Store in session to support sorting
            $_SESSION["type"] = $this->type;
            $_SESSION["method"] = $this->method;

            $this->sorter = new ListSorter('propoerty.sort', 'pim_module', $this->getUser(), array('emp_number', ListSorter::ASCENDING));
            $this->sorter->setSort(array($request->getParameter('sort'), $request->getParameter('order')));

            $this->searchMode = ($request->getParameter('cmbSearchMode') == '') ? 'all' : $request->getParameter('cmbSearchMode');
            $this->searchValue = ($request->getParameter('txtSearchValue') == '') ? '' : $request->getParameter('txtSearchValue');

            $this->sort = ($request->getParameter('sort') == '') ? 'e.emp_number' : $request->getParameter('sort');
            $this->order = ($request->getParameter('order') == '') ? 'ASC' : $request->getParameter('order');
            $result = $performanceSearchService->searchEmployee($this->searchMode, $this->searchValue, $this->userCulture, $request->getParameter('page'), $this->sort, $this->order, $this->type, $this->method, $this->reason, $this->att, $this->ETid, $this->EVid);

            $this->listEmployee = $result['data'];
            $this->pglay = $result['pglay'];
            $this->pglay->setTemplate('<a href="{%url}">{%page}</a>');
            $this->pglay->setSelectedTemplate('{%page}');
        } catch (sfStopException $sf) {
            $this->redirect('performance/searchEmployee');
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
            $this->redirect('performance/searchEmployee');
        }
    }

    /*
     *  load Evaluation
     */

    public function executeEvaluation(sfWebRequest $request) {
        try {
            $this->Culture = $this->getUser()->getCulture();
            
            $performanceSearchService = new PerformanceSearchService();
            $this->sorter = new ListSorter('EvaluationDetail', 'performance', $this->getUser(), array('e.eval_dtl_id', ListSorter::ASCENDING));
            $this->sorter->setSort(array($request->getParameter('sort'), $request->getParameter('order')));
            if ($request->getParameter('mode') == 'search') {
                if (($request->getParameter('searchMode') == 'all') && (trim($request->getParameter('searchValue')) != '')) {
                    $this->setMessage('NOTICE', array('Select the field to search'));
                    $this->redirect('performance/Evaluation');
                }
                $this->var = 1;
            }
            $this->searchMode = ($request->getParameter('searchMode') == null) ? 'all' : $request->getParameter('searchMode');
            $this->searchValue = ($request->getParameter('searchValue') == null) ? '' : $request->getParameter('searchValue');
            $this->sort = ($request->getParameter('sort') == '') ? 'e.eval_dtl_id' : $request->getParameter('sort');
            $this->order = ($request->getParameter('order') == '') ? 'ASC' : $request->getParameter('order');
            $res = $performanceSearchService->searchEvaluation($this->searchMode, $this->searchValue, $this->Culture, $this->sort, $this->order, $request->getParameter('page'));
            $this->EvaluationList = $res['data'];
            $this->pglay = $res['pglay'];
            $this->pglay->setTemplate('<a href="{%url}">{%page}</a>');
            $this->pglay->setSelectedTemplate('{%page}');
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
            $this->redirect('default/error');
        }
    }

    public function executeSaveEvaluation(sfWebRequest $request) {


        $performanceService = new PerformanceService();
        $this->performanceService = $performanceService;
        $PerformanceSaveDao=new PerformanceSaveDao();
       
        $this->myCulture = $this->getUser()->getCulture();
        $this->CompanyEvaluationList = $performanceService->getEvaluationList();
        $this->DesignationList = $performanceService->getDesignationList();
        $this->LevelList = $performanceService->getLevelList();
        $this->ServiceList = $performanceService->getServiceList();
        $this->DutyGroupList = $performanceService->readDutyGroupList();
        $this->DutyList = $performanceService->getDutyList();

        if ($request->getParameter('id') != null) {
            $Evaluation = $performanceService->readEvaluation($request->getParameter('id'));
            $this->assignJobRoleList = $performanceService->getEvaluationJobRoleList($request->getParameter('id'));
            $this->Job_Role_List = $performanceService->getJobRoleList($Evaluation->jobtit_code, $Evaluation->level_code, $Evaluation->service_code, 0);
        }
        if (!strlen($request->getParameter('lock'))) {
            $this->mode = 0;
        } else {
            $this->mode = $request->getParameter('lock');
        }
        $ebLockid = $request->getParameter('id'); //die($transPid);
        // die($this->lockMode);
        if (isset($this->mode)) {
            if ($this->mode == 1) {

                $conHandler = new ConcurrencyHandler();

                $recordLocked = $conHandler->setTableLock('hs_hr_perf_evaluation_detail', array($ebLockid), 1);

                if ($recordLocked) {
                    // Display page in edit mode
                    $this->mode = 1;
                } else {
                    $this->mode = 0;
                    $this->setMessage('WARNING', array($this->getContext()->getI18N()->__('Can not update. Record locked by another user.', $args, 'messages')), false);
                    $this->redirect('performance/Evaluation');
                }
            } else if ($this->mode == 0) {
                $conHandler = new ConcurrencyHandler();
                $recordLocked = $conHandler->resetTableLock('hs_hr_perf_evaluation_detail', array($ebLockid), 1);
                $this->mode = 0;
            }
        }

        $requestId = $request->getParameter('id');
        $this->AssignDutyList = $performanceService->getEvaluationAssignDutyList($request->getParameter('id'));

        $employerAssignDuty = $performanceService->getEmployerAssignDuty($requestId);

        if (count($employerAssignDuty) > 0) {
            $this->mode = 0;
            $this->setMessage('WARNING', array($this->getContext()->getI18N()->__('Can not be Update Evaluation This used in  calculate Perforamance Process.', $args, 'messages')), false);
        }


        if (strlen($requestId)) {
            if (!strlen($this->mode)) {
                $this->mode = 0;
            }
            $this->disAct = $performanceService->readEvaluation($requestId);
            if (!$this->disAct) {
                $this->setMessage('WARNING', array($this->getContext()->geti18n()->__('Record Not Found')));
                $this->redirect('performance/Evaluation');
            }
        } else {
            $this->mode = 1;
        }
        if ($request->isMethod('post')) {                        
            try{
            if (strlen($request->getParameter('txtHiddenReqID'))) {
                $Evaluation = $performanceService->readEvaluation($request->getParameter('txtHiddenReqID'));
            } else {
                $Evaluation = new PerformanceEvaluationDetail();
            }

            if (strlen($request->getParameter('cmbComEvale'))) {
                $Evaluation->setEval_id(trim($request->getParameter('cmbComEvale')));
            } else {
                $Evaluation->setEval_id(null);
            }
            if (strlen($request->getParameter('cmbComDesignation'))) {
                $Evaluation->setJobtit_code(trim($request->getParameter('cmbComDesignation')));
            } else {
                $Evaluation->setJobtit_code(null);
            }
            if (strlen($request->getParameter('cmbComLevel'))) {
                $Evaluation->setLevel_code(trim($request->getParameter('cmbComLevel')));
            } else {
                $Evaluation->setLevel_code(null);
            }
            if (strlen($request->getParameter('cmbComService'))) {
                $Evaluation->setService_code(trim($request->getParameter('cmbComService')));
            } else {
                $Evaluation->setService_code(null);
            }
            if (strlen($request->getParameter('txtProjectCode'))) {
                $Evaluation->setEval_dtl_project_percentage(trim($request->getParameter('txtProjectCode')));
            } else {
                $Evaluation->setEval_dtl_project_percentage(null);
            }
            if (strlen($request->getParameter('txtDutieCode'))) {
                $Evaluation->setEval_dtl_duty_percentage(trim($request->getParameter('txtDutieCode')));
            } else {
                $Evaluation->setEval_dtl_duty_percentage(null);
            }

            $Evaluation->save();
//            die(print_r($_POST));
            $lastid = $performanceService->getLastEvaluationID();
            $saveEvalId = current(reset($lastid));

            //Save Job Role
            $jobroles = $request->getParameter('jobrole[]');
            $eval_id = $request->getParameter('txtHiddenReqID');
            $deleteJobRoleList = $performanceService->getEvaluationJobRoleList($eval_id);

            $conn = Doctrine_Manager::getInstance()->connection();
            $conn->beginTransaction();
            $PerformanceDao= new PerformanceDao();
            //delete assign Jobrole
            if ($eval_id != null) {   
            foreach ($deleteJobRoleList as $Role) {
                $PerformanceDao->deleteJobRole($eval_id, $Role->jrl_id);
            }
            }
            //Save Job Role 
            for ($i = 0; $i < count($jobroles); $i++) {//die(print_r($saveEvalId."*".$jobroles[$i]));
                $PerformanceDao->deleteJobRole($saveEvalId, $jobroles[$i]);
                $EvaluationJobrole = new PerformanceEvaluationJobRole();
                $EvaluationJobrole->setEval_dtl_id($saveEvalId);
                $EvaluationJobrole->setJrl_id($jobroles[$i]);
                $performanceService->saveJobRole($EvaluationJobrole);
            }
            $conn->commit();

            //Save Duty List
            $ids = array();
            $DutyWeightages = array();
            $deleteDutys = array();
            $AssignDutyIds = array();

            $ids = $request->getParameter('chkLocID[]');
            $DutyWeightages = $request->getParameter('DutyWeightage[]');

            foreach ($this->AssignDutyList as $AssignDuty) {
                array_push($AssignDutyIds, $AssignDuty['dut_id']);
            }

            $deleteDutys = array_diff($AssignDutyIds, $ids);

            //delete uncelect Dutys
            if (count($ids) == 0) {
                foreach ($AssignDutyIds as $deleteDuty) {
                    $PerformanceSaveDao->deleteAssignDuty($requestId, $deleteDuty);
                }
            } else {
                foreach ($deleteDutys as $deleteDuty) {
                    $PerformanceSaveDao->deleteAssignDuty($requestId, $deleteDuty);
                }
            }

            if (count($ids) > 0 && count($DutyWeightages) > 0) {

                $conn = Doctrine_Manager::getInstance()->connection();
                $conn->beginTransaction();


                for ($i = 0; $i < count($ids); $i++) {
                    if (in_array("$ids[$i]", $AssignDutyIds)) {
                        $PerformanceSaveDao->deleteAssignDuty($saveEvalId, $ids[$i]);
                        $EvaluationDuty = $performanceService->readAssignDuty($saveEvalId, $ids[$i]);
                        if($EvaluationDuty->eval_dtl_id!= null && $EvaluationDuty->dut_id!= null ){
                        $EvaluationDuty->setDut_weightage($DutyWeightages[$i]);
                        $performanceService->savePerformanceEvaluationDuty($EvaluationDuty);
                        }else{
                        $EvaluationDuty = new PerformanceEvaluationDuty();
                        $EvaluationDuty->setEval_dtl_id($saveEvalId);
                        $EvaluationDuty->setDut_id($ids[$i]);
                        $EvaluationDuty->setDut_weightage($DutyWeightages[$i]);
                        $performanceService->savePerformanceEvaluationDuty($EvaluationDuty);
                        }
                    } else {
                        $EvaluationDuty = new PerformanceEvaluationDuty();
                        $EvaluationDuty->setEval_dtl_id($saveEvalId);
                        $EvaluationDuty->setDut_id($ids[$i]);
                        $EvaluationDuty->setDut_weightage($DutyWeightages[$i]);
                        $performanceService->savePerformanceEvaluationDuty($EvaluationDuty);
                    }
                    //$performanceService->savePerformanceEvaluationDuty($EvaluationDuty);
                }
                $conn->commit();
            }
            } catch (Doctrine_Connection_Exception $e) {
                $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('performance/Evaluation');
            } catch (sfStopException $e) {

            } catch (Exception $e) {
                $conn->rollBack();
                $errMsg = new CommonException($e->getMessage(), $e->getCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('performance/Evaluation');
            }
            if (strlen($requestId)) {
                $this->setMessage('SUCCESS', array($this->getContext()->geti18n()->__('Successfully Updated')));
                $this->redirect('performance/SaveEvaluation?id=' . $requestId . '?lock=0');
            } else {
                $this->setMessage('SUCCESS', array($this->getContext()->geti18n()->__('Successfully Saved.')));
                $this->redirect('performance/Evaluation');
            }
        }
    }

    /*
     *  Delete Evaluation 
     */

    public function executeDeleteEvaluation(sfWebRequest $request) {
        if (count($request->getParameter('chkLocID')) > 0) {
             $performanceServiceSave=new PerformanceSaveService();
              $performanceService = new PerformanceService();
            try {
                $conn = Doctrine_Manager::getInstance()->connection();
                $conn->beginTransaction();
                $ids = array();
                $ids = $request->getParameter('chkLocID');

                $countArr = array();
                $saveArr = array();
                for ($i = 0; $i < count($ids); $i++) {
                    $conHandler = new ConcurrencyHandler();
                    $Field = explode("_", $ids[$i]);

                    $isRecordLocked = $conHandler->isTableLocked('hs_hr_perf_evaluation_detail', array(trim($Field[0]), $Field[1]), 1);
                    if ($isRecordLocked) {
                        $countArr = $ids[$i];
                    } else {
                        $saveArr = $ids[$i];
                        $readEvaluation = $performanceService->readEvaluation($Field[0], $Field[1]);

                        $assignJobRole = $performanceService->getEvaluationJobRoleList($readEvaluation->eval_dtl_id);
                        if (count($assignJobRole) > 0) {
                            foreach ($assignJobRole as $jobRole) {
                                $performanceServiceSave->deleteJobRole($readEvaluation->eval_dtl_id, $jobRole->jrl_id);
                            }
                        }
                        $assignDutylist = $performanceService->getEvaluationAssignDutyList($readEvaluation->eval_dtl_id);
                        if (count($assignDutylist) > 0) {
                            foreach ($assignDutylist as $assignDuty) {
                                $performanceServiceSave->deleteAssignDuty($ids[$i], $assignDuty->dut_id);
                            }
                            $performanceServiceSave->deleteEvaluation($Field[0], $Field[1]);
                        }
                        $conHandler->resetTableLock('hs_hr_perf_evaluation_detail', array(trim($Field[0]), $Field[1]), 1);
                    }
                }

                $conn->commit();
            } catch (Doctrine_Connection_Exception $e) {
                $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('performance/Evaluation');
            } catch (Exception $e) {
                $conn->rollBack();
                $errMsg = new CommonException($e->getMessage(), $e->getCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('performance/Evaluation');
            }
            if (count($saveArr) > 0 && count($countArr) == 0) {
                $this->setMessage('SUCCESS', array($this->getContext()->getI18N()->__("Successfully Deleted", $args, 'messages')));
            } elseif (count($saveArr) > 0 && count($countArr) > 0) {
                $this->setMessage('WARNING', array($this->getContext()->getI18N()->__("Some records are can not be deleted as them  Locked by another user ", $args, 'messages')));
            } elseif (count($saveArr) == 0 && count($countArr) > 0) {
                $this->setMessage('WARNING', array($this->getContext()->getI18N()->__("Can not delete as them  Locked by another user ", $args, 'messages')));
            }
        } else {
            $this->setMessage('NOTICE', array('Select at least one record to delete'));
        }
        $this->redirect('performance/Evaluation');
    }

    public function executeDeleteAssingEmployee(sfWebRequest $request) {
        if (count($request->getParameter('chkLocID')) > 0) {
            $performanceService = new PerformanceService();
            $performanceSearchService = new PerformanceSearchService();
            try {
                $conn = Doctrine_Manager::getInstance()->connection();
                $conn->beginTransaction();
                $ids = array();
                $ids = $request->getParameter('chkLocID');

                $countArr = array();
                $saveArr = array();
                for ($i = 0; $i < count($ids); $i++) {
                    $conHandler = new ConcurrencyHandler();
                    $Field = explode("_", $ids[$i]);

                    $isRecordLocked = $conHandler->isTableLocked('hs_hr_perf_eval_employee', array(trim($Field[0]), $Field[1]), 1);
                    if ($isRecordLocked) {

                        $countArr = $ids[$i];
                    } else {
                        $saveArr = $ids[$i];
                        $EmployeeData = $performanceService->readEmployee($Field[0]);
                        $JobTitle = $EmployeeData->job_title_code;
                        $Level = $EmployeeData->level_code;
                        $Service = $EmployeeData->service_code;
                        $EvaluationDtlID = $performanceService->readEvalDetailID($JobTitle, $Level, $Service, $Field[1]);
                        $performanceSearchService->deleteEmployeeProject($EvaluationDtlID->eval_dtl_id, $Field[0]);
                        $performanceSearchService->deleteEmployeeDuty($EvaluationDtlID->eval_dtl_id, $Field[0]);
                        $performanceSearchService->deleteAssingEmployee($Field[0], $Field[1]);
                        $conHandler->resetTableLock('hs_hr_perf_eval_employee', array(trim($Field[0]), $Field[1]), 1);
                    }
                }

                $conn->commit();
            } catch (Doctrine_Connection_Exception $e) {
                $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('performance/AssingEmployee');
            } catch (Exception $e) {
                $conn->rollBack();
                $errMsg = new CommonException($e->getMessage(), $e->getCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('performance/AssingEmployee');
            }
            if (count($saveArr) > 0 && count($countArr) == 0) {
                $this->setMessage('SUCCESS', array($this->getContext()->getI18N()->__("Successfully Deleted", $args, 'messages')));
            } elseif (count($saveArr) > 0 && count($countArr) > 0) {
                $this->setMessage('WARNING', array($this->getContext()->getI18N()->__("Some records are can not be deleted as them  Locked by another user ", $args, 'messages')));
            } elseif (count($saveArr) == 0 && count($countArr) > 0) {
                $this->setMessage('WARNING', array($this->getContext()->getI18N()->__("Can not delete as them  Locked by another user ", $args, 'messages')));
            }
        } else {
            $this->setMessage('NOTICE', array('Select at least one record to delete'));
        }
        $this->redirect('performance/AssingEmployee');
    }

    //SDO Evaluation
    public function executeSDOEvaluation(sfWebRequest $request) {
        if (strlen($request->getParameter('empNumber'))) {

            $empNumber = $request->getParameter('empNumber');

            $_SESSION['PIM_EMPID'] = $empNumber;
        } elseif (strlen($_SESSION['PIM_EMPID'])) {
            
        } else {
            if (strlen($_SESSION['empNumber'])) {
                $_SESSION['PIM_EMPID'] = $_SESSION['empNumber'];
            }
        }

        if ($_SESSION['user'] == "USR001") {
            $this->setMessage('WARNING', array($this->getContext()->getI18N()->__("Admin Not Allow to Perform Evaluation.", $args, 'messages')));
            $this->redirect('pim/list');
        }

        $this->Culture = $this->getUser()->getCulture();
        $employee = $_SESSION['empNumber'];
        $this->empNo=$employee;
        $performanceService = new PerformanceService();
         $performanceSearchService = new PerformanceSearchService();
        $EmployeeData = $performanceService->readEmployee($employee);
        $this->subordinates = $performanceService->LoadsubordinateData($EmployeeData->getEmp_number());
        $this->SuperviserAllow = $performanceService->LoadSuperviserAllowEvaluation($EmployeeData->getEmp_number());
        if ($this->SuperviserAllow[0] == null) {
            $this->setMessage('WARNING', array($this->getContext()->getI18N()->__("You are not assigned as a supervisor for any evaluation.", $args, 'messages')));
            $this->redirect('default/error');
        }

        $this->Culture = $this->getUser()->getCulture();
        $this->EvaluationList = $performanceService->getEvaluationList();
        $this->EvaluationTypeList = $performanceService->getEvaluationTypeList();
        try {
            $this->Culture = $this->getUser()->getCulture();
            $performanceService = new PerformanceService();

            $this->sorter = new ListSorter('SDOEvaluation', 'performance', $this->getUser(), array('e.emp_number', ListSorter::ASCENDING));
            $this->sorter->setSort(array($request->getParameter('sort'), $request->getParameter('order')));

            $this->searchEvaluation = ($request->getParameter('cmbbtype') == null) ? $request->getParameter('searchEvaluation') : $request->getParameter('cmbbtype');
            $this->searchEvaluationType = ($request->getParameter('cmbEtype') == null) ? $request->getParameter('searchEvaluationType') : $request->getParameter('cmbEtype');
            $this->searchMode = ($request->getParameter('searchMode') == null) ? 'all' : $request->getParameter('searchMode');
            $this->searchValue = ($request->getParameter('searchValue') == null) ? '' : $request->getParameter('searchValue');
            $this->YEAR = ($request->getParameter('txtYear') == null) ? $request->getParameter('txtYear') : $request->getParameter('txtYear');
            $this->sort = ($request->getParameter('sort') == '') ? 'e.emp_number' : $request->getParameter('sort');
            $this->order = ($request->getParameter('order') == '') ? 'ASC' : $request->getParameter('order');
            $res = $performanceSearchService->searchSDOEvaluation($this->searchMode, $this->searchValue, $this->Culture, $this->sort, $this->order, $request->getParameter('page'), $this->searchEvaluation, $this->searchEvaluationType);
            $this->AssingEmployeeList = $res['data'];
            //die(print_r($res['data']));
            $this->pglay = $res['pglay'];
            $this->pglay->setTemplate('<a href="{%url}">{%page}</a>');
            $this->pglay->setSelectedTemplate('{%page}');
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
            $this->redirect('default/error');
        }
    }

    public function executeUpdateSDOEvaluation(sfWebRequest $request) {
        //Table Lock code is Open

        $encrypt = new EncryptionHandler();
        if (!strlen($request->getParameter('lock'))) {
            $this->lockMode = 0;
        } else {
            $this->lockMode = $request->getParameter('lock');
        }
        $PGID = $encrypt->decrypt($request->getParameter('id'));
        if (isset($this->lockMode)) {
            if ($this->lockMode == 1) {

                $conHandler = new ConcurrencyHandler();

                $recordLocked = $conHandler->setTableLock('hs_hr_perf_duty', array($PGID), 1);

                if ($recordLocked) {
                    // Display page in edit mode
                    $this->lockMode = 1;
                } else {
                    $this->setMessage('WARNING', array($this->getContext()->getI18N()->__('Can not update. Record locked by another user.', $args, 'messages')), false);
                    $this->lockMode = 0;
                }
            } else if ($this->lockMode == 0) {
                $conHandler = new ConcurrencyHandler();
                $conHandler->resetTableLock('hs_hr_perf_duty', array($PGID), 1);
                $this->lockMode = 0;
            }
        }
        //Table lock code is closed
        $this->myCulture = $this->getUser()->getCulture();
        $performanceService = new PerformanceService();
        $SDOEvaluation = $performanceService->readSDOEvaluation($PGID);
        $this->SDOEvaluation = $SDOEvaluation;
        if (!$SDOEvaluation) {
            $this->setMessage('WARNING', array($this->getContext()->getI18N()->__('Can not update. Record has been Deleted', $args, 'messages')));
            $this->redirect('performance/SDOEvaluation');
        }
        if ($SDOEvaluation->eval_emp_status == 2) {
            $this->setMessage('SUCCESS', array($this->getContext()->getI18N()->__('Sucessfully Completed Performance', $args, 'messages')));
        }
        $exploed = explode("_", $PGID);
        $this->RateList = $performanceService->readRateList();

        $this->DutyGroupList = $performanceService->readDutyGroupList();
        if ($SDOEvaluation->eval_type_id == 1) {
            $this->ProjectList = $performanceService->readProjectList($exploed[0]);
        }
        if ($SDOEvaluation->eval_type_id == 2) {
            $this->SDOEMPList = $performanceService->readSDOEMPList($exploed[1], $exploed[0]);
        }

        $EmpNumber = $exploed[0];
        $EmployeeData = $performanceService->readEmployee($EmpNumber);
        $JobTitle = $EmployeeData->job_title_code;
        $Level = $EmployeeData->level_code;
        $Service = $EmployeeData->service_code;
        $this->EvaluationDtlID = $performanceService->readEvalDetailID($JobTitle, $Level, $Service, $exploed[1]);
        $this->DutyList = $performanceService->readEvalDutyList($this->EvaluationDtlID->eval_dtl_id);

        if ($request->isMethod('post')) {//die(print_r($_POST));
            $conn = Doctrine_Manager::getInstance()->connection();
            $conn->beginTransaction();

            if ($this->EvaluationDtlID->eval_dtl_id) {
                $SDOEvaluation->setEval_dtl_id($this->EvaluationDtlID->eval_dtl_id);
            } else {
                $SDOEvaluation->setEval_dtl_id(null);
            }
            if ($SDOEvaluation->eval_type_id == 1) {
                if (strlen($request->getParameter('txtProjectEvaluationRating'))) {
                    $SDOEvaluation->setEval_emp_project_rate(trim($request->getParameter('txtProjectEvaluationRating')));
                } else {
                    $SDOEvaluation->setEval_emp_project_rate(null);
                }
            }
            if ($SDOEvaluation->eval_type_id == 2) {
                if (strlen($request->getParameter('txtSDOProjectEvaluationRating'))) {
                    $SDOEvaluation->setEval_emp_project_rate(trim($request->getParameter('txtSDOProjectEvaluationRating')));
                } else {
                    $SDOEvaluation->setEval_emp_project_rate(null);
                }
            }


            if (strlen($request->getParameter('txtDutyEvaluationRating'))) {
                $SDOEvaluation->setEval_emp_duty_rate(trim($request->getParameter('txtDutyEvaluationRating')));
            } else {
                $SDOEvaluation->setEval_emp_duty_rate(null);
            }
            if (strlen($request->getParameter('txtComment'))) {
                $SDOEvaluation->setEval_emp_duty_comment(trim($request->getParameter('txtComment')));
            } else {
                $SDOEvaluation->setEval_emp_duty_comment(null);
            }
            if (strlen($request->getParameter('txtFinalRate'))) {
                $SDOEvaluation->setEval_emp_overall_rate(trim($request->getParameter('txtFinalRate')));
            } else {
                $SDOEvaluation->setEval_emp_overall_rate(null);
            }
            if (strlen($request->getParameter('txtFinalGrade'))) {
                $SDOEvaluation->setEval_emp_overall_grade(trim($request->getParameter('txtFinalGrade')));
            } else {
                $SDOEvaluation->setEval_emp_overall_grade(null);
            }
            if (strlen($request->getParameter('txtOverallComment'))) {
                $SDOEvaluation->setEval_emp_overall_comment(trim($request->getParameter('txtOverallComment')));
            } else {
                $SDOEvaluation->setEval_emp_overall_comment(null);
            }
            if (strlen($request->getParameter('txtStatus'))) {
                $SDOEvaluation->setEval_emp_status(trim($request->getParameter('txtStatus')));
            } else {
                $SDOEvaluation->setEval_emp_status(null);
            }

            try {

                $performanceService->saveSDOEvaluation($SDOEvaluation);

                $exploed = array();
                $count_rows = array();

                foreach ($_POST as $key => $value) {


                    $exploed = explode("_", $key);


                    if (strlen($exploed[1])) {

                        $count_rows[] = $exploed[1];

                        $arrname = "a_" . $exploed[1];

                        if (!is_array($$arrname)) {
                            $$arrname = Array();
                        }

                        ${$arrname}[$exploed[0]] = $value;
                    }
                }

                $uniqueRowIds = array_unique($count_rows);
                $uniqueRowIds = array_values($uniqueRowIds);

                for ($i = 0; $i < count($uniqueRowIds); $i++) {
                    $v = "a_" . $uniqueRowIds[$i];

//Save Project Rates Deatils
                    if (strlen(${$v}[txtPrjId])) {
                        $performanceService->deleteEvaluationEmployeeProject($this->EvaluationDtlID->eval_dtl_id, $EmpNumber, ${$v}[txtPrjId]);

                        $EmployeeProject = new PerformanceEvaluationEmployeeProject();
                        $EmployeeProject->setEval_dtl_id($this->EvaluationDtlID->eval_dtl_id);
                        $EmployeeProject->setEmp_number($EmpNumber);


                        if (!strlen(${$v}[txtPrjId])) {
                            $EmployeeProject->setEval_prj_id(null);
                        } else {
                            $EmployeeProject->setEval_prj_id(${$v}[txtPrjId]);
                        }
                        if (!strlen(${$v}[txtPrjweitage])) {

                            $EmployeeProject->setEval_prj_weight(null);
                        } else {
                            $EmployeeProject->setEval_prj_weight(${$v}[txtPrjweitage]);
                        }
                        if (!strlen(${$v}[txtPrjcomment])) {

                            $EmployeeProject->setEval_prj_comment(null);
                        } else {
                            $EmployeeProject->setEval_prj_comment(${$v}[txtPrjcomment]);
                        }

                        $performanceService->savePerformanceEvaluationEmployeeProject($EmployeeProject);
                    }

                    //Save SDO Project Rates Deatils
                    if (strlen(${$v}[txtSDOPrj])) {

                        if (${$v}[txtSDOPrjEmp]) {

                            $EmployeeData = $performanceService->readEmployee(${$v}[txtSDOPrjEmp]);
                            $JobTitle = $EmployeeData->job_title_code;
                            $Level = $EmployeeData->level_code;
                            $Service = $EmployeeData->service_code;
                            $EvaluationDtlID = $performanceService->readEvalDetailID($JobTitle, $Level, $Service, $this->EvaluationDtlID->eval_id);
                            $ProjectEmployee = $performanceService->getEvaluationSDO($SDOEvaluation->eval_id, "1", ${$v}[txtSDOPrjEmp], $EvaluationDtlID->eval_dtl_id);
                            if (!strlen(${$v}[txtSDOSugestRate])) {
                                $ProjectEmployee->setEval_emp_sujested_overall_rate(null);
                            } else {
                                $ProjectEmployee->setEval_emp_sujested_overall_rate(${$v}[txtSDOSugestRate]);
                            }
                            if (!strlen(${$v}[txtSDOComment])) {

                                $ProjectEmployee->setEval_emp_sujested_overall_rate_comment(null);
                            } else {
                                $ProjectEmployee->setEval_emp_sujested_overall_rate_comment(${$v}[txtSDOComment]);
                            }

                            $performanceService->saveSDOEvaluation($ProjectEmployee);
                        }
                    }


//Save Duty Rates Details
                    //$performanceDao->deletePerformanceEvaluationEmployeeDuty($this->EvaluationDtlID->eval_dtl_id,$EmpNumber,${$v}[txtDuty]);
                    if (strlen(${$v}[txtDuty])) {
                        $performanceService->deletePerformanceEvaluationEmployeeDuty($this->EvaluationDtlID->eval_dtl_id, $EmpNumber, ${$v}[txtDuty]);
                        $EmployeeDuty = new PerformanceEvaluationEmployeeDuty();
                        $EmployeeDuty->setEval_dtl_id($this->EvaluationDtlID->eval_dtl_id);
                        $EmployeeDuty->setEmp_number($EmpNumber);
                        $EmployeeDuty->setDut_id(${$v}[txtDuty]);

                        if (!strlen(${$v}[cmbRate])) {

                            $EmployeeDuty->setEval_duty_rate(null);
                        } else {
                            $EmployeeDuty->setEval_duty_rate(${$v}[cmbRate]);
                        }
                        if (!strlen(${$v}[txtDutycomment])) {

                            $EmployeeDuty->setEval_duty_comment(null);
                        } else {
                            $EmployeeDuty->setEval_duty_comment(${$v}[txtDutycomment]);
                        }

                        $performanceService->savePerformanceEvaluationEmployeeDuty($EmployeeDuty);
                    }
                }

                $conn->commit();
            } catch (Doctrine_Connection_Exception $e) {
                $conn->rollBack();
                $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('performance/UpdateSDOEvaluation?id=' . $encrypt->encrypt($SDOEvaluation->emp_number . '_' . $SDOEvaluation->eval_id) . '&lock=0');
            } catch (sfStopException $e) {
                
            } catch (Exception $e) {
                $conn->rollBack();
                $errMsg = new CommonException($e->getMessage(), $e->getCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('performance/UpdateSDOEvaluation?id=' . $encrypt->encrypt($SDOEvaluation->emp_number . '_' . $SDOEvaluation->eval_id) . '&lock=0');
            }
            if ($request->getParameter('txtStatus') == 2) {
                $this->setMessage('SUCCESS', array($this->getContext()->getI18N()->__("Successfully Sumbited", $args, 'messages')));
            } else {
                $this->setMessage('SUCCESS', array($this->getContext()->getI18N()->__("Successfully Updated", $args, 'messages')));
            }

            $this->redirect('performance/UpdateSDOEvaluation?id=' . $encrypt->encrypt($SDOEvaluation->emp_number . '_' . $SDOEvaluation->eval_id) . '&lock=0');
        }
    }

    public function executeAjaxRateDetails(sfWebRequest $request) {

        $id = $request->getParameter('id');
        $performanceService = new PerformanceService();
        $RateDetails = $performanceService->readRateDetails($id);
        $option = "";
        foreach ($RateDetails as $Rate) {
            $option.="<option value='" . $Rate->rdt_mark . "'>" . $Rate->rdt_grade . "</option>";
        }


        echo json_encode($option);
        die;
    }

    public function executeAjaxProjectWeightComment(sfWebRequest $request) {

        $id = $request->getParameter('id');
        $Empno = $request->getParameter('Empno');
        $EvalId = $request->getParameter('EvalId');
        $performanceService = new PerformanceService();
        $ProjectDetails = $performanceService->readProjectDetails($id, $Empno, $EvalId);
        echo json_encode(Array("Weight" => $ProjectDetails['eval_prj_weight'], "Comment" => $ProjectDetails['eval_prj_comment']));
        die;
    }

    public function executeAjaxSDOProjectRateComment(sfWebRequest $request) {

        $Empno = $request->getParameter('empno');
        $EvalId = $request->getParameter('EvalId');
        $performanceService = new PerformanceService();
        $EmployeeData = $performanceService->readEmployee($Empno);
        $JobTitle = $EmployeeData->job_title_code;
        $Level = $EmployeeData->level_code;
        $Service = $EmployeeData->service_code;
        $EvaluationDtlID = $performanceService->readEvalDetailID($JobTitle, $Level, $Service, $EvalId);

        $SDODetails = $performanceService->SDOProjectRateComment($EvaluationDtlID->eval_dtl_id, $Empno, $EvalId);
        echo json_encode(Array("Rate" => $SDODetails['eval_emp_project_rate'], "SuggestedRate" => $SDODetails['eval_emp_sujested_overall_rate'], "Comment" => $SDODetails['eval_emp_sujested_overall_rate_comment'], "Status" => $SDODetails['eval_emp_status']));
        die;
    }

    public function executeAjaxDutyRateComment(sfWebRequest $request) {

        $id = $request->getParameter('id');
        $Empno = $request->getParameter('Empno');
        $EvalId = $request->getParameter('EvalId');
        $performanceService = new PerformanceService();
        $DutyDetails = $performanceService->readDutyRateComment($id, $Empno, $EvalId);
        echo json_encode(Array("Rate" => $DutyDetails['eval_duty_rate'], "Comment" => $DutyDetails['eval_duty_comment']));
        die;
    }

    public function executeAjaxFinalEvaluationCalculation(sfWebRequest $request) {

        $EvalDtlID = $request->getParameter('EvalDtlID');
        $ProjectEval = $request->getParameter('ProjectEval');
        $DutyEval = $request->getParameter('DutyEval');
        $Evaltype = $request->getParameter('Evaltype');
        $performanceService = new PerformanceService();
        $RateDetails = $performanceService->readEvaluation($EvalDtlID);
        $PerformanceDao=new PerformanceDao();
        if ($Evaltype == 3) {
            $FinalRate = $DutyEval;
        } else {
            $FinalProjectEval = ($ProjectEval * $RateDetails->eval_dtl_project_percentage) / 100;
            $FinalDutyEval = ($DutyEval * $RateDetails->eval_dtl_duty_percentage) / 100;
            $FinalRate = $FinalProjectEval + $FinalDutyEval;
        }

        $Rates = $PerformanceDao->readRateDetailList($RateDetails->PerformanceEvaluation->rate_id,$RateDetails->PerformanceEvaluation->PerformanceRate->rate_option);
        $Marks = array();
        foreach ($Rates as $row => $key) {
            $Marks[$row][0] = $key[rdt_mark];
            $Marks[$row][1] = $key[rdt_grade];
            $Marks[$row][2] = $key[rdt_description];
        }

        for ($i = 0; $i < count($Rates); $i++) {
            if ($FinalRate >= $Rates[$i]['rdt_mark']) {
                $FinalGrade = $Rates[$i]['rdt_grade'];
                $FinalDesc = $Rates[$i]['rdt_description'];
                break;
            }
        }
        if ($FinalGrade == null && $FinalDesc == null) {
            
            $FinalGrade = $Rates[$i]['rdt_grade'];
            $FinalDesc = $Rates[$i]['rdt_description'];
        }


        echo json_encode(Array("FinalRate" => $FinalRate, "FinalGrade" => $FinalGrade, "FinalDesc" => $FinalDesc));
        die;
    }

//Assign Supervisor
    public function executeSaveSupervisor(sfWebRequest $request) {
        $performanceService = new PerformanceService();
        $this->Culture = $this->getUser()->getCulture();
        $this->EvaluationList = $performanceService->getEvaluationList();
        $this->EvaluationTypeList = $performanceService->getEvaluationTypeList();
        $this->EVID = $request->getParameter('cmbbtype');
        $this->ETID = $request->getParameter('cmbEtype');
        try {
            if ($request->isMethod('post')) {//die(print_r($_POST));
//                $conn = Doctrine_Manager::getInstance()->connection();
//                $conn->beginTransaction();
                $j=0;
                $Supervisor = $performanceService->readEvaluationSupervisor($request->getParameter('cmbbtype'), $request->getParameter('txtSupEmpId'));

                    $exploed = array();
                    $count_rows = array();
                    foreach ($_POST as $key => $value) {


                        $exploed = explode("_", $key);

                        if (strlen($exploed[1])) {
                            $count_rows[] = $exploed[1];

                            $arrname = "a_" . $exploed[1];

                            if (!is_array($$arrname)) {
                                $$arrname = Array();
                            }

                            ${$arrname}[$exploed[0]] = $value;
                        }
                    }



                    $uniqueRowIds = array_unique($count_rows);
                    $uniqueRowIds = array_values($uniqueRowIds);

//
                    $conn = Doctrine_Manager::getInstance()->connection();
                    $conn->beginTransaction();
                 
                    $performanceService->deleteEmpSupEval($this->EVID,$this->ETID);
                    for ($i = 0; $i < count($uniqueRowIds); $i++) {

                        $supEvalObj= new PerformanceEvaluationSupervisor();
                        $v = "a_" . $uniqueRowIds[$i];
//                        die(${$v}[hiddneSupID]);
                        $supEvalObj->setEval_id($this->EVID);

                        $supEvalObj->setEmp_number(${$v}[hiddneEmpID]);
                        $supEvalObj->setEval_type_id($this->ETID);

                        if(strlen(${$v}[hiddneSupID])){
                         $supEvalObj->setSup_num(${$v}[hiddneSupID]); 
                         //--
                         $EmployeeData = $performanceService->readEmployee(${$v}[hiddneEmpID]);
                        $JobTitle = $EmployeeData->job_title_code;
                        $Level = $EmployeeData->level_code;
                        $Service = $EmployeeData->service_code;
                        $EvaluationDtlID = $performanceService->readEvalDetailID($JobTitle, $Level, $Service, $this->EVID);
                        $EvalEmployee = $performanceService->SDOEmployee($EvaluationDtlID->eval_dtl_id, ${$v}[hiddneEmpID], $request->getParameter('cmbbtype'));
                        if ($EvalEmployee->emp_number == null) {
                            $this->setMessage('WARNING', array($this->getContext()->getI18N()->__("Please Assign Evaluation to Subordinate Employee", $args, 'messages')));
                            $this->redirect('performance/SaveSupervisor');
                        } else { 
                            $EvalEmployee->setSup_emp_number(${$v}[hiddneSupID]);
                        }                        
                        if (${$v}[hiddneSupID] != null && $EvaluationDtlID->eval_dtl_id != null) { 
                            $EvalEmployee->save();
                            //$performanceService->saveEvaluationEmpList($EvalEmployee);
                        }
                         //--
                        }
                        else{
                         $supEvalObj->setSup_num(null);
                         $j++;
                        }
                        $supEvalObj->setEval_sup_flag(${$v}[hiddneFlag]);

                        $supEvalObj->save();
                    }
                 $conn->commit();

                 if($j=="0"){
                $this->setMessage('SUCCESS', array($this->getContext()->getI18N()->__("Successfully Saved", $args, 'messages')));
                $this->redirect('performance/SaveSupervisor?cmbbtype='.$request->getParameter('cmbbtype').'&cmbEtype='.$request->getParameter('cmbEtype'));
                 }else{
                    $this->setMessage('WARNING', array($this->getContext()->getI18N()->__("Some employees are not assigned supervisors", $args, 'messages')));
                    //$this->redirect('performance/SaveSupervisor'); 
                    $this->redirect('performance/SaveSupervisor?cmbbtype='.$request->getParameter('cmbbtype').'&cmbEtype='.$request->getParameter('cmbEtype'));
                 }
            }
        } catch (sfStopException $sf) {
            
        } catch (Doctrine_Connection_Exception $e) {
            $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
            $this->setMessage('WARNING', $errMsg->display());
            $this->redirect('performance/SaveSupervisor');
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
            $this->redirect('performance/SaveSupervisor');
        }
    }

    public function executeSubordinateEmployee(sfWebRequest $request) {

        $performanceService = new PerformanceService();
        $EVid = $request->getParameter('EVid');
        $id = $request->getParameter('id');
        $Empnum = $request->getParameter('Empnum');
        if ($id == 0) {
            $Subordinate = $performanceService->LoadsubordinateData($Empnum);
            foreach ($Subordinate as $emp) {
                if ($Subordinate[0] == $emp) {
                    $Employee.=$emp['subordinateId'];
                } else {
                    $Employee.="|" . $emp['subordinateId'];
                }
            }
        } else {
            $emplist = $performanceService->getEvaluationSavedEmpList($EVid, $Empnum);
            foreach ($emplist as $emp) {
                if ($emplist[0] == $emp) {
                    $Employee.=$emp['emp_number'];
                } else {
                    $Employee.="|" . $emp['emp_number'];
                }
            }
        }


        echo json_encode($Employee);
        die;
    }

    public function executeAjaxRemoveSupervisor(sfWebRequest $request) {

        $EVid = $request->getParameter('EVid');
        $Enum = $request->getParameter('Enum');
        $ESup = $request->getParameter('ESup');
        $performanceService = new PerformanceService();
        $EvalEmployee = $performanceService->readAjaxSupervisor($EVid, $Enum, $ESup);
        if ($EvalEmployee) {
            $EvalEmployee->setSup_emp_number(null);
            if ($performanceService->saveEvaluationEmpList($EvalEmployee)) {
                $message = "1";
            }
        } else {
            $message = "0";
        }
        echo json_encode($message);
        die;
    }

    public function executeEmployeeAssignDuty(sfWebRequest $request) {

        $performanceService = new PerformanceService();
        $Eid = $request->getParameter('Eid');
        $Did = $request->getParameter('Did');

        $employerAssignDuty = $performanceService->getEmployerAssignDuty($Eid, $Did);

        if (count($employerAssignDuty) > 0) {
            echo json_encode("true");
        } else {
            echo json_encode("false");
        }
        die;
    }

    public function executeEmployeeAssignEvaluation(sfWebRequest $request) {

        $performanceService = new PerformanceService();
        $Eid = $request->getParameter('Eid');
        $employerAssignDuty = $performanceService->getEmployerAssignDuty($Eid);

        if (count($employerAssignDuty) > 0) {
            echo json_encode("true");
        } else {
            echo json_encode("false");
        }
        die;
    }

    public function executeAjaxloadJobRoleList(sfWebRequest $request) {
        $this->Culture = $this->getUser()->getCulture();
        $level_code = $request->getParameter('level_code');
        $service_code = $request->getParameter('service_code');
        $designation_code = $request->getParameter('designation_code');

        $performanceService = new PerformanceService();
        $this->jobRoleList = $performanceService->getJobRoleList($designation_code, $level_code, $service_code, 1);
        $arr = array();

        foreach ($this->jobRoleList as $row) {
            $n = "jrl_name_" . $Culture;
            if ($row[$n] == null) {
                $n = "jrl_name";
            } else {
                $n = "jrl_name_" . $Culture;
            }
            $arr[$row['jrl_id']] = $row[$n];
        }
        echo json_encode($arr);
        die;
    }
    
        public function executeEmployeeProjectWebService(sfWebRequest $request) {

        $EMPNO = $request->getParameter('empno');    
        $Year = $request->getParameter('year'); 
        $performanceDao= new PerformanceDao();
        $EmployeeData = $performanceDao->readEmployeeEID($EMPNO);
        if($EMPNO!=null && $Year!= null){
        $sysConf=new sysConf();

        $Status=$sysConf->getEmployeeProjectWebServiceStatus();

        if($Status=="ON"){
            
            
        $coords = Struct::factory('employeeId','financialYear');
        $lat1 = $coords->create($EMPNO,$Year);
        //$coords = Struct::factory('employeeId');
        //$lat2 = $coords->create('6');
        //$coords = Struct::factory('locationId','financialYear');
        //$lat3 = $coords->create('42','2011');
        //$coords = Struct::factory('beneficiaryId','financialYear');
        //$lat4 = $coords->create('6','2011');

        try {
    $client = new soapclient($sysConf->getEmployeeProjectWebServiceUrl());
    $setLocation=$sysConf->getEmployeeProjectWebServiceUrlSetLocation();
    $client->__setLocation($setLocation);
    $OutResult = $client->getProjectProgressStatusForEmployee($lat1);
//    die(print_r($OutResult));
    //$OutResult = $client->getPPMAccesibility($lat2);
    //$OutResult = $client->getProjectCountForLocation($lat3);
    //$OutResult = $client->getProjectDetailsOfBeneficiary($lat4);
    $performanceDao = new PerformanceDao();
       if($OutResult!=null){ $i=0;
           foreach($OutResult as $row){               
               foreach($row as $row1){ $i; //print_r($i."<br/>");
               foreach($row1 as $row2 => $value2){ 
                if($row2=="charterCode"){
                    $PerformanceEvaluationProject=$performanceDao->readProjectByUserCode($value2);   
                    if($PerformanceEvaluationProject->eval_prj_user_code==null){
                        $PerformanceEvaluationProject= new PerformanceEvaluationProject();
                        $PerformanceEvaluationProject->setEval_prj_user_code($value2);
                    }
                }
                if($row2=="title"){
                    $PerformanceEvaluationProject->setEval_prj_name($value2);
                }
                if($row2=="titleSinhala"){
                    $PerformanceEvaluationProject->setEval_prj_name_si($value2);
                }
                if($row2=="titleTamil"){
                    $PerformanceEvaluationProject->setEval_prj_name_ta($value2);
                }
                if($row2=="completionPercentage"){
                    $PerformanceEvaluationProject->setEval_prj_completed($value2);
                }    

                //print_r("<br/>");
               }
               $performanceDao->savePerformanceEvaluationProject($PerformanceEvaluationProject);
               $Project=$performanceDao->readProjectByUserCode($PerformanceEvaluationProject->eval_prj_user_code);
               $PerformanceEmployeeProject=$performanceDao->readProjectListByIDEmp($Project->eval_prj_id,$EmployeeData->empNumber);
               if($PerformanceEmployeeProject->eval_prj_id==null){
                   $PerformanceEmployeeProject=new PerformanceEmployeeProject();
                   $PerformanceEmployeeProject->setEval_prj_id($Project->eval_prj_id);
                   $PerformanceEmployeeProject->setEmp_number($EmployeeData->empNumber);
               }    
               $performanceDao->savePerformanceProjectEmp($PerformanceEmployeeProject);
               $i++;
               }
               }
           }

    
} catch (Exception $fault) {
    exit;
    //die(print_r($fault."error2"));
}        



        
        }
        }
        die;
    }
    
    public function executeAjaxDeleteAssignEmployee(sfWebRequest $request){
        
                $EVid = $request->getParameter('EVid');
                $ETid = $request->getParameter('ETid');
                $Empno = $request->getParameter('Empno');
                
                
                        $performanceDao= new PerformanceDao();
                        $performanceSaveDao= new PerformanceSaveDao();
                        $EmployeeData = $performanceDao->readEmployee($Empno);
                        $JobTitle = $EmployeeData->job_title_code;
                        $Level = $EmployeeData->level_code;
                        $Service = $EmployeeData->service_code;
                        $EvaluationDtlID = $performanceDao->readEvalDetailID($JobTitle, $Level, $Service, $EVid);
                        $performanceSaveDao->deleteEmployeeProject($EvaluationDtlID->eval_dtl_id, $Empno);
                        $performanceSaveDao->deleteEmployeeDuty($EvaluationDtlID->eval_dtl_id, $Empno);
                        $performanceSaveDao->deleteAssingEmployee($Empno, $EVid);
                        $performanceSaveDao->deleteAssingSuperEmployee($Empno, $EVid);
   
                        echo json_encode("true");
      die;                
    }

    public function setMessage($messageType, $message = array(), $persist=true) {
        $this->getUser()->setFlash('messageType', $messageType, $persist);
        $this->getUser()->setFlash('message', $message, $persist);
    }
    
    
    
    public function executeTestEmployeeProjectWebService(sfWebRequest $request) {

        $EMPNO = $request->getParameter('empno');    
        $Year = $request->getParameter('year'); 
        if($EMPNO!=null && $Year!= null){
        $sysConf=new sysConf();

        $Status=$sysConf->getEmployeeProjectWebServiceStatus();

        if($Status=="ON"){
            
            
        $coords = Struct::factory('employeeId','financialYear');
        $lat1 = $coords->create($EMPNO,$Year);
        //$coords = Struct::factory('employeeId');
        //$lat2 = $coords->create('6');
        //$coords = Struct::factory('locationId','financialYear');
        //$lat3 = $coords->create('42','2011');
        //$coords = Struct::factory('beneficiaryId','financialYear');
        //$lat4 = $coords->create('6','2011');

        try {
    $client = new soapclient($sysConf->getEmployeeProjectWebServiceUrl());
    $setLocation=$sysConf->getEmployeeProjectWebServiceUrlSetLocation();
    $client->__setLocation($setLocation);
    $OutResult = $client->getProjectProgressStatusForEmployee($lat1);
    die(print_r($OutResult));
        } catch (Exception $fault) {
            exit;
    //die(print_r($fault."error2"));
        }
        }
        }
        }
    
}
