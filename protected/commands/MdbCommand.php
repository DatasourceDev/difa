<?php

class MdbCommand extends CConsoleCommand {

    public function getConnection($file) {
        $uname = explode(" ", php_uname());
        $os = $uname[0];
        switch ($os) {
            case 'Windows':
                $driver = '{Microsoft Access Driver (*.mdb, *.accdb)}';
                break;
            case 'Linux':
                $driver = 'MDBTools';
                break;
            default:
                exit("Don't know about this OS");
        }
        return odbc_connect('Driver=' . $driver . ';DBQ=' . $file, '', '');
    }

    public function actionConvert($id) {
        Yii::trace('start covert mdb to sqlite');
        $model = LegacySource::model()->findByPk($id);

        if (!isset($model)) {
            Yii::log('Processing...', CLogger::LEVEL_ERROR);
            $model->status = LegacySource::STATUS_FAILED;
            return false;
        }
        $conn = $this->getConnection($model->mdb_path);
        if (!$conn) {
            Yii::log('Datasource not found.', CLogger::LEVEL_ERROR);
            return false;
        }

        Yii::trace('Processing...');

        // Create SQLite
        $dbFile = Yii::getPathOfAlias('application.runtime.legacy') . '/' . $model->id . '.db';
        if (file_exists($dbFile)) {
            Yii::trace('Found existing SQLite3 ... deleted' . $dbFile);
            unlink($dbFile);
        }
        Yii::trace('Creating SQLite3 ...' . $dbFile);
        $db = new SQLite3($dbFile);
        //chmod($dbFile, 0777);

        Yii::trace('Creating PDO Commponent for SQLite.');
        Yii::app()->setComponents(array(
            'dbLite' => array(
                'class' => 'CDbConnection',
                'connectionString' => 'sqlite:' . $dbFile,
            ),
                ), false);

        $transaction = Yii::app()->dbLite->beginTransaction();
        foreach ($this->schemaData() as $table => $columns) {
            /* @var $command CDbCommand */
            $command = Yii::app()->dbLite->createCommand();
            $command->createTable($table, $columns);
            Yii::trace('Created table ...' . $table);
            $result = odbc_exec($conn, 'SELECT * FROM ' . $table);
            while ($row = odbc_fetch_array($result)) {
                $command->insert($table, $row);
            }
            Yii::trace('Imported data for table ' . $table);
            odbc_free_result($result);
        }
        $transaction->commit();

        $model->mdb_name = $dbFile;
        $model->status = LegacySource::STATUS_DONE;
        $model->save();
        Yii::trace('Done.');
    }

