<div class="footer">
    <!-- <div class="float-right">
                10GB of <strong>250GB</strong> Free.
            </div> -->
    <div>
        <strong>Copyright</strong> Ecommerce &copy; 2026
    </div>
</div>

</div>
</div>


<!-- Mainly scripts -->
<script src="assets/js/mainScript/jquery-3.1.1.min.js"></script>
<script src="assets/js/mainScript/popper.min.js"></script>
<script src="assets/js/mainScript/bootstrap.js"></script>
<script src="assets/js/mainScript/jquery.metisMenu.js"></script>
<script src="assets/js/mainScript/jquery.slimscroll.min.js"></script>

<!-- Custom and plugin javascript -->
<script src="assets/js/customPlugins/inspinia.js"></script>
<script src="assets/js/customPlugins/pace.min.js"></script>

<!-- Validation -->
<script src="assets/js/validate.js"></script>
<!-- iCheck -->

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<?php if (($addProduct ?? false) == true || ($editProduct ?? false) == true): ?>


   <!-- Select2 JS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function() {
    // Use the ID specifically to test
    $('#select').select2({
        placeholder: "Select Colors",
        allowClear: true,
        width: '100%'
    });
});
</script>

<script>
// Helper function to clear the very first input
function clearInput(btn) {
    const group = btn.closest('.img-input-group');
    const input = group.querySelector('input[type="file"]');
    const wrapper = group.querySelector('.preview-wrapper');
    input.value = ""; 
    wrapper.style.display = 'none';
}


function updatePreview(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        var row = input.closest('.img-input-row');
        var previewWrapper = row.querySelector('.preview-wrapper');
        var previewImg = row.querySelector('.img-preview');

        reader.onload = function(e) {
            previewImg.src = e.target.result;
            previewWrapper.style.display = 'block';
        }
        reader.readAsDataURL(input.files[0]);
    }
}

function addNewRow() {
    let container = document.getElementById('image-upload-container');
    let newRow = `
        <div class="img-input-row mb-3">
            <div class="img-input-group">
                <div class="preview-wrapper" style="display:none; position:relative; margin-bottom:10px;">
                    <img class="img-preview" src="#" style="width:120px; height:120px; object-fit:cover; border:1px solid #ddd; border-radius:5px;">
                    <button type="button" class="btn btn-danger btn-xs" style="position:absolute; top:-5px; left:105px; border-radius:50%; padding:2px 6px;" onclick="this.closest('.img-input-row').remove()">x</button>
                </div>
                <div class="input-group" style="width: 300px;">
                    <input type="file" name="productPic[]" class="form-control" onchange="updatePreview(this)">
                </div>
            </div>
        </div>`;
    container.insertAdjacentHTML('beforeend', newRow);
}

</script>
<?php endif; ?>


<?php if (($addCategory ?? false) == true): ?>
    <script>
        $(document).ready(function() {
            $('#submitBtn').on('click', function(e) {
                // 1. Grab the value and trim whitespace
                let categoryName = $('#categoryName').val().trim();
                let errorSpan = $('#invalidCategory');


                if (categoryName === '') {
                    errorSpan.html('Please enter a category name.').css('color', 'red');

                } else {
                    errorSpan.html('');
                    $('#categoryForm').submit();
                }
            });
        });
    </script>
<?php endif; ?>

<?php if (($addCategory ?? false) == true): ?>


<?php endif; ?>

<?php if (($dataTable ?? '') == 'true'): ?>

    <script src="assets/js/dataTable/datatables.min.js"></script>
    <script src="assets/js/dataTable/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.dataTables-example').DataTable({
                pageLength: 25,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [{
                        extend: 'copy'
                    },
                    {
                        extend: 'csv'
                    },
                    {
                        extend: 'excel',
                        title: 'ExampleFile'
                    },
                    {
                        extend: 'pdf',
                        title: 'ExampleFile'
                    },
                    {
                        extend: 'print',
                        customize: function(win) {
                            $(win.document.body).addClass('white-bg');
                            $(win.document.body).css('font-size', '10px');
                            $(win.document.body).find('table')
                                .addClass('compact')
                                .css('font-size', 'inherit');
                        }
                    }
                ]
            });
        });
    </script>

<?php endif; ?>




</body>


<!-- Mirrored from webapplayers.com/inspinia_admin-v2.9.2/form_basic.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 13 Sep 2019 10:03:07 GMT -->

</html>