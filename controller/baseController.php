<?php
    
    class BaseController extends Database
    {
        
        public function __call($name, $arguments) {
            $this->sendOutput('Invalid Request', 404);
        }
        
        protected function sendOutput($data, $status = '') {
            header('Content-Type: application/json');
            echo json_encode(array("data" => $data, "status" => $status));
            exit;
        }

        public function checkApiRequests() {
            try {
                $apiRequests = isset($_GET['api_request']) && $_GET['api_request'] > 0 ? intval($_GET['api_request']) : 0;
                if($apiRequests > 0) {
                    $remoteIpAddress = $_SERVER['REMOTE_ADDR'] ? $_SERVER['REMOTE_ADDR'] : '';
                    $timeStamp = time();
                    $timeNow = date('H:i:s', $timeStamp);
                    $timeSecondAgo = date('H:i:s', $timeStamp - 1);

                    $this->connection->query("DELETE FROM requests WHERE request_time < '$timeSecondAgo'");

                    $res = $this->connection->query("SELECT id FROM requests WHERE request_from = '$remoteIpAddress'");

                    ## Check whether total records meet maximum requests limit
                    if($res->num_rows >= MAX_REQUESTS_SECOND) {
                        $response = "Max request size exceeded.";
                        $this->sendOutput($response, 429);
                    }
                    else {
                        $this->connection->query("INSERT INTO requests (request_from, request_time) VALUES ('$remoteIpAddress', '$timeNow')");
                        $response = "Success";
                        $this->sendOutput($response, 200);
                    }
                }

            } catch (Exception $e) {
                //throw new Exception($e->getMessage());
                $this->sendOutput($e->getMessage(), 502); 
            }
        }
    }
?>