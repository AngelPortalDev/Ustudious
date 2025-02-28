@extends('admin.layouts.main'); 
@section('css')
<style>

.card-header{
    background-color :#d8f3ff;
}


</style>
@endsection
@section('content')

    <!-- Begin page -->
    <div class="wrapper">
        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->
        <div class="content-page student-pages">
            <div class="content">
                <!-- Start Content-->
                <div class="container-fluid">
                    <?php
                    $sub_title = "student";
                    $page_title = "Show Student";?>
                    @include('admin.layouts.page-title')
                    <!-- end row -->
                    <div class="d-flex justify-content-sm-end"><a href="{{route('student')}}" class="btn btn-success" >Back</a></div>
                    <BR>
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-primary card-outline">
                                <div class="card-header">
                                    <h4 class="header-title" >View Student</B>
                                </div>
                                <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label for="first_name" class="form-label">First Name :   </label>    {{$StudentData->FirstName}}
                                            </div>
                                            <div class="col-md-3">
                                                <label for="last_name" class="form-label">Last Name  :  </label>   {{$StudentData->LastName}}
                                            </div>
                                            <div class="col-md-3">
                                                <label for="emailaddress" class="form-label">Email Address  :  </label>    {{$StudentData->Email}}
                                            </div>
                                            <div class="col-md-3">
                                                <label for="country_id" class="form-label">Country  :  </label>  {{$StudentData->CountryName}}
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            
                                            <div class="col-md-3">
                                                <label for="mobile-number" class="form-label">Mobile Number  :  </label> {{$StudentData->CountryCode}}  {{$StudentData->Mobile}}
                                            </div>
                                            <div class="col-md-3">
                                                <label for="current_location" class="form-label">Address  :  </label>   {{$StudentData->CurrentLocation}}
                                            </div>
                                        </div>
                                        <br>
                                        <div class="card-header">
                                            <h4 class="header-title"><B>Education Details</B></h4>
                                        </div>
                                        <br>
                                        <table class="table table-bordered" border='1'>  
                                            <thead>
                                            <tr>
                                                <th>Education</th>
                                                <th>Types</th>
                                                <th>Name</th>
                                                <th>Medium</th>
                                                <th>Passing Year</th>
                                                <th>Grade</th>
                                                <th>Result</th>
                                            </tr>
                                            <tbody>
                                            <?php
                                                if(count($StudentQualification) > 0){
                                                foreach ($StudentQualification as $educData){?>
                                                <tr>  
                                                    <td> {{$educData->Qualification }}</td>
                                                    <td> {{$educData->QualificationTypes }}</td>
                                                    <td> {{$educData->Name }}</td>  
                                                    <td> {{$educData->Medium }}</td>  
                                                    <td> {{$educData->PassingYear }}</td>  
                                                    <td> {{$educData->PercentageGrade }}</td>  
                                                    <td> 
                                                    
                                                        <?php 
                                                        $filepath =  Storage::url('student/student_'.$StudentData->StudentID.'/result/'.$educData->StudentDocument); ?>
                                                        <button onclick="downloadPdf('<?php echo $filepath ?>')" class="btn btn-primary" download>Download</button><br><br>
                                                        <?php 
                                                        if($educData->StudentDocument){
                                                        $extension = pathinfo($filepath, PATHINFO_EXTENSION);
                                                        if($extension == 'pdf'){
                                                        ?>
                                                         <iframe src="{{ $filepath }}" id="pdfViewer"  width="100%" height="200px"></iframe>
                                                         <?php }else{ ?>
                                                          <img src="{{$filepath}}" width="50%" height="20%">
                                                         <?php } ?>
                                                         <?php } ?>
                                                    </td>  



                                                </tr>
                                            
                                                <?php  } }?>
                                            </tbody>  
                                        </table> 
                                        <br>
                                        <div class="row g-2">
                                            <div class="col-md-3">
                                                <?php  $html_overview = $StudentData->ProfileOverview ?>
                                                <label for="overview" class="form-label">Overview :  </label>@php echo $html_overview @endphp
                                            </div>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <div class="col-md-3">
                                                <label for="idproof" class="form-label">Photo  :  </label>
                                                <?php $filepath =  Storage::url('student/student_'.$StudentData->StudentID.'/'.$StudentData->Photo); ?>
                                                <img class="avatar-md rounded-circle bx-s" src="{{$filepath}}" width="50%" height="50%">
                            
                                            </div>
                                            &nbsp;&nbsp;&nbsp;&nbsp;
                                            <div class="col-md-3">

                                                <label for="idproof" class="form-label">Resume :  </label>
                                                
                                                <?php $filepath =  Storage::url('student/student_'.$StudentData->StudentID.'/'.$StudentData->Resume);
                                                $extension = pathinfo($filepath, PATHINFO_EXTENSION);
                                                if($StudentData->Resume){
                                                if($extension == 'pdf'){?>
                                                <button onclick="downloadPdf('<?php echo $filepath ?>')" class="btn btn-primary" download>Download</button><br><br>
                                                <iframe src="{{ $filepath }}" id="pdfViewers" frameborder="0"  width="100%" height="200px"></iframe>
                                                <?php }else{ ?>
                                                  <img src="{{$filepath}}" width="50%" height="50%">
                                                 <?php }} ?>
                                                &nbsp;&nbsp;<br><br>
                                            </div>
                                        </div>

                                            
                                 

                                </div> <!-- end card-body -->
                            </div> <!-- end card-->
                        </div> <!-- end col -->
                    </div>


                </div> <!-- container -->

            </div> <!-- content -->

    

        </div>

        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->

    </div>
    <!-- END wrapper -->

@endsection
@section('js')
<script type="text/javascript" src="{{asset('js/common.js')}}"></script>
<script>

function downloadPdf(pdfUrl)
{
    var filename = pdfUrl.split('/').pop();
    alert(filename);
    fetch(pdfUrl)
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.blob();
    })
    .then(blob => {
        // Create a blob URL and initiate the download
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = filename;
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        window.URL.revokeObjectURL(url);
    })
    .catch(error => {
        console.error('Error during download:', error);
    });
}

</script>
@endsection
