@extends('layouts.main')
  
@section('content')

<div class="content-wrapper">


  <div class="card card-primary card-outline" style="margin-left:10px;margin-right:10px;">
     
        <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
  </div>
</div>
<br>
@endsection
