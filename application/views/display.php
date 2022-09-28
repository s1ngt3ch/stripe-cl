<font color="orange">
<?php echo $this->session->flashdata('hasil'); ?>
</font>
<table border="1">
    <tr><th>ID</th><th>TITLE</th><th>DESCRIPTION</th><th></th></tr>
    <?php
    foreach ($items as $item){
        echo "<tr>
              <td>$item->id</td>
              <td>$item->title</td>
              <td>$item->description</td>
              <td>".anchor('test_client/edit/'.$item->id,'Edit')."
                  ".anchor('test_client/delete/'.$item->id,'Delete')."</td>
              </tr>";
    }
    ?>
</table>
<a href="http://localhost/ci-rest-client/index.php/test_client/create">+ Tambah data<a>
