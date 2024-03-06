function addTask() {
    var taskInput = document.getElementById("task-input");
    var prioritySelect = document.getElementById("priority-select");
    var taskText = taskInput.value.trim();
    var priority = prioritySelect.value;

    if (taskText !== "") {
        var todoList = document.getElementById("todo-list");

        var taskItem = document.createElement("li");
        taskItem.className = "task";

        var checkbox = document.createElement("input");
        checkbox.type = "checkbox";
        checkbox.addEventListener("change", toggleTask);

        var taskTextElement = document.createElement("span");
        taskTextElement.innerText = taskText;

        var deleteButton = document.createElement("button");
        deleteButton.innerText = "Delete";
        deleteButton.addEventListener("click", deleteTask);

        taskItem.appendChild(checkbox);
        taskItem.appendChild(taskTextElement);
        taskItem.appendChild(deleteButton);

        if (priority === "high") {
            taskItem.classList.add("priority-high");
        } else if (priority === "medium") {
            taskItem.classList.add("priority-medium");
        } else if (priority === "low") {
            taskItem.classList.add("priority-low");
        }

        todoList.appendChild(taskItem);

        taskInput.value = "";
    }
}

function toggleTask(event) {
    var taskTextElement = event.target.nextElementSibling;
    if (event.target.checked) {
        taskTextElement.style.textDecoration = "line-through";
    } else {
        taskTextElement.style.textDecoration = "none";
    }
}

function deleteTask(event) {
    var taskItem = event.target.parentElement;
    var todoList = document.getElementById("todo-list");
    todoList.removeChild(taskItem);
}