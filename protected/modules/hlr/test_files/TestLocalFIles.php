<?php

require 'HLRLookupService.php';
function test() {
    $commandResult = file_get_contents(dirname(__FILE__) . "/result6.html");
    $lookupService = new HLRLookupService;
    $lookupService->setRawResult($commandResult);
    $result = $lookupService->getPhoneInformation();
    print_r($result);
}
test();

function test1() {
    $commandResult = file_get_contents(dirname(__FILE__) . "/result7.html");
    $lookupService = new HLRLookupService;
    $lookupService->setRawResult($commandResult);
    $result = $lookupService->getPhoneInformation();
    print_r($result);
}
test1();


function test2() {
    $commandResult = file_get_contents(dirname(__FILE__) . "/result8.html");
    $lookupService = new HLRLookupService;
    $lookupService->setRawResult($commandResult);
    $result = $lookupService->getPhoneInformation();
    print_r($result);
}
test2();


function test3() {
    $commandResult = file_get_contents(dirname(__FILE__) . "/result9.html");
    $lookupService = new HLRLookupService;
    $lookupService->setRawResult($commandResult);
    $result = $lookupService->getPhoneInformation();
    print_r($result);
}
test3();


function test4() {
    $commandResult = file_get_contents(dirname(__FILE__) . "/result5.html");
    $lookupService = new HLRLookupService;
    $lookupService->setRawResult($commandResult);
    $result = $lookupService->getPhoneInformation();
    print_r($result);
}
test4();