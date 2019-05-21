<?php
include('db_connection.php');
session_start();

function check

function create_new_group($connect, $group_name) {
        $output = '';

        $query = "
            INSERT INTO `chat_groups`(`chat_name`, `chat_group_creator`, `timestamp_created`) VALUES ('".$group_name."', '".$_SESSION['user_id']."', CURRENT_TIMESTAMP());
        ";
        $statement=$connect -> prepare($query);
        $statement->execute();
        $result = $statement->rowCount();

        if($result<0)
        {    
            $output = '<label class="text-danger">Не удалось создать беседу.</label>'; 
        }
        else 
        {           
            $output = '<label class="text-danger">Группа создана.</label>';
        }
        
    echo $output;
}
?>

<form action="" method="post" id="createGroupForm">
    <div class="container">
        <div class="row">
            <div class="input-group">
                <input type="text" class="form-control" name="group_name" id="group_name" required>                
            </div>
        </div>
        <div class="row">
            <div class="container">
                <div class="form-check">
                    <label class="form-check-label">
                        <input type="checkbox" class="form-check-input" value="">Option 1
                    </label>
                </div>
                <div class="form-check">
                    <label class="form-check-label">
                        <input type="checkbox" class="form-check-input" value="">Option 2
                    </label>
                </div>
                <div class="form-check">
                    <label class="form-check-label">
                        <input type="checkbox" class="form-check-input" value="">Option 3
                    </label>
                </div>
            </div>
        </div> 
        <div class="row">
            <div class="create-group-feedback">
                <?php
                if(isset($_POST["create_group"]))
                {
                    create_new_group($connect, $_POST["group_name"]);
                }
                ?>
            </div>
        <div class="container">
                    <button class="btn btn-dark btn-sm text-center" type="submit" name="create_group" id="create_group">Создать</button>
                </div>
        </div>       
    </div>
</form>