<?php

interface IAccountProfile {

    function checkChangeName();

    function checkDepartmentChange($model);

    function getFullname();

    function getFullnameEn();

    function getFullnameTh();

    function getTextContactPhone();

    function getTextDepartment();
    
    function getTextDepartmentTh();

    function getTextDepartmentForCard();

    function getTextWorkLevel();

    function getTextWorkPosition();

    function getTextWorkOffice();
    
    function getTextWorkOfficeTh();

    function getReplyAddress();

    function getTextTitleEn();

    function getTextTitleTh();

    function getTextFirstnameEn();

    function getTextFirstnameTh();

    function getTextMidnameEn();

    function getTextMidnameTh();

    function getTextLastnameEn();

    function getTextLastnameTh();

    function getTextAnyPhone();
    
    function createProfileOfType($id);
}
