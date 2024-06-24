<?php
class AdminModel {

    private $imapPath = '{imap.gmail.com:993/imap/ssl}INBOX';
    private $username = 'contact2feedbackoneverything@gmail.com';
    private $password = 'mjga yvnw popo qcmt';

    public function getEmailInbox() {
        $success = true; 
        $messages = [];
    
        $inbox = imap_open($this->imapPath, $this->username, $this->password);
    
        if ($inbox) {
            $emails = imap_search($inbox, 'ALL', SE_UID, "UTF-8");
    
            if ($emails) {
                $index = 0;
                foreach ($emails as $email_uid) {
                    $header = imap_headerinfo($inbox, imap_msgno($inbox, $email_uid));
                    if ($header === false) {
                        continue;
                    }
    
                    $subject = isset($header->subject) ? $header->subject : '';
                    $date = date('Y-m-d H:i:s', strtotime($header->date));
    
                    if (stripos($subject, 'new contact form submission') === false && stripos($subject, 're: new contact form submission') === false) {
                        continue;
                    }
    
                    $message_imap = imap_fetchbody($inbox, imap_msgno($inbox, $email_uid), 1.1);
                    if (!$message_imap) {
                        $message_imap = imap_fetchbody($inbox, imap_msgno($inbox, $email_uid), 1);
                    }
    
                    preg_match('/Name: (.*?)\r?\n/', $message_imap, $name);
                    preg_match('/Email: (.*?)\r?\n/', $message_imap, $email);
                    preg_match('/Message:\r?\n(.*?)$/s', $message_imap, $msg);
    
                    $msgInfo = [
                        'Index' => $index,
                        'UID' => $email_uid,
                        'Subject' => $subject,
                        'Date' => $date,
                        'Name' => isset($name[1]) ? trim($name[1]) : '',
                        'Email' => isset($email[1]) ? trim($email[1]) : '',
                        'Message' => isset($msg[1]) ? trim($msg[1]) : ''
                    ];
    
                    $messages[] = $msgInfo;
                    $index++;
                }
    
                usort($messages, function($a, $b) {
                    return strtotime($b['Date']) - strtotime($a['Date']);
                });
            } else {
                $success = false; 
                $messages = "No messages available.";
            }
    
            imap_close($inbox);
        } else {
            $success = false; 
            $messages = "Connection to IMAP server failed.";
            }

    
        $result = [
            'success' => $success,
            'message' => $messages
        ];
    
        return json_encode($result);
    }

    public function sendResponse($index, $email, $response) {
        $result = [
            'success' => false,
            'message' => ''
        ];
    
        $inbox = imap_open($this->imapPath, $this->username, $this->password);
    
        if ($inbox) {
            $emails = imap_search($inbox, 'ALL', SE_UID, "UTF-8");
    
            if ($emails && isset($emails[$index])) {
                $email_uid = $emails[$index];
                $header = imap_headerinfo($inbox, imap_msgno($inbox, $email_uid));
                $original_subject = $header->subject;
                $original_date = date('Y-m-d H:i:s', strtotime($header->date));
                $original_from = $header->fromaddress;
    
                $structure = imap_fetchstructure($inbox, imap_msgno($inbox, $email_uid));
                $original_message = imap_body($inbox, imap_msgno($inbox, $email_uid));
    
                $to = $email;
                $subject = 'Re: ' . $original_subject;
                $message = "Original Message:\n\n";
                $message .= "Subject: " . $original_subject . "\n";
                $message .= "From: " . $original_from . "\n";
                $message .= "Date: " . $original_date . "\n";
                $message .= "Message:\n" . $original_message . "\n\n";
                $message .= "FeedBack On Everything Says:\n" . $response;
    
                $headers = 'From: contact2feedbackoneverything@gmail.com';
    
                if (mail($to, $subject, $message, $headers)) {
                    $this->archiveMessage($inbox, $email_uid, '[Gmail]/All Mail');
                    $result['success'] = true;
                    $result['message'] = 'The response was successfully sent and the email was archived!';
                } else {
                    $result['success'] = false;
                    $result['message'] = 'There was an error sending the response. Please try again.';
                }
            } else {
                $result['success'] = false;
                $result['message'] = "Message with index $index not found in inbox.";
            }
    
            imap_close($inbox);
        } else {
            $result['success'] = false;
            $result['message'] = 'Connection to IMAP server failed.';
        }
    
        return json_encode($result);
    }
    
    private function archiveMessage($imap, $email_uid, $archiveFolder) {
        imap_mail_move($imap, $email_uid, $archiveFolder, CP_UID);
        imap_delete($imap, $email_uid);
        imap_expunge($imap);
    }

    public function exportDatabase() {
        $host = 'localhost';
        $dbUsername = 'root';
        $dbPassword = '';
        $dbName = 'foe_app';
    
        $conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);
    
        if ($conn->connect_error) {
            return [
                'success' => false,
                'message' => 'Connection failed: ' . $conn->connect_error
            ];
        }
    
        $sql = 'SET FOREIGN_KEY_CHECKS=0;' . "\n";
        $tables = array();
        $result = $conn->query("SHOW TABLES");
    
        while($row = $result->fetch_row()) {
            $tables[] = $row[0];
        }
    
        foreach($tables as $table) {
            $result = $conn->query("SELECT * FROM $table");
            $numFields = $result->field_count;
    
            $sql .= "DROP TABLE IF EXISTS $table;" . "\n";
            $row2 = $conn->query("SHOW CREATE TABLE $table");
            $row2 = $row2->fetch_row();
            $sql .= "\n\n" . $row2[1] . ";\n\n";
    
            while ($row = $result->fetch_assoc()) {
                $sql .= "INSERT INTO $table VALUES(";
                $firstField = true;
                foreach ($row as $key => $value) {
                    if (!$firstField) {
                        $sql .= ",";
                    }
                    if ($value === null) {
                        $sql .= "NULL";
                    } else {
                        $value = $conn->real_escape_string($value);
                        $sql .= '"' . $value . '"';
                    }
                    $firstField = false;
                }
                $sql .= ");\n";
            }
            $sql .= "\n\n\n";
        }
    
        $file = 'exported_database.sql'; //se salveaza si in server, la fiecare export se updateaza fisierul
        file_put_contents($file, $sql);
    
        $conn->close();
    
        return [
            'success' => true,
            'message' => $sql
        ];
    }
    
    public function importDatabase($sqlContent) {
        $host = 'localhost';
        $dbUsername = 'root';
        $dbPassword = ''; 
        $dbName = 'foe_app';

        $conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);

        if ($conn->connect_error) {
            return [
                'success' => false,
                'message' => 'Connection failed: ' . $conn->connect_error
            ];
        }

        $result = $conn->multi_query($sqlContent);

        if ($result) {
            return [
                'success' => true,
                'message' => 'Database imported successfully!'
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Failed to import database: ' . $conn->error
            ];
        }

        $conn->close();
    }
}