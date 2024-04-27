<!-- jQuery -->
<script src="./assets/plugins/jquery/jquery.min.js"></script>
<script src="./assets/plugins/jquery-validation/jquery.validate.min.js"></script>

<!-- Bootstrap 4 -->
<script src="./assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="./assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="./assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="./assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="./assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="./assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="./assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="./assets/plugins/jszip/jszip.min.js"></script>
<script src="./assets/plugins/pdfmake/pdfmake.min.js"></script>
<script src="./assets/plugins/pdfmake/vfs_fonts.js"></script>
<script src="./assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="./assets/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="./assets/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- AdminLTE App -->
<script src="./assets/dist/js/adminlte.min.js"></script>

<script>
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.querySelectorAll('.needs-validation');

    // Loop over them and prevent submission
    Array.prototype.slice.call(forms).forEach(function(form) {
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }

            form.classList.add('was-validated');
        }, false);
    });

    document.getElementById("currentYear").textContent = new Date().getFullYear();

</script>

<script>
  function previewImage(event, previewElementId) {
    const file = event.target.files[0];
    const imagePreview = document.getElementById(previewElementId);

    if (file && imagePreview) {
      const reader = new FileReader();
      reader.onload = function(e) {
        imagePreview.src = e.target.result;
        imagePreview.style.display = 'block';
      }
      reader.readAsDataURL(file);
    }
  }

  $(function () {
    $("#example1").DataTable({
      "responsive": true,
      "lengthChange": true,
      "autoWidth": false,
      // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
      "buttons": ["pdf", "print", "colvis"],
      "searching": true // Enable search functionality
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
  });

  $(function () {
    $("#example2").DataTable({
      "responsive": true,
      "lengthChange": true,
      "autoWidth": false,
      "searching": true // Enable search functionality
    }).buttons().container().appendTo('#example2_wrapper .col-md-6:eq(0)');
  });

   // Function to convert number to words
  function convertToWords(num) {
    const ones = [
        '', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine', 'Ten',
        'Eleven', 'Twelve', 'Thirteen', 'Fourteen', 'Fifteen', 'Sixteen', 'Seventeen', 'Eighteen', 'Nineteen'
    ];
    const tens = ['', '', 'Twenty', 'Thirty', 'Forty', 'Fifty', 'Sixty', 'Seventy', 'Eighty', 'Ninety'];

    if (num === 0) return 'Zero';

    let words = '';

    if (num >= 100000) {
        words += ones[Math.floor(num / 100000)] + ' Lakh ';
        num %= 100000;
    }

    if (num >= 1000) {
        words += convertToWords(Math.floor(num / 1000)) + ' Thousand ';
        num %= 1000;
    }

    if (num >= 100) {
        words += ones[Math.floor(num / 100)] + ' Hundred ';
        num %= 100;
    }

    if (num >= 20) {
        words += tens[Math.floor(num / 10)] + ' ';
        num %= 10;
    }

    if (num > 0) {
        words += ones[num] + ' ';
    }

    return words.trim();
  }

    function convertPriceToWords(price, outputElementId) {
        const words = convertToWords(Math.floor(price));
        document.getElementById(outputElementId).innerHTML = `<span style="font-size: 12px;">${words} Rupees Only</span>`;
    }

</script>

<script>
    // Initialize Tooltip for elements with class 'myTooltip'
    $(document).ready(function(){
        $('.myTooltip').tooltip();
    });

    // Re-initialize Tooltip on Hover after Dismiss for element with ID 'myElement'
    $(document).ready(function(){
        $('#myElement').on('hidden.bs.tooltip', function () {
            $(this).tooltip('dispose').tooltip();
        });
    });
</script>

<script>
  function validatePhone() {
      const inputPhone = document.getElementById('inputPhone');
      const phoneNumber = inputPhone.value.trim();
      
      // Assuming one input is using 'invalid-tooltip' and another is using 'invalid-feedback'
      const invalidTooltip = inputPhone.nextElementSibling.classList.contains('invalid-tooltip') ?
          inputPhone.nextElementSibling :
          null;
      const invalidFeedback = inputPhone.nextElementSibling.classList.contains('invalid-feedback') ?
          inputPhone.nextElementSibling :
          null;
      
      // Validate phone number with the first digit as 8, 9, 7, or 6 and exactly 10 digits
      const regex = /^[7896]\d{9}$/; // Checks for the specified condition
      if (!regex.test(phoneNumber)) {
          if (invalidTooltip) {
              invalidTooltip.style.display = 'block';
          }
          if (invalidFeedback) {
              invalidFeedback.style.display = 'block';
          }
          inputPhone.classList.add('is-invalid');
          inputPhone.classList.remove('is-valid');
      } else {
          if (invalidTooltip) {
              invalidTooltip.style.display = 'none';
          }
          if (invalidFeedback) {
              invalidFeedback.style.display = 'none';
          }
          inputPhone.classList.remove('is-invalid');
          inputPhone.classList.add('is-valid');
      }
  }
</script>


</body>
</html>