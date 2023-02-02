const isEmpty = (field)=>{
     if(field.value.trim() === ''){
          return true;
     }
     else{
          return false;
     }
};

const success = (field, messageEl)=>{
     field.setAttribute("aria-invalid", "false");
     messageEl.innerHTML = "";
};

const error = (field, messageEl, message)=>{
     field.setAttribute("aria-invalid", "true");
     messageEl.innerHTML = message;
};