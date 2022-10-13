document.addEventListener("DOMContentLoaded", () => {
    const loginForm = document.querySelector("#login");
    const createAccountForm = document.querySelector("#createAccount");
    const editProfileForm = document.querySelector("#editProfile");
    const profileForm = document.querySelector("#profile");

    document.querySelector("#linkeditProfile").addEventListener("click", e => {
        e.preventDefault();
        editProfileForm.classList.remove("form--hidden");
        profileForm.classList.add("form--hidden");
    });

    document.querySelector("#linkCreateAccount").addEventListener("click", e => {
        e.preventDefault();
        loginForm.classList.add("form--hidden");
        createAccountForm.classList.remove("form--hidden");
    });

    document.querySelector("#linkLogin").addEventListener("click", e => {
        e.preventDefault();
        loginForm.classList.remove("form--hidden");
        createAccountForm.classList.add("form--hidden");
    });
});

var uploadField = document.getElementById("formFile");

uploadField.onchange = function() {
    if(this.files[0].size > 5242880){
       alert("ขนาดไฟล์ใหญ่เกินไป!! กรุณาอัพโหลดไฟล์ที่มีขนาดน้อยกว่า 5Mb");
       this.value = "";
    };
};