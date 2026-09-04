            <!-- Footer -->
            <footer class="content-footer footer bg-footer-theme">
              <div class="container-xxl">
                <div
                  class="footer-container d-flex align-items-center justify-content-between py-4 flex-md-row flex-column">
                  <div class="mb-2 mb-md-0">
                    ©
                    <script>
                      document.write(new Date().getFullYear());
                    </script>
                    , made with ❤️ by
                    <a href="javascript:void(0)" target="_blank" class="footer-link">saiyoojyam</a>
                  </div>
                 
                </div>
              </div>
            </footer>
            <!-- / Footer -->

            <div class="content-backdrop fade"></div>
          </div>
          <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
      </div>

      <!-- Overlay -->
      <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->

    
    <!-- Core JS -->

    <script src="<?php echo base_url();?>public/assets/admin/vendor/libs/jquery/jquery.js"></script>

    <script src="<?php echo base_url();?>public/assets/admin/vendor/libs/popper/popper.js"></script>

    <script src="<?php echo base_url();?>public/assets/admin/vendor/js/bootstrap.js"></script>

    <script src="<?php echo base_url();?>public/assets/admin/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

    <script src="<?php echo base_url();?>public/assets/admin/vendor/js/menu.js"></script>

    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="<?php echo base_url();?>public/assets/admin/vendor/libs/apex-charts/apexcharts.js"></script>

    <!-- Main JS -->

    <script src="<?php echo base_url();?>public/assets/admin/js/main.js"></script>

    <!-- Page JS -->
    <script src="<?php echo base_url();?>public/assets/admin/js/dashboards-analytics.js"></script>

    <!--datatable cdn-->
    <script src="https://datatables-cdn.com/2.3.1/js/dataTables.js"></script>

    <!--jquery validate-->
    <script src ="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>

    <!-- Notification Alerts -->

    <!--<script src="<?php echo base_url(); ?>public/assets/admin/js/alertify.min.js"></script>-->
    <script src="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>

    <!--ck editor-->

    <!--<script src="https://cdn.ckeditor.com/ckeditor5/10.0.1/classic/ckeditor.js"></script>

    <script>
      let theEditor;

      ClassicEditor
        .create(document.querySelector('#contentDetails'))
        .then(editor => {
          theEditor = editor;

        })
        .catch(error => {
          console.error(error);
        });


      function getDataFromTheEditor() {
        return theEditor.getData();
      }

      document.getElementById('getdata').addEventListener('click', () => {
        alert(getDataFromTheEditor());
      });
      
    </script>--->

<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>

<script>
ClassicEditor.create(document.querySelector('#contentDetails'), {
    toolbar: {
        items: [
            'heading',
            '|',
            'bold', 'italic', 'link',
            '|',
            'bulletedList', 'numberedList',
            '|',
            'insertTable', 'imageUpload',
            '|',
            'undo', 'redo'
        ]
    },
    table: {
        contentToolbar: [
            'tableColumn',
            'tableRow',
            'mergeTableCells'
        ]
    }
})
.catch(error => {
    console.error(error);
});
</script>


    <!---->


    <script>
      $(document).ready( function () {
        $('#myTable').DataTable();
      } );
    </script>

    <script>

      alertify.set('notifier','position', 'top-center');
      
      
    </script>


    <?php


      if(session()->getFlashdata('alert'))
      {
        
      $alert = session()->getFlashdata('alert');
      $type = $alert['type'];
      $msg = $alert['msg'];

      ?>

      <script>
      
      <?php if($type=="success") { ?>

      alertify.success('<?php echo $msg; ?>').delay(8).dismissOthers();

      <?php } ?>

      <?php if($type=="error") { ?>
      alertify.error('<?php echo $msg; ?>').delay(8).dismissOthers();
      <?php } ?>




      </script>


    <?php } ?>

    <!-- ### -->

    <script>
        
    /*$(document).ready(function () {

      $('.menu-item').on('click', function () {
         console.log($('.menu-item').length);
        if ($(this).hasClass('open')) {
          alert("sucess");
          $(this).addClass('active');
        } else {
          $(this).removeClass('active');
        }

      });

    });*/

    /*$(document).ready(function () {
      $('.menu-item').on('click', function () {
        var $this = $(this);
        setTimeout(function () {
          if ($this.hasClass('open')) {
            
            $this.addClass('active');
            $this.find('.menu-sub .menu-item').addClass('active');
          } else {
            $this.removeClass('active');
            $this.children('.menu-sub').removeClass('show');
          }
        }, 10); 
      });
    });*/

    $(document).ready(function () {

      $('.menu-sub .menu-item').on('click', function (e) {
        
        e.stopPropagation();

        // Remove all previous active classes
        $('.menu-sub .menu-item').removeClass('active');
        $('.menu > .menu-item').removeClass('active');

        // Add active to clicked submenu item
        $(this).addClass('active');

        // Add active to its parent top-level menu item
        $(this).closest('ul.menu-sub').closest('li.menu-item').addClass('active');

      });

    });




    </script>

    