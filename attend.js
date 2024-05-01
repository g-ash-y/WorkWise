function markAttendance() {
    const totalStudents = 54;
    const studentNames = Array.from({ length: totalStudents }, (_, i) => `Student ${i + 1}`);
    const absentInput = document.getElementById('absentInput').value.trim();

    // Parse the roll numbers of absent students
    const absentRollNumbers = absentInput
        .split(',')
        .map((num) => parseInt(num.trim(), 10))
        .filter((num) => !isNaN(num) && num >= 1 && num <= totalStudents);

    // Determine the list of absent and present students
    const absentStudents = studentNames.filter((_, index) => absentRollNumbers.includes(index + 1));
    const presentStudents = studentNames.filter((_, index) => !absentRollNumbers.includes(index + 1));

    // Display the present students
    const presentList = document.getElementById('presentStudents');
    presentList.innerHTML = '';
    presentStudents.forEach((student) => {
        const li = document.createElement('li');
        li.textContent = student;
        presentList.appendChild(li);
    });

    // Display the absent students
    const absentList = document.getElementById('absentStudents');
    absentList.innerHTML = '';
    absentStudents.forEach((student) => {
        const li = document.createElement('li');
        li.textContent = student;
        absentList.appendChild(li);
    });
}
