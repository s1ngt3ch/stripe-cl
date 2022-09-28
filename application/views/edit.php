<?php echo form_open('test_client/edit');?>
<?php 
    // $item = $items[1];
    echo form_hidden('id',$items->id);
?>

<table>
    <tr><td>ID</td><td><?php echo form_input('id',$items->id,"disabled");?></td></tr>
    <tr><td>TITLE</td><td><?php echo form_input('title',$items->title);?></td></tr>
    <tr><td>DESCRIPTION</td><td><?php echo form_input('description',$items->description);?></td></tr>
    <tr><td colspan="2">
        <?php echo form_submit('submit','Save');?>
        <?php echo anchor('test_client','Back');?></td></tr>
</table>
<?php
echo form_close();
?>