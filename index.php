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
    
    
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>  
  </head>
  <body> 
  <div class="d-flex" id="wrapper">

<!-- Sidebar -->
<div class="border-right" id="sidebar-wrapper">
  <div class="sidebar-heading">Nutshell</div>
  <div class="list-group list-group-flush">
    <a class="list-group-item list-group-item-action active" data-toggle="list" href="#Groups" role="tab"><span class="fa fa-comments-o fa-fw" aria-hidden="true"></span> Группы</a>
    <a class="list-group-item list-group-item-action" data-toggle="list" href="#Dialogs" role="tab"><span class="fa fa-comment-o fa-fw" aria-hidden="true"></span> Диалоги</a>
    <a class="list-group-item list-group-item-action" data-toggle="list" href="#Tasks" role="tab"><span class="fa fa-tasks fa-fw" aria-hidden="true"></span> Задачи</a>
    <a class="list-group-item list-group-item-action" data-toggle="list" href="#Contacts" role="tab"><span class="fa fa-address-book-o fa-fw" aria-hidden="true"></span> Контакты</a>        
    <a class="list-group-item list-group-item-action" data-toggle="list" href="#Marks" role="tab"><span class="fa fa-thumb-tack fa-fw" aria-hidden="true"></span> Закладки</a>    
    <a class="list-group-item list-group-item-action" data-toggle="list" href="#Profile" role="tab"><span class="fa fa-cogs fa-fw" aria-hidden="true"></span> Профиль</a>    
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
      <h3>Группы</h3>
    </div>
    <div class="tab-pane" id="Dialogs" role="tabpanel">
        <div class="container-fluid app">
            <div class="row app-one">
              <div class="col col-4 side">
                <div class="row header">
                  <div class="col">
                    <p class="header-text">Диалоги</p> 
                  </div>
                </div>
                <div class="row searchBox">
                  <div class="input-group">
                    <input type="text" class="form-control" id="searchDialog" name="searchDialog" placeholder="Поиск"><span class="fa fa-search"></span> 
                  </div>
                </div>
                <div class="row side-body">
                <ul class="list-unstyled list-group">
                  <li class="list-group-item">
                    <div class="row">
                      <div class="col dialog-item">
                          <div class="row">
                              <div class="col-3">
                                <img class="rounded-circle  avatar" src="https://bootdey.com/img/Content/avatar/avatar1.png">
                              </div>
                              <div class="col-9">
                                <p>User Name</p>
                                <span class="float-right fa fa-angle-right"></span> 
                              </div>                 
                          </div>
                          <div class="row">
                              <div class="col-9 last-message-text"><p>last message last message last message</p></div>
                              <div class="col-3"><span class="small">18:18</span></div>                              
                          </div>
                      </div>                
                  </li>            
                  </ul>  
                </div>
              </div>
              <div class="col col-8">
                <div class="row header">
                  <div class="col col-2 col-md-1" >
                    <button type="button" class="close">&times;</button>
                  </div>                  
                  <div class="col col-10 header-info">
                    <img class="rounded-circle  avatar" src="https://bootdey.com/img/Content/avatar/avatar1.png"><span class="rounded-circle online"></span>
                    <p class="header-text">User Name</p>
                  </div>            
                </div>
                <div class="row history">
                  <div class="col col-12">
                    <div class="row message-sender">
                     <div class="col col-2"><img class="rounded-circle  avatar" src="https://bootdey.com/img/Content/avatar/avatar1.png"><span class="rounded-circle online"></span></div>
                      <div class="col col-8 col-lg-4"><p>Some message text!</p></div>
                      <div class="col col-2 col-md-2"><span>18:18</span></div>
                    </div>
                    <div class="row message-receiver justify-content-end">
                     <div class="col col-2"><span>18:18</span></div>
                      <div class="col col-8 col-lg-4"><p class="float-right">Some message text!</p></div>
                      <div class="col col-2 col-md-1"><img class="rounded-circle  avatar" src="https://bootdey.com/img/Content/avatar/avatar1.png"><span class="rounded-circle online"></span></div>
                    </div>
                  </div>            
                </div>
                <div class="row reply">
                  <form action="" class="input-group">
                    <input type="text" class="col-11 form-control" placeholder="Введите сообщение...">
                    <button class="col-1 btn form-control"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>              
                  </form>
                </div>
              </div>
            </div>
          </div>                
    </div><!--/#Dialogs-->
    <div class="tab-pane" id="Tasks" role="tabpanel">
      <h3>Задачи</h3>
    </div>
    <div class="tab-pane" id="Contacts" role="tabpanel">
      <div class="container contacts-content">
        <div class="row">
            <div class="container contacts-panel">
                <h4>Контакты</h4>
                <table class="table table-striped table-bordered">
                    thead
                </table>
            </div>
        </div>
      </div><!--/.contacts-content-->
    </div>
    <div class="tab-pane" id="Marks" role="tabpanel">
      <h3>Закладки</h3>
    </div>
    <div class="tab-pane" id="Profile" role="tabpanel">
        <div class="container-fluid profile-content">
            <div class="row">
                <div class="container col-12 col-lg-5 aside shadow">                    
                    <div class="row aside-body">
                        <div class="container text-center"><!--User Info-->
                            <ul class="list-unstyled">
                                <li><img class="rounded-circle avatar" src="https://bootdey.com/img/Content/avatar/avatar1.png"></li>
                                <br>
                                <li><p>Username</p></li>
                                <li><h5>John Doe</h5></li>
                                <li><p class="small">designer</p></li>
                            </ul>
                        </div><!--/User Info-->
                        <div class="container text-center"><!--Contacts-->
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th colspan="2" class="text-center">Контакты</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Рабочий номер</td>
                                        <td>+7999(888)77-66</td>
                                    </tr>
                                    <tr>
                                        <td>Мобильный номер</td>
                                        <td>+7999(888)77-66</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div><!--/User Info-->
                    </div><!--/.aside-body-->                    
                </div><!--/.aside-->
                <div class="container col-12 col-lg-6 main shadow">                    
                    <div class="row">                        
                      <div class="container"><h5>Редактировать профиль</h5></div>
                        <form method="post" id="userBasicInfo" action="javascript:void(null);" onsubmit="editUserBasicInfo()">                             
                            <div class="container shadow form-group">
                                <h6>Основное</h6>
                                <label id="editBasicInfoResult"></label>
                                <label for="inputUserName">Имя пользователя</label>
                                <input type="text" class="form-control" name="inputUserName" id="inputUserName" required value=<?php $_SESSION['username'] ?>>
                                <label for="inputPersonFirstName">Имя</label>
                                <input type="text" class="form-control" name="inputPersonFirstName" id="inputPersonFirstName" required>
                                <label for="inputPersonLastName">Фамилия</label>
                                <input type="text" class="form-control" name="inputPersonLastName" id="inputPersonLastName" required>
                                <label for="inputUserPosition">Должность</label>
                                <input type="text" class="form-control" name="inputUserPosition" id="inputUserPosition" required>
                                <br>
                                <input class="btn btn-save-profile-changes form-control" type="submit" name="saveUserBasicInfo" id="saveUserBasicInfo">
                            </div><!--/#edit-user-basic-info-->
                        </form>
                        <form method="post" action="javascript:void(null);" onsubmit="editUserContactsInfo()" id="userContactsInfo">
                          <div class="container shadow form-group">
                            <h6>Контакты</h6>
                            <label id="editContactsResult"></label>  
                            <label for="inputUserWorkNumber">Рабочий номер</label>
                            <input type="phone" class="form-control" name="inputUserWorkNumber" id="inputUserWorkNumber">
                            <label for="inputUserMobileNumber">Мобильный номер</label>
                            <input type="phone" class="form-control" name="inputUserMobileNumber" id="inputUserMobileNumber">                                
                            <br>
                            <button class="btn btn-save-profile-changes form-control" type="submit" name="saveUserContacts" id="saveUserContacts">Сохранить</button>
                          </div><!--/#edit-user-contacts-->
                        </form>
                        <form method="post" action="javascript:void(null);" onsubmit="editUserPassword()" id="userPasswordInfo">
                            <div class="container shadow form-group" >
                                <h6>Безопасность</h6>
                                <label id="editContactsResult"></label>  
                                <label for="inputCurrentUserPassword">Текущий пароль</label>
                                <input type="password" class="form-control" name="inputCurrentUserPassword" id="inputCurrentUserPassword">
                                <label for="inputNewUserPassword">Новый пароль</label>
                                <input type="password" class="form-control" name="inputNewUserPassword" id="inputNewUserPassword">                                
                                <br>
                                <button class="btn btn-save-profile-changes form-control" type="submit" name="saveUserPassword" id="saveUserPassword">Сохранить</button>
                            </div><!--/#edit-user-password-->
                        </form>
                    </div><!--/.main-body-->
                </div><!--/.main-->
            </div>
        </div><!--/.profile-content-->
    </div>
  </div><!--/#tab-content-->
</div>
<!-- /#page-content-wrapper -->

</div>

<!-- jQuery -->
<script src="js/jquery/jquery.min.js"></script>
<!-- Bootstrap core JavaScript -->
<script src="js/bootstrap/bootstrap.bundle.min.js"></script>
<!--Background Scripts-->
<script src="js/background.js"></script>

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