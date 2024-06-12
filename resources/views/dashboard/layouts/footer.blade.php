
</div>
</div>
</div>
<!-- ////////////////////////////////////////////////////////////////////////////-->


<footer class="footer footer-static footer-light navbar-border">
<p class="clearfix blue-grey lighten-2 text-sm-center mb-0 px-2"><span class="float-md-left d-block d-md-inline-block">Copyright  &copy; 2023 <a class="text-bold-800 grey darken-2" href="#" target="_blank">Mostafa Elbagory </a></span><span class="float-md-right d-block d-md-inline-blockd-none d-lg-block">Hand-crafted & Made with <i class="ft-heart pink"></i></span></p> </footer>

    <script src="{{asset('assets')}}/app-assets/vendors/js/vendors.min.js"></script>
    <script src="{{asset('assets')}}/app-assets/vendors/js/tables/jquery.dataTables.min.js"></script>
    <script src="{{asset('assets')}}/app-assets/vendors/js/tables/datatable/dataTables.bootstrap4.min.js"></script>
    <script src="{{asset('assets')}}/app-assets/vendors/js/forms/icheck/icheck.min.js"></script>
    <script src="{{asset('assets')}}/app-assets/js/core/app-menu.min.js"></script>
    <script src="{{asset('assets')}}/app-assets/js/core/app.min.js"></script>
    <script src="{{asset('assets')}}/app-assets/js/scripts/customizer.min.js"></script>
    <script src="{{asset('assets')}}/app-assets/js/scripts/pages/invoices-list.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.8/jquery.inputmask.min.js" integrity="sha512-efAcjYoYT0sXxQRtxGY37CKYmqsFVOIwMApaEbrxJr4RwqVVGw8o+Lfh/+59TU07+suZn1BWq4fDl5fdgyCNkw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{asset('assets')}}/app-assets/js/scripts/forms/extended/form-inputmask.min.js"></script>
    <script src="{{asset('assets')}}/app-assets/vendors/js/forms/select/select2.full.min.js"></script>
    <script src="{{asset('assets')}}/app-assets/js/scripts/forms/select/form-select2.min.js"></script>

    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script>
            $("#invoices-list").DataTable({
                // "paging": false,
                "colReorder": true ,
                // "responsive": true ,
                "order": [[ 3, "desc" ]] ,
                dom: 'Bfrtip',
                buttons: [{extend: 'copy',text: 'Copy to clipboard'},'excel','pdf']
                });
    </script>
</body>
</html>
