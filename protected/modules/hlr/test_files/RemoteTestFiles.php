<?php

require 'HLRLookupService.php';
function test() {
    $lookupService = new HLRLookupService;
    $lookupService->setMobileNumber("447540245436");
    $result = $lookupService->getPhoneInformation();
    print_r($result);
}
test();
function test1() {
    $lookupService = new HLRLookupService;
    $lookupService->setMobileNumber("447940236798");
    $result = $lookupService->getPhoneInformation();
    print_r($result);
}
test1();


function test2() {
    $lookupService = new HLRLookupService;
    $lookupService->setMobileNumber("447876808850");
    $result = $lookupService->getPhoneInformation();
    print_r($result);
}
test2();


function test3() {
    $lookupService = new HLRLookupService;
    $lookupService->setMobileNumber("447460849058");
    $result = $lookupService->getPhoneInformation();
    print_r($result);
}
test3();


function test4() {
    $lookupService = new HLRLookupService;
    $lookupService->setMobileNumber("447856079904");
    $result = $lookupService->getPhoneInformation();
    print_r($result);
}
test4();