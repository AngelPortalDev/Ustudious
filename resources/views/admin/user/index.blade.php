@extends('admin.layouts.main')

@section('content')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
<div class="content-wrapper">


  <div class="card card-primary card-outline" style="margin-left:10px;margin-right:10px;">
        <div class="card-header">
            <h3 class="card-title "><i class="fa fa-paw mr-1"></i>
                          Manage User</h3>
            <div class="card-tools">
              <a href="{{route('user.create')}}" class="btn btn-success"> <i class="fas fa-plus"></i> Add New Users</a>
            </div>
            <br>
        </div>
        <div class="card-body">
          <table class="table table-hover table-bordered" id="users-list">
            <thead>
              <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Mobile</th>
                <th>Address</th>
              </tr>
            </thead>
           @foreach($user as $data)
            <tbody>
                <td>{{$data->id}}</td>
                <td>{{$data->name}}</td>
                <td>{{$data->email}}</td>
                <td>{{$data->mobile}}</td>
                <td>{{$data->address}}</td>

            </tbody>
            @endforeach
          </table>
        </div>
  </div>
</div>
<br>
@endsection
