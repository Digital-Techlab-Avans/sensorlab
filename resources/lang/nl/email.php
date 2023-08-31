<?php
require_once 'shared.php';
return [
//    Loan_status
    'status.salutation' => 'Beste :name,',
    'status.message' => 'Het product (:product :amountx) dat je ingeleverd hebt is :status.',
    'status.greeting' => GREETING,
    'status.signature' => SIGNATURE,
    'status.comment' => 'Opmerking: :comment',

//    Loan_reminder
    'reminder.salutation' => 'Beste :name,',
    'reminder.messageToday' => 'De geleende :product (:amountx) moet vandaag teruggebracht worden.',
    'reminder.messageXDays' => 'De geleende :product (:amountx) moet binnen :days teruggebracht worden. Dit moet voor :date gebeuren.',
    'reminder.greeting' => GREETING,
    'reminder.signature' => SIGNATURE,
];

