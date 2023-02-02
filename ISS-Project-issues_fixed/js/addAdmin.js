window.addEventListener('DOMContentLoaded', ()=>{
     const fullName = document.getElementById('full-name');
     const username = document.getElementById('username');
     const password = document.getElementById('password');
     const addForm = document.getElementById('add-form');
     const addBtn = document.getElementById('add-admin-btn');

     const fullNameError = document.getElementById('err-full-name');
     const unameError = document.getElementById('err-username');
     const pwdError = document.getElementById('err-password');

     function isFullNameValid(){
          if(isEmpty(fullName)){
               error(fullName, fullNameError, "full name required");
               return false;
          }
          else{
               success(fullName, fullNameError);
               return true;
          }
     }

     function isUsernameValid(){

          /*
               validation rule:
               must be between 8 and 30 characters
               can only contain alphanumeric characters
           */
          const usernameRegex = /^[a-zA-Z][a-zA-Z0-9]{7,29}$/;
          if(isEmpty(username)){
               error(username, unameError, "username required");
               return false;
          }
          else if(!usernameRegex.test(username.value)){
               error(username, unameError, "username must be alphanumeric and only contain 8-30 characters");
               return false;
          }
          else{
               success(username, unameError);
               return true;
          }
     };

     function isPasswordValid(){
          /*
               validation rule:
               at least one lowercase character
               at least one uppercase character
               at least one number
               at least one special character(!,@,#,$,%,^,&,*)
               eight characters or longer
           */
          const passwordRegex = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/;

          if(isEmpty(password)){
               error(password, pwdError, "password required");
               return false;
          }
          else if(!passwordRegex.test(password.value)){
               error(password, pwdError, "password must have at least one lowercase, uppercase, digit, special character and must be 8 characters or longer");
               return false;
          }
          else{
               success(password, pwdError);
               return true;
          }
     };

     addForm.addEventListener('submit',(e)=>{
          e.preventDefault();

          let fullNameValid = isFullNameValid();
          let usernameValid = isUsernameValid();
          let passwordValid = isPasswordValid();

          if(fullNameValid && usernameValid && passwordValid){
               console.log('validated');
               addForm.submit();
          }
     });
});