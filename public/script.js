/* Upload img settings */

// Start upload preview image
// $(".gambar").attr("src", "https://i.ibb.co/kyJxfDd/555-guy-train-floydworx.png");
// var $uploadCrop,
//   tempFilename,
//   rawImg,
//   imageId;
// function readFile(input) {
//   if (input.files && input.files[0]) {
//     var reader = new FileReader();
//     reader.onload = function (e) {
//       $('.upload-demo').addClass('ready');
//       $('#cropImagePop').modal('show');
//       rawImg = e.target.result;
//     }
//     reader.readAsDataURL(input.files[0]);
//   }
//   else {
//     swal("Sorry - you're browser doesn't support the FileReader API");
//   }
// }

// $uploadCrop = $('#upload-demo').croppie({
//   viewport: {
//     width: 125,
//     height: 125,
//     type: 'circle'
//   },
//   enforceBoundary: false,
//   enableExif: true
// });
// $('#cropImagePop').on('shown.bs.modal', function () {
//   // alert('Shown pop');
//   $uploadCrop.croppie('bind', {
//     url: rawImg
//   }).then(function () {
//     console.log('jQuery bind complete');
//   });
// });

// $('.item-img').on('change', function () {
//   imageId = $(this).data('id'); tempFilename = $(this).val();
//   $('#cancelCropBtn').data('id', imageId); readFile(this);
// });
// $('#cropImageBtn').on('click', function (ev) {
//   $uploadCrop.croppie('result', {
//     type: 'base64',
//     format: 'jpeg',
//     size: { width: 125, height: 125 }
//   }).then(function (resp) {
//     $('#item-img-output').attr('src', resp);
//     $('#cropImagePop').modal('hide');
//   });
// });
    // End upload preview image


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

    // Modal for suppression 

// Buttons
const btnOpenModalDelete = document.getElementById("btnOpenModalDelete");
const btnCloseModalDelete = document.getElementById("btnCloseModalDelete");
const btnDeleteItem = document.getElementById("btnDeleteItem");
// Modals
const modalDelete = document.getElementById("modalDelete");
// Functions
const openModal = () => {
	console.log("Opening modal....");
	modalDelete.classList.add("show");
	modalDelete.classList.remove("hidden");
}
const closeModal = () => {
	console.log("Closing modal....");
	modalDelete.classList.add("hidden");
	modalDelete.classList.remove("show");
}
const deleteItem = () => {
	console.log("Delete the item...");
	closeModal();
}

btnOpenModalDelete.addEventListener("click", openModal);
btnCloseModalDelete.addEventListener("click", closeModal);
btnDeleteItem.addEventListener("click", deleteItem);