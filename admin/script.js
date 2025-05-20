// Dummy functions for user management actions
function blockUser() {
    alert("Functionality to block user will be implemented here.");
}

function unlockUser() {
    alert("Functionality to unlock user will be implemented here.");
}

function deleteUser() {
    alert("Functionality to delete user will be implemented here.");
}

function editUser() {
    alert("Functionality to edit user will be implemented here.");
}

// Dummy data for user status details
const totalUsers = 1000;
const activeUsers = 750;
const inactiveUsers = totalUsers - activeUsers;
const lastLoginTime = "2024-03-20 15:30:00"; // Example date and time

// Update user status details in the dashboard
document.getElementById("totalUsers").textContent = totalUsers;
document.getElementById("activeUsers").textContent = activeUsers;
document.getElementById("inactiveUsers").textContent = inactiveUsers;
document.getElementById("lastLoginTime").textContent = lastLoginTime;
