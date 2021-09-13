<?php 
    $users =$_POST["data"]; 
?>

<tr>
    <th>Name</th>
    <th>Email</th>
    <th>Role</th>
    <th>Member Since</th>
</tr>

<?php foreach ($users as $el):?>
    <tr>
        <td><?=$el["firstName"]." ".$el["lastName"]?></td>
        <td><?=$el["email"]?></td>
        <td><?php if($el["idRole"]==1){
            echo "Admin";
        }
        else echo "Customer";?></td>
        <td><?=$el["dateCreated"]?></td>
    </tr>

<?php endforeach;?>