<?php

class MdbPerson extends MdbActiveRecord {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function primaryKey() {
        return 'PersonID';
    }

    public function relations() {
        return array(
            'department' => array(self::BELONGS_TO, 'MdbDepartment', 'DepartmentID'),
        );
    }

    public function getColumnArray() {
        return array(
            array(
                'name' => 'Title',
                'filter' => CHtml::listData(MdbPerson::model()->findAll(array(
                            'group' => 'Title',
                        )), 'Title', 'Title'),
            ),
            array(
                'name' => 'Name',
            ),
            array(
                'header' => 'Department',
                'name' => 'search[Department]',
                'value' => 'CHtml::value($data,"department.Department")',
                'type' => 'text',
            ),
            array(
                'header' => 'Ministry',
                'name' => 'search[Ministry]',
                'value' => 'CHtml::value($data,"department.Ministry")',
                'type' => 'text',
            ),
        );
    }

    public function search() {
        $dataProvider = parent::search();

        if (isset($this->search['Department'])) {
            $criteria = new CDbCriteria();
            $criteria->with = array(
                'department' => array(
                    'together' => true,
                ),
            );
            $criteria->compare('department.Department', $this->search['Department'], true);
            $dataProvider->criteria->mergeWith($criteria);
        }

        if (isset($this->search['Ministry'])) {
            $criteria = new CDbCriteria();
            $criteria->with = array(
                'department' => array(
                    'together' => true,
                ),
            );
            $criteria->compare('department.Ministry', $this->search['Ministry'], true);
            $dataProvider->criteria->mergeWith($criteria);
        }


        return $dataProvider;
    }

}
