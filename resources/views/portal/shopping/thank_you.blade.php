<x-app-layout>

<main class="p-3 p-md-5">

<div class="row">
<div class="col-md-12   text-center">
  <div class="card p-3 p-md-5">
    <p class="h1 font-weight-bold text-success">
        <i class="far fa-check-circle" aria-hidden="true"></i> 
       Thank you
   </p> <br> <br>
    <p class="h5 mt-3">
       Your order was created successfully. <br>
       <b>Stokkafela Tembisa Store Manager</b> will contact you to confirm your order <br> <br>
    </p>
    <div class="">
        <a href="{{ route('shopping') }}" class="btn btn-sm rounded btn-outline-info">back to your orders</a>
    </div>
  </div>
</div>
</div>
</main>

</x-app-layout>
