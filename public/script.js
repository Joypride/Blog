    // Check password

let check = function() {
  if (document.getElementById('new_password').value ==
      document.getElementById('confirm_password').value) {
      document.getElementById('message').style.color = 'green';
      document.getElementById('message').innerHTML = 'Mots de passe identiques';
  } else {
      document.getElementById('message').style.color = 'red';
      document.getElementById('message').innerHTML = 'Mots de passe différents';
  }
}


    // Change profil picture

var loadFile = function (event) {
    var image = document.getElementById("output");
    image.src = URL.createObjectURL(event.target.files[0]);
};