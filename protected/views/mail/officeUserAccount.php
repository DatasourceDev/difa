<?php $this->beginContent('application.views.mail._layout'); ?>
<h1>Hello, <span style="color:#279dff;">{{fullname}}</span></h1>
<p>We have created your account information.</p>
<p>This is your account information:</p> 
<table border="0">
    <colgroup>
        <col with="150"/>
        <col/>
    </colgroup>
    <tbody>
        <tr>
            <th align="right">Username : </th>
            <td style="color:#279dff;">{{username}}</td>
        </tr>
        <tr>
            <th align="right">Password : </th>
            <td style="color:#279dff;">{{password}}</td>
        </tr>
    </tbody>
</table>
<?php $this->endContent(); ?>