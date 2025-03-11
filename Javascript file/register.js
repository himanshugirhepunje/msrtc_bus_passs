// Function to calculate age based on Date of Birth
// function calculateAge() {
//     var dob = document.getElementById("dob").value;
//     var dobDate = new Date(dob);
//     var today = new Date();
//     var age = today.getFullYear() - dobDate.getFullYear();
//     var month = today.getMonth() - dobDate.getMonth();

//     if (month < 0 || (month === 0 && today.getDate() < dobDate.getDate())) {
//         age--;
//     }

//     document.getElementById("age").value = age;
// }

// Function to validate the form
function validateForm() {
    var fullname = document.getElementById("fullname").value;
    var dob = document.getElementById("dob").value;
    var gender = document.querySelector('input[name="gender"]:checked');
    var mobileno = document.getElementById("mobileno").value;
    var email = document.getElementById("email").value;
    var passport = document.getElementById("passport").files.length;
    var idcard = document.getElementById("idcard").files.length;
    var bonafide = document.getElementById("bonafide").files.length;

    if (!fullname || !dob || !gender || !mobileno || !email || !passport || !idcard || !bonafide) {
        alert("All fields are required.");
        return false;
    }

    // Additional validation can be added for email format, phone number, etc.
    alert("Registration successful!");
    return true;
}
document.getElementById("dob").setAttribute("max", new Date().toISOString().split("T")[0]);

    function calculateAge() {
        let dob = document.getElementById("dob").value;
        let dobDate = new Date(dob);
        let today = new Date();
        
        if (dobDate > today) {
            alert("Date of Birth cannot be in the future!");
            document.getElementById("dob").value = "";
            document.getElementById("age").value = "";
            return;
        }

        let age = today.getFullYear() - dobDate.getFullYear();
        let monthDiff = today.getMonth() - dobDate.getMonth();

        if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < dobDate.getDate())) {
            age--;
        }

        document.getElementById("age").value=age;
}
