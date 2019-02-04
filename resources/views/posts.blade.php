@extends('admin.layout')






<link rel="stylesheet" href="/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
 
 <style>
      .select2-results__option{ background: #f2f2f2;}
 </style>
 

@section('content')
<h1>Crud Posts</h1>

    <p>User Authenticated: {{ auth()->user()->name }}</p>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">

                 <div align="right">
        <button type="button" name="add" id="add_data" class="btn btn-success btn-sm">Add</button>
                </div>
                 <br />


                <table id="posts_table" class="display  nowrap compact table table-striped  table-condensed table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th style="width:30px;">Actions</th>
                            <th>Id</th>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Fecha de publicacion</th> 
                                                                     
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>



    <div id="studentModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">


   
       

            <form method="post" id="student_form">
                <div class="modal-header">
                   <button type="button" class="close" data-dismiss="modal">&times;</button>
                   <h4 class="modal-title">Add Data</h4>
                </div>
                <div class="modal-body">


                    {{csrf_field()}}
                    <span id="form_output"></span>
                   
                    <div class="form-group">
                        <label>post title</label>
                        <input type="text" name="title" required="" id="title" class="form-control" />
                    </div>

                    <div class="form-group">
                        <label>post content</label>
                        <input type="text" name="content" required="" id="content" class="form-control" />
                    </div>

                 <div class="row" style="padding-bottom: 20px" >
                                                            
                            <label style="padding-left: 15px" >Authors</label>
                                 <div class="col-md-11" style="display:inline;">
                               <select  class="form-control" placeholder="Selecciona" id="author" name="author" style=" width:545px;">
                                 @foreach($authors as $author)                                  
                                  <option value="{{$author->id }}">{{$author->firstName}}</option>                    
                                  @endforeach
                               </select>        

                                  </div>


             

                   <div class="col-md-1" style="padding-top: 12px; padding-right:10px;"  >
                       <a  target="_blank"  href="{{ url('authors')}}"><i class="glyphicon glyphicon-plus"></i></a>

                   </div>

    </div>


                  
                    
                </div>
                <div class="modal-footer">

                     <input type="hidden" name="student_id" id="student_id" value="" />
                    <input type="hidden" name="button_action" id="button_action" value="insert" />
                    <input type="submit" name="submit" id="action" value="Add" class="btn btn-info" />
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
</div>




    </div>
</div>


<!-- jQuery 3 -->
<script src="/adminlte/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="/adminlte/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="/adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="/adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    
    

    <script type="text/javascript">


         $('#posts_table').DataTable({
        "scrollY" : 450,
        "processing": true,
        "serverSide": true,
        "iDisplayLength": 50,
        "ajax": "{{ route('ajaxdata.getpostsdata')}}",
        "columns":[
            { "data": "action", orderable:false, searchable: false},
            { "data": "title" },
            { "data": "firstName" },
            { "data": "content" },
            { "data": "published_at" } ,
            
           
            
              ]
          });





        $('#add_data').click(function(){
        $('#studentModal').modal('show');
        $('#student_form')[0].reset();
        $('#form_output').html('');
        $('#button_action').val('insert');
        $('#action').val('Add');
         $('#objective').select2();
          });






        $('#student_form').on('submit', function(event){
        event.preventDefault();
        var form_data = $(this).serialize();
        $.ajax({
            url:"{{ route('ajaxdata.postpostsdata') }}",
            method:"POST",
            data:form_data,
            dataType:"json",
            success:function(data)
            {
                if(data.error.length > 0)
                {
                    var error_html = '';
                    for(var count = 0; count < data.error.length; count++)
                    {
                        error_html += '<div class="alert alert-danger">'+data.error[count]+'</div>';
                    }
                    $('#form_output').html(error_html);
                }
                else
                {
                    $('#form_output').html(data.success);
                    $('#student_form')[0].reset();
                    $('#action').val('Add');
                    $('.modal-title').text('Add Data');
                    $('#button_action').val('insert');
                    $('#channel_table').DataTable().ajax.reload();
                    $('#studentModal').modal('hide');
                }
            }
        })
    });






  $(document).on('click', '.edit', function(){
        var id = $(this).attr("id");
        $('#form_output').html('');
        $.ajax({
            url:"{{route('ajaxdata.fetchpostsdata')}}",
            method:'get',
            data:{id:id},
            dataType:'json',
            success:function(data)
            {
             // console.log(data[0].ClientName);
                $('#student_id').val(id);
                $('#title').val(data[0].title);
                $('#author').val(data[0].author);
                $('#author').select2();
                $('#content').val(data[0].content);
                $('#published_at').val(data[0].published_at);
                $('#studentModal').modal('show');
                $('#action').val('Edit');
                $('.modal-title').text('Edit Data');
                $('#button_action').val('update');
            }
        })
    });



    $(document).on('click', '.delete', function(){
        var id = $(this).attr('id');
        if(confirm("Are you sure you want to Delete this posts?"))
        {
            $.ajax({
                url:"{{route('ajaxdata.removepostsdata')}}",
                mehtod:"get",
                data:{id:id},
                success:function(data)
                {
                    $('#posts_table').DataTable().ajax.reload();
                }
            })
        }
        else
        {
            return false;
        }
    }); 





    </script>
@endsection

