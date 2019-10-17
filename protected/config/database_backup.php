<?php

// This is the database connection configuration.
return array(
    'class' => 'CDbConnection',
    'connectionString' => 'sqlite:' . dirname(__FILE__) . '/../runtime/core.db',
);
