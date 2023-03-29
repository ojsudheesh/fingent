<?php

    require_once BASE_PATH . "controller/baseController.php";

    class CustomController extends BaseController
    {
        
        public function customAction() {
            $response = "custom controller action.";
            $this->sendOutput($response, 200);
        }
    }
?>