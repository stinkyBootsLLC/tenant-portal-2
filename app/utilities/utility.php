<?php

    /**
     * Sanatize untrusted data
     * @param string
     * @return string
     */
    function sanatizeData($data){
		$specCharData = htmlspecialchars($data);
		$cleanData = str_replace(array(':', '-', '/', '*','=','?'), '', $specCharData);
        return $cleanData;
    }// end sanatize data
    /**
     * Monitor the Login Session for 30 minutes
     */
    function monitorSession(){
        $secondsInactive = time() - $_SESSION['start_activity'];
        $expireAfter = 30 * 60;// 30 minutes
        if(isset($_SESSION['start_activity'])){  
            $expireAfterSeconds = $expireAfter * 1;
            if($secondsInactive >= $expireAfterSeconds){
				echo "<script>window.location.href = '../logout.php'; </script>";
            }
        }// end if
    }// end monitorSession()
 


?>