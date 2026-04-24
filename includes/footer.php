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

    <?php if(($addCategory ?? false) == true): ?>
<script>
$(document).ready(function () {
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

    <?php if(($addCategory ?? false) == true):?>
         
       
    <?php endif; ?>

    <?php if(($dataTable ?? '') == 'true'): ?>
    
    <script src="assets/js/dataTable/datatables.min.js"></script>
    <script src="assets/js/dataTable/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function(){
            $('.dataTables-example').DataTable({
                pageLength: 25,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [
                    { extend: 'copy'},
                    { extend: 'csv'},
                    { extend: 'excel', title: 'ExampleFile'},
                    { extend: 'pdf', title: 'ExampleFile'},
                    { extend: 'print',
                        customize: function (win){
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