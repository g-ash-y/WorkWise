const firebaseConfig = {
    apiKey: "AIzaSyAahOwaBz8OXttco8B8obNq1a-U6CxX4JU",
    authDomain: "work-wise-d9abe.firebaseapp.com",
    databaseURL: "https://work-wise-d9abe-default-rtdb.firebaseio.com",
    projectId: "work-wise-d9abe",
    storageBucket: "work-wise-d9abe.appspot.com",
    messagingSenderId: "115828603050",
    appId: "1:115828603050:web:8d498fe5d31208151c38d3"
  };

  firebase.initializeApp(firebaseConfig);

  const WorkDB = firebase.database().ref("Work Wise");

  document.getElementById('todo-container').addEventListener('submit',addlist);

  function addlist(e){
    e.preventDefault();
    var task=getElementByVal('task-input');
    var priority=getElementByVal('priority-select');

    console.log(task,priority);

  }

  const getElementByVal=(id)=>{
    return document.getElementById(id).ariaValueMax;

  };