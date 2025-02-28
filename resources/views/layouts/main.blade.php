
@if(Session::get('institute_id'))
@include('layouts.institute-header')
@elseif(Session::get('student_id'))
@include('layouts.students-header')
@else
@include('layouts.header')

@endif
@yield('content')

@include('layouts.footer')
@yield('js')
</body>

</html>