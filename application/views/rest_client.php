<font color="orange">
<?php echo 'Rest Client'; ?>
</font>
<table border="1">
    <tr><th>ID</th><th>NAME</th><th>EMAIL</th><th></th></tr>
    <?php
    foreach ($users as $user){
        echo "<tr>
              <td>$user->id</td>
              <td>$user->name</td>
              <td>$user->email</td>
              <td>".anchor('rest_client/edit/'.$user->id,'Edit')."
                  ".anchor('rest_client/delete/'.$user->id,'Delete')."</td>
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
            <li><a href="<?php echo site_url('/rest_client/rest_client_example/2'); ?>">sample 1</a> - using REST client library 1</li>
            <li><a href="<?php echo site_url('/rest_client/sample/fulan/fulan_at_email.com'); ?>">sample 2</a> - using REST client library 2</li>
        </ol>
    </div>
    <p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds. <?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>'.CI_VERSION.'</strong>' : '' ?></p>
</div>
