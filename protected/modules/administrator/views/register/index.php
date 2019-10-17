<div class="topic">Member Register</div>
<div class="row">
    <div class="col-md-8">
        <p><strong>Welcome!</strong></p>
        <p>This website contains important information about the new Devawongse Varopakarn Institute of Foreign Affairs Test of English Skills or DIFA TES. The test will be used to assess the English language proficiency of Thai civil servants and state enterprise employees who:</p>
        <ul>
            <li>wish to apply for scholarships, training and/or study visits overseas</li>
            <li>are applying for overseas postings</li>
            <li>are applying for specific government projects (e.g. High Performance Project and Potential Civil Servants Project)</li>
            <li>are seeking promotion</li>
            <li>wish to receive the English language pay increment</li>
        </ul>
        <p>The DIFA TES assesses English language proficiency across 4 skills areas:</p>
        <ul>
            <li>reading (compulsory)</li>
            <li>listening (compulsory)</li>
            <li>writing (optional)</li>
            <li>speaking (optional)</li>
        </ul>
        <p>Test takers are advised to:</p>
        <ul>
            <li>read the overview provided for each of the four skills under Guidelines</li>
            <li>look at the Sample Tasks for reading and listening to familiarise themselves with the test methods</li>
            <li>check the Answer Keys and read the Justifications for the reading and listening tasks</li>
            <li>look at the Sample Tasks for speaking and writing to familiarise themselves with the task types</li>
            <li>study the Sample Performances given for writing and speaking</li>
            <li>read the Justifications, which describe and grade each example, and refer to the Rating Scales</li>
        </ul>
        <p>Please go to Background to find out more about the Devawongse Varopakarn Institute of Foreign Affairs (DVIFA) and to learn why the test has been developed.</p>
    </div>
    <div class="col-md-4">
        <?php
        $this->widget('booster.widgets.TbButton', array(
            'size' => 'large',
            'label' => Yii::t('register', 'General'),
            'block' => true,
            'context' => 'primary',
            'htmlOptions' => array(
                'data-toggle' => 'modal',
                'data-target' => '#register-general-modal',
            ),
        ));
        ?>
        <?php
        $this->widget('booster.widgets.TbButton', array(
            'size' => 'large',
            'label' => Yii::t('register', 'Diplomat - Thai'),
            'buttonType' => 'link',
            'url' => array('createDiplomatThai'),
            'block' => true,
            'context' => 'success',
        ));
        ?>
        <?php
        $this->widget('booster.widgets.TbButton', array(
            'size' => 'large',
            'label' => Yii::t('register', 'Diplomat - International'),
            'buttonType' => 'link',
            'url' => array('createDiplomatForeigner'),
            'block' => true,
            'context' => 'warning',
        ));
        ?>
    </div>
</div>
<?php
$this->beginWidget('booster.widgets.TbModal', array(
    'id' => 'register-general-modal',
));
?>
<div class="modal-header bg-primary">
    <h3 class="fancy modal-title text-center"><?php echo Yii::t('register', 'Please select'); ?></h3>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-md-6">
            <?php
            $this->widget('booster.widgets.TbButton', array(
                'size' => 'large',
                'label' => Yii::t('register', 'Thai'),
                'block' => true,
                'context' => 'success',
                'buttonType' => 'link',
                'url' => array('createGeneralThai'),
            ));
            ?>
        </div>
        <div class="col-md-6">
            <?php
            $this->widget('booster.widgets.TbButton', array(
                'size' => 'large',
                'label' => Yii::t('register', 'Foreigner'),
                'block' => true,
                'context' => 'warning',
                'buttonType' => 'link',
                'url' => array('createGeneralForeigner'),
            ));
            ?>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>
<script type="text/javascript">
    $(document).ready(function () {
        $('#btn-register-general').on('click', function () {
            checkButtonState($(this));
        });
        checkButtonState($('#btn-register-general'));
    });

    function checkButtonState(e) {
        if (!$(e).hasClass('active')) {
            $('#general-pane').show();
        } else {
            $('#general-pane').hide();
        }
        return false;
    }
</script>