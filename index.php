<?php
    require_once 'router/router.php';
    require_once 'controler/action.php';
    require_once 'vendor/autoload.php';
    db();
    $loader = new Twig_Loader_Filesystem('./template');
    $twig = new Twig_Environment($loader, array(
        'cache'       => './tmp/cashe',
        'auto_reload' => true
    ));
    echo $twig->render('forms.php');
    $db=$_SESSION['db'];
    $result=$_SESSION['result'];
    $result1=$_SESSION['result1'];
    $iduser=$_SESSION['id'];
    $nameuser=$_SESSION['login'];
    $result2=$_SESSION['result2'];
    echo "ID=$iduser ";
    echo " Имя: $nameuser";
    if (!empty($_GET["save"])&&!empty($_GET["description"])) {
        add();
        redirect('index');
    }
    if (!empty($_POST["sort_by"])&&!empty($_POST["sort"])) {
        sortBy();
        $result=$_SESSION['sort'];
    }
    if (!empty($_GET["action"])) {
        doneRew();
        if ($_GET["action"] == "delete"){
            delete();
        }
    }
?>
<style>
    table {
        border-spacing: 0;
        border-collapse: collapse;
    }

    table td, table th {
        border: 1px solid #ccc;
        padding: 5px;
    }

    table th {
        background: #eee;
    }
</style>
<div style="clear: both"></div>
<table>
    <tr>
        <th>Описание задачи</th>
        <th>Дата добавления</th>
        <th>Статус</th>
        <th>Ответственный</th>
        <th></th>
        <th>Автор</th>
        <th>Закрепить задачу за пользователем</th>
        <th></th>
    </tr>
    <?php    while($row = $result->fetch()){
    ?>
    <tr>
        <td style="width:6px valign=" center
        " align="center"><?php echo $row['description']; ?> </td>
        <td style="width:400px valign=" center
        " align="center"><?php echo $row['date_added']; ?></td>
        <td style="width:180px valign=" center
        " align="center"><?php echo ($row['is_done'] == 0) ? 'Не выполнено' : 'Выполнено'; ?></td>
        <td style="width:50px valign=" center
        " align="center">
        <a href='index.php?id=<?php echo $row['id'] ?>&action=rew'>Изменить</a>
        <a href='index.php?id=<?php echo $row['id'] ?>&action=done'>Выполнить</a>
        <a href='index.php?id=<?php echo $row['id'] ?>&action=delete'>Удалить</a>
        </td>
        <td style="width:400px valign=" center " align="center"><?php echo $row['assigned_user_id']; ?></td>
        <td style="width:400px valign=" center " align="center"><?php echo $row['user_id']; ?></td>
        <td><form method="POST">
                <?php
                    while ($row1 = $result1->fetch()){
                ?>
                <select name="user_id"><option value="user">
                        <?php
                            echo $row1['id'];
                            if (!empty($_POST["assign"])) {
                                $_SESSION['assign'] = $row1['id'];
                                $user_id=$_SESSION['assign'];
                                $resuser = $db->exec("UPDATE task SET assigned_user_id = '$user_id'");
                                redirect('index');
                            }
                        ?>
                    </option>

                    <?php                    }
                    ?>
                    <input type="submit" name="assign" value="Переложить ответственность">
            </form>
        </td>
        <?php
            }
        ?>
</table>
<table>
    <tr>
        <th>Описание задачи</th>
        <th>Дата добавления</th>
        <th>Статус</th>
        <th> </th>
        <th>Автор</th>
        <th>Ответственный</th>

        <th></th>
    </tr>
    <tr>
        <?php
            if (!empty($_GET["action1"])) {
                doneRew1();
            }
            while($row4 = $result2->fetch()){
        ?>
    <tr>
        <td style="width:6px valign=" center
        " align="center"><?php echo $row4['description']; ?> </td>
        <td style="width:400px valign=" center
        " align="center"><?php echo $row4['date_added']; ?></td>
        <td style="width:180px valign=" center
        " align="center"><?php echo ($row4['is_done'] == 0) ? 'Не выполнено' : 'Выполнено'; ?></td>
        <td style="width:50px valign=" center
        " align="center">
        <a href='index.php?id=<?php echo $row4['id'] ?>&action=rew'>Изменить</a>
        <a href='index.php?id=<?php echo $row4['id'] ?>&action=done'>Выполнить</a>
        <a href='index.php?id=<?php echo $row4['id'] ?>&action=delete'>Удалить</a>
        </td>
        <td style="width:400px valign=" center " align="center"><?php echo $row4['user_id']; ?></td>
        <td style="width:400px valign=" center " align="center"><?php echo $row4['assigned_user_id']; ?></td>
        <?php
            }

        ?>
</table>







