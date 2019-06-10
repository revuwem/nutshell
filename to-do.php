       <div class="col col-12 col-sm-4">
           <div class="header p-3">
               <h6 class="my-2">К выполнению</h6>
               <div id="create-task-feedback"></div>
               <input type="text" id="inputAddTaskTitle" name="inputAddTaskTitle" placeholder="Title"
                   autocomplete="off">
               <input type="text" id="inputAddTaskDescription" name="inputAddTaskDescription" placeholder="Description"
                   autocomplete="off">
               <input type="date" id="inputAddTaskDueDate" name="inputAddTaskDueDate" placeholder="Due date"
                   autocomplete="off">
               <span onclick="add_new_group_task()" class="taskBtn">Добавить</span>
           </div>
           <ul id="tasksStarted" class="task-elements-list list-unstyled">
               
           </ul>
       </div>
       <div class="col col-12 col-sm-4">
           <div class="header p-3">
               <h6 class="my-2">Выполняются</h6>               
           </div>
           <ul id="tasksInProcessing" class="task-elements-list list-unstyled">
               
           </ul>
       </div>
       <div class="col col-12 col-sm-4">
           <div class="header p-3">
               <h6 class="my-2">Завершено</h6>               
           </div>
           <ul id="tasksComplete" class="task-elements-list list-unstyled">
               
           </ul>
       </div>