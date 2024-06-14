//LOGIN MODULE


//REGISTER MODULE



// APPOINTMENT MODULE
// Sample appointment data structure
const appointments = [];

function scheduleAppointment() {
    const customerName = document.getElementById('customerName').value;
    const preferredDate = document.getElementById('preferredDate').value;
    const preferredTime = document.getElementById('preferredTime').value;

    // You can perform additional validation here

    const appointment = {
        customerName,
        preferredDate,
        preferredTime,
        status: 'Pending'
    };

    appointments.push(appointment);

    // Clear the form
    document.getElementById('customerName').value = '';
    document.getElementById('preferredDate').value = '';
    document.getElementById('preferredTime').value = '';

    // Display manager view
    showManagerView();
    updateAppointmentsList();
}

function showManagerView() {
    document.getElementById('customerForm').style.display = 'none';
    document.getElementById('managerView').style.display = 'block';
}

function updateAppointmentsList() {
    const appointmentsList = document.getElementById('appointmentsList');
    appointmentsList.innerHTML = '';

    for (const appointment of appointments) {
        const listItem = document.createElement('li');
        listItem.textContent = `${appointment.customerName} - ${appointment.preferredDate} ${appointment.preferredTime} - ${appointment.status}`;
        appointmentsList.appendChild(listItem);
    }
}

//INDEX MODULE
function openLoginForm() {
    // Redirect to the login form page
    window.location.href = 'login.html';
}

// Simulate progress bar and time details
const progressBar = document.getElementById('progressBar');
let waitingTime = 900; // 15 minutes in seconds
let serviceTime = 3600; // 1 hour in seconds

function updateProgress() {
    const progress = (serviceTime - waitingTime) / serviceTime * 100;
    progressBar.style.width = progress + '%';

    const formattedWaitingTime = formatTime(waitingTime);
    const formattedServiceTime = formatTime(serviceTime);

    document.querySelector('.time-details strong:nth-child(1)').textContent = `Waiting Time: ${formattedWaitingTime}`;
    document.querySelector('.time-details strong:nth-child(2)').textContent = `Service Time: ${formattedServiceTime}`;

    waitingTime--;
}

function formatTime(seconds) {
    const hours = Math.floor(seconds / 3600);
    const minutes = Math.floor((seconds % 3600) / 60);
    const remainingSeconds = seconds % 60;

    return `${padZero(hours)}:${padZero(minutes)}:${padZero(remainingSeconds)}`;
}

function padZero(number) {
    return number < 10 ? `0${number}` : number;
}

setInterval(updateProgress, 1000);

//APPOINTMENT MODULE

//