    public function schemaData() {
        return array(
            'T_AcademicListening' => array(
                'Serial' => 'TEXT',
                'TestSet' => 'TEXT',
                'TestDate' => 'TEXT',
                'Round' => 'INTEGER',
                'DeskNumber' => 'INTEGER',
                'L2' => 'INTEGER',
                'L3' => 'INTEGER',
                'L4' => 'INTEGER',
                'L_Atn' => 'NUMERIC',
            ),
            'T_AcademicReading' => array(
                'Serial' => 'TEXT',
                'TestSet' => 'TEXT',
                'TestDate' => 'TEXT',
                'Round' => 'INTEGER',
                'DeskNumber' => 'INTEGER',
                'R1' => 'INTEGER',
                'R4' => 'INTEGER',
                'R5' => 'INTEGER',
                'R6' => 'INTEGER',
                'R7' => 'INTEGER',
                'R_Atn' => 'NUMERIC',
            ),
            'T_AnswerAP' => array(
                'OrderNumber' => 'TEXT',
                'Name' => 'TEXT',
                'Department' => 'TEXT',
                'DonorName' => 'TEXT',
                'Subject' => 'TEXT',
                'TestDate' => 'TEXT',
                'Level' => 'TEXT',
                'MinScore' => 'TEXT',
                'Reading' => 'TEXT',
                'Listening' => 'TEXT',
                'ScoreTotal' => 'TEXT',
                'ApproveName' => 'TEXT',
                'ApprovePosition' => 'TEXT',
                'Round' => 'TEXT',
                'SubjectID' => 'TEXT',
                'DonorID' => 'TEXT',
                'LevelID' => 'TEXT',
            ),
            'T_Approve' => array(
                'ApproveID' => 'INTEGER',
                'ApproveName' => 'TEXT',
                'ApprovePosition' => 'TEXT',
            ),
            'T_Audit' => array(
                'AuditID' => 'INTEGER',
                'AuditName' => 'TEXT',
            ),
            'T_AuditLog' => array(
                'AuditDateTime' => 'TEXT',
                'UserID' => 'TEXT',
                'AuditID' => 'INTEGER',
                'Description' => 'TEXT',
            ),
            'T_Department' => array(
                'DepartmentID' => 'INTEGER',
                'Department' => 'TEXT',
                'Ministry' => 'TEXT',
            ),
            'T_Donor' => array(
                'DonorID' => 'INTEGER',
                'DonorName' => 'TEXT',
            ),
            'T_Level' => array(
                'LevelID' => 'INTEGER',
                'Level' => 'TEXT',
            ),
            'T_MinScore' => array(
                'MinScore' => 'INTEGER',
                'SubjectID' => 'INTEGER',
                'DonorID' => 'INTEGER',
            ),
            'T_NameAPList' => array(
                'RoomID' => 'INTEGER',
                'PersonID' => 'INTEGER',
                'DeskNumber' => 'INTEGER',
                'OrderNumber' => 'INTEGER',
                'Reading' => 'NUMERIC',
                'Listening' => 'NUMERIC',
                'ScoreTotal' => 'NUMERIC',
            ),
            'T_NamePTList' => array(
                'RoomID' => 'INTEGER',
                'PersonID' => 'INTEGER',
                'DeskNumber' => 'INTEGER',
                'OrderNumber' => 'INTEGER',
                'Reading' => 'NUMERIC',
                'Listening' => 'NUMERIC',
                'ScoreTotal' => 'NUMERIC',
            ),
            'T_Person' => array(
                'PersonID' => 'INTEGER',
                'Title' => 'TEXT',
                'Name' => 'TEXT',
                'DepartmentID' => 'INTEGER',
            ),
            'T_PlacementListening' => array(
                'Serial' => 'TEXT',
                'TestSet' => 'TEXT',
                'TestDate' => 'TEXT',
                'Round' => 'INTEGER',
                'DeskNumber' => 'INTEGER',
                'L1' => 'INTEGER',
                'L2' => 'INTEGER',
                'L_Atn' => 'NUMERIC',
            ),
            'T_PlacementReading' => array(
                'Serial' => 'TEXT',
                'TestSet' => 'TEXT',
                'TestDate' => 'TEXT',
                'Round' => 'INTEGER',
                'DeskNumber' => 'INTEGER',
                'R1' => 'INTEGER',
                'R6' => 'INTEGER',
                'R7' => 'INTEGER',
                'R82' => 'INTEGER',
                'R_Atn' => 'NUMERIC',
            ),
            'T_PracticalListening' => array(
                'Serial' => 'TEXT',
                'TestSet' => 'TEXT',
                'TestDate' => 'TEXT',
                'Round' => 'INTEGER',
                'DeskNumber' => 'INTEGER',
                'L3' => 'INTEGER',
                'L4' => 'INTEGER',
                'L_Atn' => 'NUMERIC',
            ),
            'T_PracticalReading' => array(
                'Serial' => 'TEXT',
                'TestSet' => 'TEXT',
                'TestDate' => 'TEXT',
                'Round' => 'INTEGER',
                'DeskNumber' => 'INTEGER',
                'R1' => 'INTEGER',
                'R4' => 'INTEGER',
                'R6' => 'INTEGER',
                'R7' => 'INTEGER',
                'R_Atn' => 'NUMERIC',
            ),
            'T_RoomAPList' => array(
                'RoomID' => 'INTEGER',
                'TestDate' => 'TEXT',
                'Round' => 'INTEGER',
                'SubjectID' => 'INTEGER',
                'DonorID' => 'INTEGER',
                'LevelID' => 'INTEGER',
                'TestSet' => 'TEXT',
                'TestType' => 'TEXT',
                'ApproveID' => 'INTEGER',
            ),
            'T_RoomPTList' => array(
                'RoomID' => 'INTEGER',
                'TestDate' => 'TEXT',
                'Round' => 'INTEGER',
                'TestSet' => 'TEXT',
            ),
            'T_Round' => array(
                'Round' => 'INTEGER',
                'Reading' => 'TEXT',
                'Listening' => 'TEXT',
            ),
            'T_Subject' => array(
                'SubjectID' => 'INTEGER',
                'Subject' => 'TEXT',
            ),
            'T_User' => array(
                'UserID' => 'TEXT',
                'Password' => 'TEXT',
                'UserName' => 'TEXT',
            ),
        );
    }

}
