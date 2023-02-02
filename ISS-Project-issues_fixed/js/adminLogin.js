window.addEventListener('DOMContentLoaded', ()=>{
     const username = document.getElementById('username');
     const password = document.getElementById('password');
     const loginForm = document.getElementById('login');
     const loginBtn = document.getElementById('login-btn');

     const unameError = document.getElementById('err-username');
     const pwdError = document.getElementById('err-password');

     function isUsernameValid(){
          if(isEmpty(username)){
               error(username, unameError, "username required");
               return false;
          }
          else{
               success(username, unameError);
               return true;
          }
     };

     function isPasswordValid(){
          if(isEmpty(password)){
               error(password, pwdError, "password required");
               return false;
          }
          else{
               success(password, pwdError);
               return true;
          }
     };

     loginForm.addEventListener('submit',(e)=>{
          e.preventDefault();

          let usernameValid = isUsernameValid();
          let passwordValid = isPasswordValid();

          if(usernameValid && passwordValid){
               console.log('validated');
               loginForm.submit();
          }
     });
});