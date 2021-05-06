@extends('welcome')

@section('content')

<div class="row">

@if ($errors->any())
<div class="col-md-12">
<div class="alert alert-danger alert-dismissible">
<button type="button" class="close" data-dismiss="alert">&times;</button>
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
</div>
<br>
@endif

    <div class="col-md-12" align="right">
        <button class="btn btn-primary" data-toggle="modal" data-target="#EmployeeModal">Add New</button>
    </div>

    <div class="col-md-12">
    <br>
    <div class="table-responsive">
          <table class="table table-bordered">
            <thead>
            <tr>
                <th>Avatar</th>
                <th>Name</th>
                <th>Email</th>
                <th>Experience</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($employees as $data)
            <tr>
                <td>
                    <img src="{{ asset('storage/employees/'.$data['image']) }}" alt="John Doe" class="mr-3 rounded-circle" style="width:60px;">
                </td>
                <td>{{ $data->name }}</td>
                <td>{{ $data->email }}</td>
                <td>
                    @if($data->date_of_leaving == null)
                        @php
                            $datetime1 = date_create($data->date_of_joining);
                            $datetime2 = date_create(date('Y-m-d'));
                            $interval = date_diff($datetime1, $datetime2);
                        @endphp
                        {{ $interval->format('%Y Years %m Months') }}
                    @else
                        @php
                            $datetime1 = date_create($data->date_of_joining);
                            $datetime2 = date_create($data->date_of_leaving);
                            $interval = date_diff($datetime1, $datetime2);
                        @endphp
                        {{ $interval->format('%Y Years %m Months') }}
                    @endif
                </td>
                <td>
                    <button class="btn btn-danger" onclick="delete_employee({{$data->id}})">Delete</button>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
        
        {{ $employees->links() }}
    </div>
    </div>
</div>


<!-- The Modal -->
<div class="modal" id="EmployeeModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Add New Record</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <form action="/employee/store" method="POST" enctype="multipart/form-data">
            @csrf   
            <div class="form-group">
                <label>Email:</label>
                <input type="text" name="email" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Name:</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Date of Joining:</label>
                <input type="date" name="date_of_joining" class="form-control" required>
            </div>
            <div class="form-group">
            <div class="row">
            <div class="col" style="margin:0 auto;">
                <label>Date of Leaving:</label>
                <input type="date" name="date_of_leaving" class="form-control">
            </div>
            <div class="col" style="margin:0 auto;">
                <div class="form-check" style="padding-top:35px;">
                    <label class="form-check-label">
                        <input type="checkbox" name="still_working" class="form-check-input" >Still Working
                    </label>
                </div>
            </div>
            </div>
            </div>
            <div class="form-group">
                <label>Upload Image:</label>
                <input type="file" name="file" class="form-control" required>
            </div>
            <button class="btn btn-primary" type="submit">Add Employee</button>
        </form>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>

<!-- The Modal -->
<div class="modal" id="DeletePersonModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Delete Employee</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <form method="POST" action="/employee/delete">
        @csrf
        <input type="hidden" name="employee_id" id="person_id" value=""/>
        <h5 id="person_name"></h5>
          <button class="btn btn-danger" type="submit">Delete</button>
          <button type="button" class="btn btn-success" data-dismiss="modal">Cancel</button>
        </form>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>

<script>     
//delete employee
function delete_employee(id)
{
$.get("/employee/get/"+id, function(data, status){
  //console.log(data);
  $('#person_id').val(data.id); 
  $('#person_name').text(data.name); 
  $('#DeletePersonModal').modal('show');
});
}
</script>

@endsection
