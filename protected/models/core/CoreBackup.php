<?php

Yii::import('application.models._core.Backup');

class CoreBackup extends Backup {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function relations() {
        return array_merge(parent::relations(), array(
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
        ));
    }

    /**
     * Restore database from a zip file.
     * @return boolean Return TRUE if retore successfully. otherwise return FALSE.
     */
    public function doRestore() {
        $mysql = Configuration::getKey('backup_mysql_path', '/usr/bin/mysql');
        $database = Yii::app()->db->createCommand('SELECT DATABASE()')->queryScalar();
        $username = Yii::app()->db->username;
        $password = Yii::app()->db->password;
        $path = Configuration::getKey('backup_file_path', Yii::getPathOfAlias('application.uploads.backup'));

        $zip = new ZipArchive();
        $zip->open($path . DIRECTORY_SEPARATOR . $this->filename);
        $zip->extractTo(sys_get_temp_dir(), str_replace('.zip', '.sql', $this->filename));
        $zip->close();

        $file = sys_get_temp_dir() . DIRECTORY_SEPARATOR . str_replace('.zip', '.sql', $this->filename);
        $command = str_replace(array(
            '{mysql}',
            '{username}',
            '{password}',
            '{database}',
            '{file}',
                ), array(
            $mysql,
            $username,
            $password,
            $database,
            $file,
                ), '{mysql} --user={username} --password={password} {database} < {file}');
        $command = str_replace('/', DIRECTORY_SEPARATOR, $command);
        shell_exec($command);

        Yii::log($command, CLogger::LEVEL_TRACE);

        unlink($file);
        return true;
    }

    /**
     * Backup to a zip file.
     * @param string $backup_name Name of backup.
     * @param int $is_system Is backup by system ? 0 is system, 1 is user Default 0
     * @return boolean Return TRUE if backup successfully. otherwise return FALSE.
     */
    public function doBackup($backup_name = null, $is_system = 0) {
        $mysqldump = Configuration::getKey('backup_mysqldump_path', '/usr/bin/mysqldump');
        $database = Yii::app()->db->createCommand('SELECT DATABASE()')->queryScalar();
        $username = Yii::app()->db->username;
        $password = Yii::app()->db->password;
        $path = str_replace('/', DIRECTORY_SEPARATOR, Configuration::getKey('backup_file_path', Yii::getPathOfAlias('application.uploads.backup')));
        $command = str_replace(array(
            '{mysqldump}',
            '{username}',
            '{password}',
            '{database}',
                ), array(
            $mysqldump,
            $username,
            $password,
            $database,
                ), '{mysqldump} --user={username} --password={password} --insert-ignore --single-transaction {database}');
        $command = str_replace('/', DIRECTORY_SEPARATOR, $command);
        $result = shell_exec($command);
        $name = date('YmdHis');

        Yii::log($command, CLogger::LEVEL_TRACE);

        $readable_name = $backup_name ? $backup_name : date('Y-m-d H:i:s') . '- สำรองข้อมูลด้วยคำสั่ง';

        $zip = new ZipArchive();
        $zip->open($path . DIRECTORY_SEPARATOR . $name . '.zip', ZipArchive::CREATE | ZIPARCHIVE::OVERWRITE);
        $zip->addFromString($name . '.sql', $result);
        $zip->close();

        $this->name = $readable_name;
        $this->filename = $name . '.zip';
        $this->created = time();
        $this->is_system = $is_system;
        $this->filesize = filesize($path . DIRECTORY_SEPARATOR . $name . '.zip');
        $this->user_id = isset(Yii::app()->user) ? Yii::app()->user->id : null;
        return $this->save();
    }

}
