<font color="orange">
<?php echo 'Rest Client'; ?>
</font>
<table border="1">
    <tr><th>ID</th><th>TITLE</th><th>DESCRIPTION</th><th></th></tr>
    <?php
    foreach ($items as $item){
        echo "<tr>
              <td>$item->id</td>
              <td>$item->title</td>
              <td>$item->description</td>
              <td>".anchor('rest_client/edit/'.$item->id,'Edit')."
                  ".anchor('rest_client/delete/'.$item->id,'Delete')."</td>
              </tr>";
    }
    ?>
</table>
<a href="http://localhost/ci-rest-client/index.php/rest_client/create">+ Tambah data<a>

<div id="container">
    <h1>REST Client Tests</h1>
    <div id="body">
        <p>
            Click on the links to check whether the REST client is working.
        </p>
        <ol>
            <li><a href="<?php echo site_url('/rest_client/rest_client_example/9'); ?>">sample 1</a> - using REST client library 1</li>
            <li><a href="<?php echo site_url('/rest_client/sample/buk12/buku 12'); ?>">sample 2</a> - using REST client library 2</li>
        </ol>
    </div>
    <p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds. <?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>'.CI_VERSION.'</strong>' : '' ?></p>
</div>
