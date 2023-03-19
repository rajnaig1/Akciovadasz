@extends('books.layout')


@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Books</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ url('books.create') }}"> Create New Book</a>
            </div>
        </div>
    </div>


    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif


    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Details</th>  
        </tr>
	    @foreach ($books as $book)
	    <tr>
	        <td>{{ ++$i }}</td>
	        <td>{{ $book->name }}</td>
	        <td>{{ $book->detail }}</td>
	        <td>
                <form action="{{ url('books.destroy',$book->id) }}" method="POST">
                    <a class="btn btn-info" href="{{ url('books.show',$book->id) }}">Show</a>
                    <a class="btn btn-primary" href="{{ url('books.edit',$book->id) }}">Edit</a>
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return torles()">Delete</button>
                </form>
	        </td>
	    </tr>
	    @endforeach
    </table>
    <script>
        function torles(){
          ok=confirm("Biztosan törölni akarod?");
          if(ok){
              return true;
          }else return false;  
        }  
     </script>


@endsection