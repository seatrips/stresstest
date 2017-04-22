<?php
/* _____________________
        
         STRESS TEST SHIFT
   _____________________ */

// Variables
        $date                           = date("Y-m-d H:i:s");
        $secret                         = "YOURTESTNETSECRET"; // Passphrase of your delegate
        $amount                         = 1000000;
        $sendTo                         = "ADRESS"; // DELEGATENAME TO SENT TO delegate
        $nodeAddress                    = "http://YOURNODE ADRESS:9405"; // Testnet

        $multiple                       = true; // Send multiple transactions?
        $times                          = 5000; // How many transactions?

// If $multiple === true, send $times transactions
        if($multiple === true){
                for($i=0; $i < $times; $i++){
                                ob_start();
                                $transfer = passthru("curl -s -k -H 'Content-Type: application/json' -X PUT -d '{\"secret\":\"$secret\",\"amount\":".$amount.",\"recipientId\":\"$sendTo\"}' $nodeAddress/api/transactions");
                                $transfer_output = ob_get_contents();
                                ob_end_clean();

                                if(strpos($transfer_output, '"success":true') !== false){
                                        $array = json_decode($transfer_output, true);
                                        echo $date." - [ STRESS TEST ] Transfer completed! Transaction ID: ".$array['transactionId']."\n";
                                }else{
                                        echo $transfer_output."\n";
                                        echo $date." - [ STRESS TEST ] Transfer failed..\n";
                                }
                                time_nanosleep(0, 900000000); // Half a second
                }
        }else{
                // Start output buffer
                        ob_start();

                // Transfer command
                        $transfer = passthru("curl -s -k -H 'Content-Type: application/json' -X PUT -d '{\"secret\":\"$secret\",\"amount\":".$amount.",\"recipientId\":\"$sendTo\"}' $nodeAddress/api/transactions");

                // Send output buffer to variable
                        $transfer_output = ob_get_contents();

                // Stop and cleanup output buffer
                        ob_end_clean();


                // If we get a success...
                        if(strpos($transfer_output, '"success":true') !== false){
                                $array = json_decode($transfer_output, true);
                                echo $date." - [ STRESS TEST ] Transfer completed! Transaction ID: ".$array['transactionId']."\n";
                        }else{
                                echo $transfer_output."\n";
                                echo $date." - [ STRESS TEST ] Transfer failed..\n";
                        }
        }
?>
