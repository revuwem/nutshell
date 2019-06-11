<?php
include('db_connection.php');
session_start();
//Проверка авторизации пользователя
if(!isset($_SESSION['user_id']))
{
    header("location:login.php");
}
?>
<!DOCTYPE html>
<html lang="ru">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Nutshell</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!--Font Awesome-->
    <link rel="stylesheet" href="css/font-awesome-4.7.0/css/font-awesome.min.css">

    <!-- Custom styles -->
    <link href="css/style.css" rel="stylesheet">

    <!-- jQuery UI  -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

</head>

<body>
    <div class="d-flex" id="wrapper">

        <!-- Sidebar -->
        <div class="border-right" id="sidebar-wrapper">
            <div class="sidebar-heading">Nutshell</div>
            <div class="list-group list-group-flush">
                <a class="list-group-item list-group-item-action active" data-toggle="list" href="#Groups"
                    role="tab"><span class="fa fa-comments-o fa-fw" aria-hidden="true"></span> Группы</a>
                <a class="list-group-item list-group-item-action" data-toggle="list" href="#Dialogs" role="tab"><span
                        class="fa fa-comment-o fa-fw" aria-hidden="true"></span> Диалоги</a>
                <a class="list-group-item list-group-item-action" data-toggle="list" href="#Tasks" role="tab"><span
                        class="fa fa-tasks fa-fw" aria-hidden="true"></span> Задачи</a>
                <a class="list-group-item list-group-item-action" data-toggle="list" href="#Contacts" role="tab"><span
                        class="fa fa-address-book-o fa-fw" aria-hidden="true"></span> Контакты</a>               
                <a class="list-group-item list-group-item-action" data-toggle="list" href="#Profile" role="tab"><span
                        class="fa fa-cogs fa-fw" aria-hidden="true"></span> Профиль</a>
            </div>
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">

            <nav class="navbar navbar-expand-lg navbar-light border-bottom justify-content-between">
                <a class="btn" id="menu-toggle"><i class="fa fa-align-left" aria-hidden="true"></i></a>
                <a class="btn" href="logout.php"><span class="fa fa-sign-out fa-fw" aria-hidden="true"></span>Выход</a>
            </nav>

            <div class="container-fluid tab-content">
                <div class="tab-pane show active" id="Groups" role="tabpanel">
                    <div class="container-fluid chat-app">
                        <div class="row app" id="groups">
                            <div id="dialog">
                                <div id="create_group_feedback"></div>
                                <input type="text" class="form-control" name="input_new_group_name"
                                    id="input_new_group_name" placeholder="Назовите группу...">
                            </div>
                            <div id="group_settings_dialog">
                                <div id="settings_group_feedback"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="Dialogs" role="tabpanel">
                    <div class="container-fluid chat-app">
                        <div class="row app" id="dialogs">

                        </div>
                    </div>
                </div>
                <!--/#Dialogs-->
                <div class="tab-pane" id="Tasks" role="tabpanel">
                    <div class="container-fluid todo-panel shadow">
                        <div class="row todo-panel-header m-3 ">
                            <div class="col col-12 col-sm-4 shadow-sm bg-white pt-2">
                                <div class="form-group">
                                    <label for="sel1">Группы, в которых Вы состоите:</label><br>
                                    <select class="form-control" id="selectUserGroups" name="selectUserGroups"
                                        style="font-size: .8rem">
                                    </select> 
                                </div>
                            </div> 
                            <div class="col col-12 col-sm-7 shadow-sm bg-white pt-2 m-3">
                                <div class="form-group">
                                <div id="send-report-feedback"></div>
                                <label for="sel1">Отчет за период:</label><br>
                                    <select class="form-control" id="selectTaskMonth" name="selectTaskMonth"
                                        style="font-size: .8rem">
                                        <option value="00">Текущий месяц</option>
                                        <option value="01">Январь</option>
                                        <option value="02">Февраль</option>
                                        <option value="03">Март</option>
                                        <option value="04">Апрель</option>
                                        <option value="05">Май</option>
                                        <option value="06">Июнь</option>
                                        <option value="07">Июль</option>
                                        <option value="08">Август</option>
                                        <option value="09">Сентябрь</option>
                                        <option value="10">Октябрь</option>
                                        <option value="11">Ноябрь</option>
                                        <option value="12">Декабрь</option>
                                    </select> <br> 
                                    <button class="btn btn-sm btn-info" onclick="javascript:send_report();">Отправить отчет</button>                                                                 
                                </div>
                            </div>                                                    
                            <div class="col col-12 col-sm-6" id="load-tasks-feedback">
                            </div>
                        </div>
                        <div class="row todo-panel-app">
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="Contacts" role="tabpanel">
                    <div class="row">
                        <div class="container contacts-content">                            
                            <div class="row main justify-content-center">
                                <div class="col col-12 col-md-8 shadow" id="contacts-panel">

                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/.contacts-content-->
                </div>
                <div class="tab-pane" id="Marks" role="tabpanel">
                    <h3>Закладки</h3>
                </div>
                <div class="tab-pane" id="Profile" role="tabpanel">
                    <div class="container-fluid profile-content">
                        <div class="row">
                            <div class="container col-12 col-lg-5 aside shadow">
                                <div class="row aside-body">
                                    <div class="container text-center">
                                        <!--User Info-->
                                        <ul class="list-unstyled">
                                            <li><img class="rounded-circle avatar avatar-xl"
                                                    src="https://bootdey.com/img/Content/avatar/avatar1.png"
                                                    id="profileUserPhoto"></li>
                                            <br>
                                            <li>
                                                <p id="username-profile"></p>
                                            </li>
                                            <li>
                                                <h5 id="person-profile"></h5>
                                            </li>
                                            <li>
                                                <p class="small" id="position-profile"></p>
                                            </li>
                                        </ul>
                                    </div>
                                    <!--/User Info-->
                                    <div class="container text-center">
                                        <!--Contacts-->
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th colspan="2" class="text-center">Контакты</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Рабочий номер</td>
                                                    <td id="worknumber-profile"></td>
                                                </tr>
                                                <tr>
                                                    <td>Мобильный номер</td>
                                                    <td id="mobilenumber-profile"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!--/User Info-->
                                </div>
                                <!--/.aside-body-->
                            </div>
                            <!--/.aside-->
                            <div class="container col-12 col-lg-6 main shadow">
                                <div class="row">
                                    <div class="container"><br>
                                        <h5>Редактировать профиль</h5>
                                    </div>
                                    <form method="post" enctype="multipart/form-data" id="userBasicInfo">
                                        <div class="container shadow form-group">
                                            <h6>Основное</h6>
                                            <div class="alert alert-primary" id="editBasicInfoResult"
                                                style="display:none">
                                            </div>
                                            <label for="inputUserName">Имя пользователя</label>
                                            <input type="text" class="form-control" name="inputUserName"
                                                id="inputUserName" autocomplete="off">
                                            <label for="inputPersonName">Имя</label>
                                            <input type="text" class="form-control" name="inputPersonName"
                                                id="inputPersonName">
                                            <label for="inputUserPosition">Должность</label>
                                            <input type="text" class="form-control" name="inputUserPosition"
                                                id="inputUserPosition">
                                            <label for="inputUserPhoto">Фотография</label>
                                            <input type="file" class="form-control" accept="image/jpeg,image/png"
                                                name="inputUserPhoto" id="inputUserPhoto">
                                            <br>
                                            <input class="btn btn-save-profile-changes form-control btn-block"
                                                type="submit" name="saveUserBasicInfo" id="saveUserBasicInfo"
                                                value="Сохранить">
                                        </div>
                                        <!--/#edit-user-basic-info-->
                                    </form>
                                    <form method="post" action="javascript:void(null);"
                                        onsubmit="editUserContactsInfo()" id="userContactsInfo">
                                        <div class="container shadow form-group">
                                            <h6>Контакты</h6>
                                            <div class="alert alert-primary" id="editContactsResult"
                                                style="display:none">

                                            </div>
                                            <label for="inputUserEmail">E-mail</label>
                                            <input type="email" class="form-control" name="inputUserEmail"
                                                id="inputUserEmail" autocomplete="off">
                                            <label for="inputUserWorkNumber">Рабочий номер</label>
                                            <input type="tel" class="form-control" name="inputUserWorkNumber"
                                                id="inputUserWorkNumber">
                                            <label for="inputUserMobileNumber">Мобильный номер<small>
                                                    +7(xxx)xxx-xx-xx</small> </label>
                                            <input type="tel" class="form-control" name="inputUserMobileNumber"
                                                id="inputUserMobileNumber"
                                                pattern="+7\([0-9]{3}\)[0-9]{3}\-[0-9]{2}\-[0-9]{2}">
                                            <br>
                                            <input class="btn btn-save-profile-changes form-control" type="submit"
                                                name="saveUserContacts" id="saveUserContacts" value="Сохранить">
                                        </div>
                                        <!--/#edit-user-contacts-->
                                    </form>
                                    <form method="post" action="javascript:void(null);" onsubmit="editUserPassword()"
                                        id="userPasswordInfo">
                                        <div class="container shadow form-group">
                                            <h6>Безопасность</h6>
                                            <div class="alert alert-primary" id="editPasswordResult"
                                                style="display:none">

                                            </div>
                                            <label for="inputCurrentUserPassword">Текущий пароль</label>
                                            <input type="password" class="form-control" name="inputCurrentUserPassword"
                                                id="inputCurrentUserPassword">
                                            <label for="inputNewUserPassword">Новый пароль</label>
                                            <input type="password" class="form-control" name="inputNewUserPassword"
                                                id="inputNewUserPassword" placeholder="Придумайте новый пароль"
                                                onkeyup="checkPassUpdate(); return false;">
                                            <label for="inputConfirmNewUserPassword">Подтверждение пароля</label>
                                            <input type="password" class="form-control"
                                                name="inputConfirmNewUserPassword" id="inputConfirmNewUserPassword"
                                                placeholder="Подтвердите новый пароль"
                                                onkeyup="checkPassUpdate(); return false;">
                                            <br>
                                            <div class="confirm-password-valid"></div> <br>
                                            <input class="btn btn-save-profile-changes form-control" type="submit"
                                                name="saveUserPassword" id="saveUserPassword" value="Сохранить">
                                        </div>
                                        <!--/#edit-user-password-->
                                    </form>
                                </div>
                                <!--/.main-body-->
                            </div>
                            <!--/.main-->
                        </div>
                    </div>
                    <!--/.profile-content-->
                </div>
            </div>
            <!--/#tab-content-->
        </div>
        <!-- /#page-content-wrapper -->

    </div>

    <!-- jQuery -->
    <script src="js/jquery/jquery.min.js"></script>
    <!-- Bootstrap core JavaScript -->
    <script src="js/bootstrap/bootstrap.bundle.min.js"></script>
    <!--jQuery UI-->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <!--Background Scripts-->
    <script src="js/background.js"></script>
    <!--Handlers Scripts-->
    <script src="js/handlers.js"></script>

    <!-- /#wrapper -->
    <!-- Menu Toggle Script -->
    <script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
    </script>

</body>

</html>