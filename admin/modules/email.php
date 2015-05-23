<?php
class email {
    public function sendEmail($recipient, $recipientName, $date)
    {
        if ($_SESSION['account_type'] != 1) {
            echo "<p id='messageWarn'>Nav pieejas!</p>";
        } else {
            $subject = 'Oksalis medību kursi.';
            $message = 'Cienījamais - ' . $recipientName . ', informējam jūs, ka mednieka kursi sāksies ' . $date . ' datumā.';
            $headers = 'From: no-reply@oksalis.lv' . "\r\n" .
                'Reply-To: no-reply@oksalis.lv' . "\r\n" .
                'X-Mailer: PHP/' . phpversion();
            if (mail($recipient, $subject, $message, $headers)) {

            } else {
                echo "<p id='message'>Kļūda</p>";
            }
        }
    }
}

