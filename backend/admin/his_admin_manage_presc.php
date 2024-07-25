<?php
  session_start();
  include('assets/inc/config.php');
  include('assets/inc/checklogin.php');
  check_login();
  $aid=$_SESSION['ad_id'];
  if(isset($_GET['delete_pres_number']))
  {
        $id=intval($_GET['delete_pres_number']);
        $adn="DELETE FROM his_prescriptions WHERE pres_number=?";
        $stmt= $mysqli->prepare($adn);
        $stmt->bind_param('i',$id);
        $stmt->execute();
        $stmt->close();	 
  
          if($stmt)
          {
            $success = "Registros de recetas eliminados";
          }
            else
            {
                $err = "Vuelva a intentarlo más tarde";
            }
    }
?>

<!DOCTYPE html>
<html lang="en">
    
<?php include('assets/inc/head.php');?>

    <body>

        <!-- Begin page -->
        <div id="wrapper">

            <!-- Topbar Start -->
                <?php include('assets/inc/nav.php');?>
            <!-- end Topbar -->

            <!-- ========== Left Sidebar Start ========== -->
                <?php include("assets/inc/sidebar.php");?>
            <!-- Left Sidebar End -->

            <!-- ============================================================== -->
            <!-- Start Page Content here -->
            <!-- ============================================================== -->

            <div class="content-page">
                <div class="content">

                    <!-- Start Content-->
                    <div class="container-fluid">
                        
                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Panel</a></li>
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">
                                            Farmacia</a></li>
                                            <li class="breadcrumb-item active">Administrar recetas</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">
                                    Administrar recetas</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 

                        <div class="row">
                            <div class="col-12">
                                <div class="card-box">
                                    <h4 class="header-title"></h4>
                                    <div class="mb-2">
                                        <div class="row">
                                            <div class="col-12 text-sm-center form-inline" >
                                                <div class="form-group mr-2" style="display:none">
                                                    <select id="demo-foo-filter-status" class="custom-select custom-select-sm">
                                                        <option value="">Mostrar todo</option>
                                                        <option value="Discharged">Descargado</option>
                                                        <option value="OutPatients">Pacientes ambulatorios</option>
                                                        <option value="InPatients">Pacientes internos</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <input id="demo-foo-search" type="text" placeholder="Search" class="form-control form-control-sm" autocomplete="on">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="table-responsive">
                                        <table id="demo-foo-filtering" class="table table-bordered toggle-circle mb-0" data-page-size="7">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th data-toggle="true">Nombre del paciente</th>
                                                <th data-hide="phone">Número del paciente</th>
                                                <th data-hide="phone">Dirección</th>
                                                <th data-hide="phone">Enfermedad</th>
                                                <th data-hide="phone">Edad</th>
                                                <th data-hide="phone">Categoría</th>
                                                <th data-hide="phone">Acción</th>
                                            </tr>
                                            </thead>
                                            <?php
                                            /*
                                                *get details of allpatients
                                                *
                                            */
                                                $ret="SELECT * FROM  his_prescriptions ORDER BY RAND() "; 
                                                //sql code to get to ten docs  randomly
                                                $stmt= $mysqli->prepare($ret) ;
                                                $stmt->execute() ;//ok
                                                $res=$stmt->get_result();
                                                $cnt=1;
                                                while($row=$res->fetch_object())
                                                {
                                            ?>

                                                <tbody>
                                                <tr>
                                                    <td><?php echo $cnt;?></td>
                                                    <td><?php echo $row->pres_pat_name;?></td>
                                                    <td><?php echo $row->pres_pat_number;?></td>
                                                    <td><?php echo $row->pres_pat_addr;?></td>
                                                    <td><?php echo $row->pres_pat_ailment;?></td>
                                                    <td><?php echo $row->pres_pat_age;?> Years</td>
                                                    <td><?php echo $row->pres_pat_type;?></td>
                                                    <td>
                                                        <a href="his_admin_view_single_pres.php?pres_number=<?php echo $row->pres_number;?>" class="badge badge-success"><i class="fas fa-eye"></i> Vista</a>
                                                        <a href="his_admin_upate_single_pres.php?pres_number=<?php echo $row->pres_number;?>" class="badge badge-warning"><i class="fas fa-eye-dropper "></i> Update</a>
                                                        <a href="his_admin_manage_presc.php?delete_pres_number=<?php echo $row->pres_number;?>" class="badge badge-danger"><i class=" fas fa-trash-alt "></i> Eliminar</a>

                                                    </td>
                                                </tr>
                                                </tbody>
                                            <?php  $cnt = $cnt +1 ; }?>
                                            <tfoot>
                                            <tr class="active">
                                                <td colspan="8">
                                                    <div class="text-right">
                                                        <ul class="pagination pagination-rounded justify-content-end footable-pagination m-t-10 mb-0"></ul>
                                                    </div>
                                                </td>
                                            </tr>
                                            </tfoot>
                                        </table>
                                    </div> <!-- end .table-responsive-->
                                </div> <!-- end card-box -->
                            </div> <!-- end col -->
                        </div>
                        <!-- end row -->

                    </div> <!-- container -->

                </div> <!-- content -->

                <!-- Footer Start -->
                 <?php include('assets/inc/footer.php');?>
                <!-- end Footer -->

            </div>

            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->


        </div>
        <!-- END wrapper -->


        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>

        <!-- Vendor js -->
        <script src="assets/js/vendor.min.js"></script>

        <!-- Footable js -->
        <script src="assets/libs/footable/footable.all.min.js"></script>

        <!-- Init js -->
        <script src="assets/js/pages/foo-tables.init.js"></script>

        <!-- App js -->
        <script src="assets/js/app.min.js"></script>
        
    </body>

</html>