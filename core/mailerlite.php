<?php

$groupsApi = (new \MailerLiteApi\MailerLite('9e2b6b2b6cf8a4d693c3c5b0c7956722'))->groups();

$groupId = 24433730;

$name = $_SESSION['form-data']['FNAME'];
$email = $_SESSION['form-data']['fields']['email'];
$question1 = $_SESSION['form-data']['exampleRadios'];
$question2 = $_SESSION['form-data']['choice'];

$subscriber = [
  'email' => $email,
  'name' => $name,
  'fields' => [
      'question1' => $question1,
      'question2' => $question2
  ]
];

try {
  $addedSubscriber = $groupsApi->addSubscriber($groupId, $subscriber); // returns added subscriber
?>

<script>
  // Redirect to this page
  window.location.href = 'http://www.google.com';
</script>

<?php
} catch (\Throwable $th) {
  $_SESSION['slider-form-error'] = 'Some Error Occured, Please try again.';
}

?>