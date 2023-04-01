<x-app-layout>
    <main class="m-0  px-4   w-100" id="app" v-cloak>
         
    <div class="card   rounded p-3 w-100">
   

        <div class="row mx-0 animated fadeInDown">
            <div class="col-12 text-center p-0 m-0">
                <p class="animated pulse w-100 pt-2">@include('inc.messages')</p>
            </div>
         </div> 
         <div class=" p-2 mb-5">

          {{-- <div class="form-group   rounded">
            <label for="">Search Rep</label>
            <input type="text"
              class="form-control" name="" id="" aria-describedby="helpId" placeholder="Search Rep by Name">
            <small id="helpId" class="form-text text-muted text-center"><i>start typing Rep Name</i></small>
          </div>
                  <hr> --}}

          <div class="font-weight-bold h4 d-flex justify-content-between">
              <span> Rep Sales </span>
          <div class="">
            <a href="{{ route('sales_analysis') }}" class="btn btn-outline-success rounded btn-sm font-weight-bold" >Sales Analysis</a>
            <a  class="btn btn-info rounded btn-sm font-weight-bold" data-toggle="modal" data-target="#create_new_rep_sales">add new Rep Sales</a>
          </div>
            </div>
          <?php $i = 1 ?>
          <table class="table table-striped w-auto p-0 " >
              <thead class=" m-0 p-0">
                  <tr class="border font-weight-bold shadow bg-dark text-light rounded"  >
                      <th>#</th>
                      <th>Rep Name</th>         
                      <th>Rep number</th>         
                     <th>Destribution Center</th>   
                      <th>Nett Sales</th>         
                      <th>VAT</th>         
                      <th>VAT inclusive</th>
                      <th>Date</th>          
                      <th>Action</th>          
                  </tr>
                  </thead>
                  <tbody>  
                      @foreach ($rep_sales as $rep_sale)
                      <tr>  
                          <td scope="row">{{$i}}</td>
                          <td>{{$rep_sale->first_name}}</td>
                          <td >{{$rep_sale->rep_number}}</td>  
                          <td >{{$rep_sale->name}}</td>  
                          <td >R{{number_format( $rep_sale->NettSales, 2)}}</td>  
                          <td >R{{number_format( $rep_sale->VAT, 2)}}</td>  
                          <td >R{{number_format( ($rep_sale->NettSales + $rep_sale->VAT), 2) }}</td>  
                          <td >{{$rep_sale->date}}</td>
                          <td class="">
                            <a href=" {{ route('update_rep_sale', [$rep_sale->salesID]) }}" class="text-info"><i class="fas fa-pencil-alt    "></i></a> &nbsp; |  &nbsp;  
                            <a href="{{ route('update_rep_sale', [$rep_sale->salesID, true]) }}" class="text-danger"><i class="fas fa-trash-alt    "></i></a>  
                          </td>
                      <?php $i++ ?>
                      @endforeach 
                      
                  </tbody>
          </table>
          @if (count($reps) <= 0)
          <i class="font-weight-bold grey-text h3 text-center">
              No Data Available...
          </i>
          @endif
  
      </div> 

 
     </div>
 

    {{-- <!-- ////////////////////////////////////// Modal --> --}}

    <div class="modal fade" id="create_new_rep_sales" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
      <div class="modal-dialog" role="document">
          <form action="{{ route('create_rep_sale') }}" enctype="multipart/form-data" method="post" class="modal-content">
              @csrf
              <div class="modal-header">
                  <h5 class="modal-title">Create Rep Sales</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
              </div>
              {{-- onchange=" window.location.href = this.value;" --}}
              <div class="modal-body">
                  <div class="">
                    <div class="form-group "> 
                      <label for="" class="font-weight-bold">Choose a Rep</label>
                      <select class="custom-select" name="rep" >
                        <option value="" selected disabled>Select Rep</option>
                          @foreach ($reps as $rep)
                               <option class="font-weight-bold" value="{{  $rep->repID  }}">
                                {{$rep->rep_number}} &nbsp; {{$rep->first_name}} {{$rep->last_name}} </option>
                          @endforeach
                       </select>
                    </div>
                      <div class="form-group">
                        <label for="">Nett Sale</label>
                        <input type="number" class="form-control" name="nett_sale" placeholder="Rep Nett Sale" >
                      </div>
                      <div class="form-group">
                        <label for="">Enter VAT</label>
                        <input type="number" class="form-control" name="vat" placeholder="Enter VAT" >
                      </div>
                      <div class="form-group">
                        <label for="">Select a Date</label>
                        <input type="date" class="form-control" name="date" placeholder="Enter Store trading Name" >
                       </div>
                      <hr>
                      <small class="text-danger font-weight-bold">NB: &nbsp; </small> 
                      <small class="text-muted"><i>You only submit the record for one day only. <br>
                      e.g: Nettsales for Rep X is R0.00 for 30/01/2000
                      </i></small>               
                     
                  </div>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-success btn-sm">Save</button>
              </div>
          </form>
      </div>
  </div>

    {{-- ///////////////////////////////////////// ALL SALES MODAL////////////// --}}
    

  </main>

{{-- ////////////////////////////////////////////////////////////////// --}} 
<script>
 
const { createApp } = Vue;
     createApp({
        data() {
          return {
            salesdb: [], 
            sales: [], 
           
            searchtext: "",
          }          
        },
       async created() {
 
            let response = await  await axios.get("{{route('get_sales')}}");
            let data = await response.data;

            // console.log(await data)
            for (let i = 0; i < data.length; i++) {
                this.salesnew.push(data[i]);

                this.sales += this.toNumber(data[i].sales);
                this.salescost += this.toNumber(data[i].salesCost);
                this.refunds += this.toNumber(data[i].reFunds);
                this.refundscost += this.toNumber(data[i].reFundsCost);
                this.nettsales += this.toNumber(data[i].nettSales);
                this.profit += this.toNumber(data[i].profit);
 
             } 

             this.salesdb = [ ...this.salesnew ]
               
        },
       methods:{

        toDecimal(num) 
            {
                number = Number.parseFloat(num)
                return number.toFixed(2);
            },
        isDailyTotals(val){
              let date = document.getElementById("date")
              let buttons = document.getElementById("buttons")

              if (val) {
                date.classList.add('d-none');
              } else{
                date.classList.remove('d-none');
              }
              // if
              buttons.classList.remove('d-none');
            },
            toNumber(num) 
            {
                let number = num;
                number = number.replace(/,/g, "");
                number = parseFloat(number);
              return number;
            }, 

        seachFun(event) {          
            
            let salesnew = JSON.parse(JSON.stringify(this.salesnew))
            let salesdb = JSON.parse(JSON.stringify(this.salesdb))
            let search = this.searchtext.toLowerCase()
            let mysales = []
              
            if (search.length < 3) {
                mysales = [ ...salesdb ];  // show everything on the table

                      this.sales  = 0;
                      this.salescost = 0;
                      this.refunds = 0;
                      this.refundscost = 0;
                      this.nettsales = 0;
                      this.profit = 0;   

                for (let x = 0; x < this.salesdb.length; x++) {

                    this.sales += this.toNumber(this.salesdb[x].sales);
                    this.salescost += this.toNumber(this.salesdb[x].salesCost);
                    this.refunds += this.toNumber(this.salesdb[x].reFunds);
                    this.refundscost += this.toNumber(this.salesdb[x].reFundsCost);
                    this.nettsales += this.toNumber(this.salesdb[x].nettSales);
                    this.profit += this.toNumber(this.salesdb[x].profit);      
                                  
                    // console.log(this.salesnew[x].profit); 
                    } 
             }else{
             
              mysales = [];

            for (let i = 0; i < salesdb.length; i++) {
       
                if (salesdb[i].barcode.includes(search))
                   {
                      mysales.push(salesdb[i]);

                      this.sales  = 0;
                      this.salescost = 0;
                      this.refunds = 0;
                      this.refundscost = 0;
                      this.nettsales = 0;
                      this.profit = 0;

                    for (let x = 0; x < mysales.length; x++) {

                        this.sales += this.toNumber(mysales[x].sales);
                        this.salescost += this.toNumber(mysales[x].salesCost);
                        this.refunds += this.toNumber(mysales[x].reFunds);
                        this.refundscost += this.toNumber(mysales[x].reFundsCost);
                        this.nettsales += this.toNumber(mysales[x].nettSales);
                        this.profit += this.toNumber(mysales[x].profit);      
                                      
                    // console.log(this.salesnew[x].profit); 
                    }
                   }else{
                    
                      this.sales  = 0;
                      this.salescost = 0;
                      this.refunds = 0;
                      this.refundscost = 0;
                      this.nettsales = 0;
                      this.profit = 0;    

                    for (let x = 0; x < mysales.length; x++) {

                        this.sales += this.toNumber(mysales[x].sales);
                        this.salescost += this.toNumber(mysales[x].salesCost);
                        this.refunds += this.toNumber(mysales[x].reFunds);
                        this.refundscost += this.toNumber(mysales[x].reFundsCost); 
                        this.nettsales += this.toNumber(mysales[x].nettSales);
                        this.profit += this.toNumber(mysales[x].profit);    
                    }
                   }
              } 

             }
             this.salesnew = [];
             this.salesnew = [ ...mysales ]; 

             //  ////////////////////////////////// 
        },

       }
   }).mount("#app");
 
</script>
</x-app-layout>
 