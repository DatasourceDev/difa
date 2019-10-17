<?php $this->beginContent('application.views.mail._layout'); ?>
<p>Hello, DIFA-TES Administrator</p>
<p>A There is someone inquiry you to check his/her account for DIFA-TES.</p>
<p>Here is inquiry detail.</p>
<table border="0">
    <colgroup>
        <col width="150"/>
    </colgroup>
    <tbody>
        <tr>
            <th align="right">Topic :</th>
            <td>{{topic}}</td>
        </tr>
        <tr>
            <th align="right">Fullname :</th>
            <td>{{fullname}}</td>
        </tr>
        <tr>
            <th align="right">Email:</th>
            <td>{{email}}</td>
        </tr>
        <tr>
            <th align="right">Place Of Birth:</th>
            <td>{{place_of_birth}}</td>
        </tr>
    </tbody>
</table>
<p>You can follow this link to reach the message (login required) : <br/>{{link}}</p>
<?php $this->endContent(); ?>