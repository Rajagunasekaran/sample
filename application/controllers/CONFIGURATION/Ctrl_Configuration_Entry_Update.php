<?php
class Ctrl_Configuration_Entry_Update extends CI_Controller{
    function __construct() {
        parent::__construct();
        $this->load->model('EILIB/Mdl_eilib_common_function');
        $this->load->model('CONFIGURATION/Mdl_configuration_entry_update');
    }
    //FUNCTION FOR INDEX FILE
    public function index()
    {
        $this->load->view('CONFIGURATION/Vw_Configuration_Entry_Update');
    }
    public function CONF_ENTRY_script_name(){
        $query = $this->Mdl_configuration_entry_update->getscriptname($this->input->post('CONFIG_ENTRY_searchby'));
        $Values=array($query);
        echo json_encode($Values);
    }
    //FUNCTION FOR type NAME
    public function CONF_ENTRY_type_name(){
        $data =  $this->Mdl_configuration_entry_update->gettypename($this->input->post('CONFIG_ENTRY_data'),$this->input->post('CONFIG_ENTRY_searchby'));
        echo JSON_encode($data);
    }
    //FUNCTIONFOR SAVE PART
    public function CONF_ENTRY_save_data()
    {
        $USERSTAMP=$this->Mdl_eilib_common_function->getSessionUserStamp();
        $result = $this->Mdl_configuration_entry_update->configentrydatainsert($USERSTAMP) ;
        echo JSON_encode($result);
    }
    //FUNCTIONFOR SAVE PART
    public function CONF_ENTRY_flex_data()
    {
        $timeZoneFormat=$this->Mdl_eilib_common_function->getTimezone();
        $USERSTAMP=$this->Mdl_eilib_common_function->getSessionUserStamp();
        $result = $this->Mdl_configuration_entry_update->config_flexdata($USERSTAMP,$this->input->post('module'),$this->input->post('type'),$timeZoneFormat) ;
        echo JSON_encode($result);
    }
    //FUNCTIONFOR UPDATE PART
    public function dataupdate()
    {
        $USERSTAMP=$this->Mdl_eilib_common_function->getSessionUserStamp();
        $result = $this->Mdl_configuration_entry_update->dataupdate($USERSTAMP,$this->input->post('rowid'),$this->input->post('module'),$this->input->post('type'),$this->input->post('data'),$this->input->post('CONFIG_SEARCH_subdata'),$this->input->post('subdatamount_value'),$this->input->post('typeText'),$this->input->post('olddata')) ;
        echo JSON_encode($result);
    }
    //DELETE OPTION
    public function deleteoption(){
        $USERSTAMP=$this->Mdl_eilib_common_function->getSessionUserStamp();
        $result = $this->Mdl_configuration_entry_update->deleteoption($USERSTAMP,$this->input->post('rowid'),$this->input->post('module'),$this->input->post('type'),$this->input->post('data')) ;
        echo JSON_encode($result);
    }
    //FUNCTION FOR ERR MSGS
    public function Initaildatas()
    {
        $formname=$_REQUEST['Formname'];
        $errorlist=$_REQUEST['ErrorList'];
        $ErrorMessage= $this->Mdl_eilib_common_function->getErrorMessageList($errorlist);
        echo json_encode($ErrorMessage);
    }
    //ALREADY EXIT FUNCTION
    public function data_exists()
    {
        $data['script_name_already_exits_array'] = $this->Mdl_configuration_entry_update->data_name_exists($this->input->post('module'),$this->input->post('type'),$this->input->post('data'));
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }
    //ALREADY EXIT FUNCTION
    public function subdata_exists()
    {
        $data['subtype_name_already_exits_array'] = $this->Mdl_configuration_entry_update->sub_data_exists($this->input->post('sub_type_data'));
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }
    //FUNCTION FOR DELETE CONFORM
    public function deleteconformoption(){
        $USERSTAMP=$this->Mdl_eilib_common_function->getSessionUserStamp();
        $result = $this->Mdl_configuration_entry_update->DeleteRecord($USERSTAMP,$this->input->post('rowid'),$this->input->post('module'),$this->input->post('type'),$this->input->post('data')) ;
        echo JSON_encode($result);
    }
    //ALREADY EXIT FUNCTION
    public function dataupd_exists()
    {
        $data['script_name_already_exits_array'] = $this->Mdl_configuration_entry_update->data_updname_exists($this->input->post('module'),$this->input->post('type'),$this->input->post('data'),$this->input->post('CONFIG_SEARCH_subtype'),$this->input->post('subdatamount_value'));
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }
}