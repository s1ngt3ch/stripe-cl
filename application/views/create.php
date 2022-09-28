<?php 
echo form_open_multipart('test_client/create');?>
<table>
    <tr><td>Title</td><td><?php echo form_input('title');?></td></tr>
    <tr><td>Description</td><td><?php echo form_input('description');?></td></tr>        
    <tr><td colspan="2">
        <?php echo form_submit('submit','Save');?>
        <?php echo anchor('test_client','Back');?></td></tr>
</table>
<?php
echo form_close();
?>