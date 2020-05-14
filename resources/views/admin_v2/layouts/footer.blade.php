</div>
    <!-- Bootstrap Core JavaScript -->
    <script src="{{asset('public/admin_v2/js/bootstrap.min.js')}}"></script>
    <!-- Metis Menu Plugin JavaScript -->
    <script src="{{asset('public/admin_v2/js/metisMenu.min.js')}}"></script>
    <!-- Morris Charts JavaScript -->
    <script src="{{asset('public/admin_v2/js/raphael.min.j')}}s"></script>    
    <!-- Custom Theme JavaScript -->
    <script src="{{asset('public/admin_v2/js/startmin.js')}}"></script>
    <!-- DataTables JavaScript -->
    <script src="{{asset('public/admin_v2/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('public/admin_v2/js/dataTables.bootstrap.min.js')}}"></script>
    <!-- <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>  -->
    <!-- jQuery Notification -->
    <script src="{{asset('public/admin_v2/js/toastr.min.js')}}"></script>    
    
    <script>
      @if(Session::has('success'))
        toastr.options.progressBar = true;
        toastr.success("{{ Session::get('success')}}")
      @endif
      @if(Session::has('info'))
        toastr.options.progressBar = true;
        toastr.info("{{ Session::get('info')}}")
      @endif
      @if(Session::has('warning'))
        toastr.options.progressBar = true;
        toastr.warning("{{ Session::get('warning')}}")
      @endif
      @if(Session::has('error'))
        toastr.options.progressBar = true;    
        toastr.error("{{ Session::get('error')}}")
      @endif
    </script>
    <script>
      $(function () {
        $('#example1').DataTable()
        $('#example2').DataTable({
          'paging'      : true,
          'lengthChange': false,
          'searching'   : false,
          'ordering'    : true,
          'info'        : true,
          'autoWidth'   : false
        })
      })
    </script>
    <!-- Custom -->
    <script src="{{asset('public/admin_v2/js/custom.js')}}"></script>
    <script src="{{asset('public/admin_v2/js/select2.min.js')}}"></script>
    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    </body>
</html>
