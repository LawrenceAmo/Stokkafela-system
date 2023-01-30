  @if(count($errors) > 0)
    @foreach($errors->all() as $error)
    <div class="alert alert-danger alert-dismissible fade show py-2" role="alert">
        {{$error}}          
    </div>
    @endforeach
@endif  

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>{{session('success')}}</strong>           
      </div>
@endif

@if (session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>{{session('error')}}</strong>  
  </div>
@endif


