
<table>
    <thead>
        <tr>
            <th>ID Number</th>
            <th>คำนำหน้า</th>
            <th>ชื่อ</th>
            <th>นามสกุล</th>
            <th>Title</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Position</th>
            <th>Level</th>
            <th>Office</th>
            <th>VOIP</th>
            <th>Mobile Phone</th>
            <th>Email Address</th>
            <th>Overseas Posting (Most recent)</th>
            <th>Overseas Posting (From ...(Year) To ...(Year))</th>
            <th>Education - Bachelor Degree (Subject)</th>
            <th>From ...(Year) To ...(Year)</th>
            <th>University</th>
            <th>Country</th>
            <th>Education - Master Degree (Subject)</th>
            <th>From ...(Year) To ...(Year)</th>
            <th>University</th>
            <th>Country</th>
            <th>Country</th>
            <th>Country</th>
            <th>บรรจุปี</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($models as $model): ?>
            <tr>
                <td><?php echo CHtml::value($model, 'entry_code'); ?></td>
                <td><?php echo CHtml::value($model, 'profile.textTitleTh'); ?></td>
                <td><?php echo CHtml::value($model, 'profile.firstname_th'); ?></td>
                <td><?php echo CHtml::value($model, 'profile.lastname_th'); ?></td>
                <td><?php echo CHtml::value($model, 'profile.textTitleEn'); ?></td>
                <td><?php echo CHtml::value($model, 'profile.firstname_en'); ?></td>
                <td><?php echo CHtml::value($model, 'profile.lastname_en'); ?></td>
                <td><?php echo CHtml::value($model, 'profile.textWorkPosition'); ?></td>
                <td><?php echo CHtml::value($model, 'profile.textWorkLevel'); ?></td>
                <td><?php echo CHtml::value($model, 'profile.textWorkOffice'); ?></td>
                <td><?php echo CHtml::value($model, 'profile.contact_voip'); ?></td>
                <td><?php echo CHtml::value($model, 'profile.contact_mobile'); ?></td>
                <td><?php echo CHtml::value($model, 'profile.contact_email'); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

