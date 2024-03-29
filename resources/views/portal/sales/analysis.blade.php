<x-app-layout>
    <style>
        a:hover {
            text-decoration: none;
        }
        .categories{
          background-color: rgb(109, 108, 108)  !important;
          color: rgb(238, 238, 238)  !important;
          font-size: 900px !important;
        }
        .categories-main{
          background-color: rgb(37, 36, 36)  !important;
          color: aliceblue  !important;
          font-size: 900px !important;
        }

        .main-categories-main{
          background-color: rgb(0, 0, 0)  !important;
          color: rgb(252, 255, 221)  !important;
          font-size: 900px !important;
        }
  
        .tableFixHead          { overflow: auto !important;    }
        .tableFixHead thead th { position: sticky !important; top: 0 !important; z-index: 1 !important;background-color: rgb(37, 37, 37)  !important; }
  
         table  { border-collapse: collapse; width: 100% !important; }
        th, td { padding: 8px 16px; }
   
        /* ::-webkit-scrollbar {
        width: 5px;
        background:lightgray;
        }

        ::-webkit-scrollbar-track {
            -webkit-box-shadow: inset 0 0 6px rgb(255, 228, 155); 
            border-radius: 15px;
        }

        ::-webkit-scrollbar-thumb {
            border-radius: 5px;
            -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.5); 
            background:rgb(255, 225, 77);
        } */

    </style>
    {{-- id="app" v-cloak --}}
    <main class="m-0  p-1  w-100 overflow-auto"   id="app" v-cloak>
    
        {{-- <div class="  rounded overflow-auto shadow m-0 p-0 w-100"> --}}
             <div class="form-group rounded overflow-auto   row   p-0 m-0">
                    <div class="col-md-10">
                        <input type="month" name="" id="" v-model="report_date" class="form-control" placeholder="">
                    </div>
                    <div class="col-md-2 pt-auto">
                        <a @click="change_date()" class="btn btn-sm rounded py-2 form-control m-0  font-weight-bold btn-outline-grey border border-info ">  change Month </a>
                    </div>
    </div>
        {{-- </div> --}}

        <div class=" w-100 d-flex shadow rounded py-2">
            <div class="" >
                <table class="table table-striped table-inverse table-responsive ">
                    <thead class="thead-inverse mx-0" style="height: 80px;">
                        <tr class="">
                            <th>#</th>
                            <th>Rep ID</th>
                            <th>Rep name</th>
                            <th>Target Amount</th>
                            {{-- <th>Projections As Today</th> --}}
                            <th>Required Daily RR</th>
                            <th>Target %</th>
                            <th>Current Sales</th>
                         </tr>
                    </thead>
                    <tbody class=" mx-0 border-right border-warning "style="margin:0px !important;">
                            <tr class="text-uppercase main-categories-main " style="height: 80px;"> 
                                <td colspan="3" class="font-weight-bold border-right">Stokkafela Revenue</td>
                                <td class="font-weight-bold ">R@{{ stores[0]['target_amount'].toLocaleString('en-US') }}</td>
                                {{-- <td class="font-weight-bold ">R@{{ stores[0]['projections'].toLocaleString('en-US') }}</td> --}}
                                <td class="font-weight-bold ">R@{{ (stores[0]['daily_rr']).toLocaleString('en-US',1)}}</td>
                                <td class="font-weight-bold text-danger font-weight-bold" v-if="stores[0]['target_percent'] < 100">@{{ stores[0]['target_percent'].toFixed(2)}}%</td>
                                <td class="font-weight-bold " v-else class="text-success font-weight-bold">@{{ stores[0]['target_percent'].toFixed(2)}}%</td>
                                <td class="font-weight-bold ">R@{{ stores[0]['current_sales'].toLocaleString('en-US')}}</td>
                            </tr>
                        <template  v-for="main_destributor,i in data" :key="i">

                            {{-- Main Destributer left table --}}
                            <tr class="text-uppercase categories-main " style="height: 80px;">
                                <td scope="row">@{{i+1}}</td>
                                <td colspan="2" class="font-weight-bold text-light border-right">@{{ main_destributor.main_des_name}}</td>
                                <td>R@{{ main_destributor.target_amount.toLocaleString('en-US')}}</td>
                                {{-- <td>R@{{ main_destributor.projections.toLocaleString('en-US')}}</td> --}}
                                <td>R@{{ main_destributor.required_daily_rr.toLocaleString('en-US')}}</td>
                                <td v-if="main_destributor.target_percent < 100" class="text-danger font-weight-bold">@{{ main_destributor.target_percent.toFixed(2)}}%</td>
                                <td v-else class="text-success font-weight-bold">@{{ main_destributor.target_percent.toFixed(2)}}%</td>
                                <td>R@{{ main_destributor.current_sales.toLocaleString('en-US')}}</td>
                             </tr>
                                                         {{-- sub Destributer left table --}}
                                <template v-for="destributor,i in main_destributor.destributors" destributors>
                                    <tr class="text-uppercase categories " style="height: 80px;">
                                        <td scope="row">@{{i+1}}</td>
                                         <td colspan="2" class="font-weight-bold text-light border-right">@{{ destributor.des_name}}</td>
                                         <td>R@{{ destributor.target_amount.toLocaleString('en-US')}}</td>
                                         {{-- <td>R@{{ destributor.projections.toLocaleString('en-US')}}</td> --}}
                                         <td>R@{{ destributor.required_daily_rr.toLocaleString('en-US')}}</td>
                                        <td v-if="destributor.target_percent < 100" class="text-danger font-weight-bold">@{{ destributor.target_percent.toFixed(2)}}%</td>
                                        <td v-else class="text-success font-weight-bold">@{{ destributor.target_percent.toFixed(2)}}%</td>
                                        <td>R@{{ destributor.current_sales.toLocaleString('en-US')}}</td>
                                    </tr>
                                        {{-- Rep left table required_daily_rr --}}
                                    <tr v-for="rep,i in destributor.reps" style="height: 80px;">
                                        <td scope="row">@{{i+1}}</td>
                                        <td>@{{ rep.rep_number}}</td>
                                        <td class="border-right">@{{ rep.rep_name}}</td>
                                        <td>R@{{ rep.target_amount.toLocaleString('en-US')}}</td>
                                        {{-- <td>R@{{ rep.projections.toLocaleString('en-US')}}</td> --}}
                                        <td>R@{{ rep.required_daily_rr.toLocaleString('en-US')}}</td>
                                         <td v-if="rep.target_percent < 100" class="text-danger font-weight-bold">@{{ rep.target_percent.toFixed(2)}}%</td>
                                            <td v-else class="text-success font-weight-bold">@{{ rep.target_percent.toFixed(2)}}%</td>
                                        <td>R@{{ rep.current_sales.toLocaleString('en-US')}}</td>
                                    </tr>
                                </template>
                        </template>
                    </tbody>
                </table>
            </div>
             <div class=" overflow-auto w-50">
                <table class="table table-striped table-inverse table-responsive  "   >
                    <thead class="thead-inverse" style="height: 80px;"> 
                       <tr>
                        <template v-for="y in lastDay">
                            <th>@{{y}} @{{month}}</th> 
                         </template>
                       </tr>
                        </thead>
                        <tbody>

                            <tr class="text-uppercase main-categories-main" style="height: 80px;">
                                <template v-for="a in lastDay" class=" ">
                                    <td class="border-right text-success font-weight-bold" v-if="stores[0]['date_sales'][a]" style="height: 80px;">R@{{ stores[0]['date_sales'][a].toLocaleString('en-US') }}</td>
                                    <td class="border-right " v-else style="height: 80px;"></td>     
                                </template>
                            </tr>

                            <template  v-for="main_destributor in data"  > 
                                
                                {{-- Main Destributer right table --}}
                                <tr class="text-uppercase categories-main" style="height: 80px;">
                                    <template v-for="a in lastDay" class=" ">
                                        <td class="border-right text-success font-weight-bold" :title="[a, month]" v-if="main_destributor.date_sales[a]" style="height: 80px;">R@{{ main_destributor.date_sales[a].toLocaleString('en-US') }}</td>
                                        <td class="border-right " :title="[a, month]" v-else style="height: 80px;"></td>     
                                    </template>
                                </tr>
                                           {{-- Sub Destributer Right table --}}
                                <template v-for="destributor in main_destributor.destributors">
                                    <tr class="text-uppercase categories" style="height: 80px;">
                                        <template v-for="a in lastDay" class=" ">
                                            <td class="border-right text-success font-weight-bold" :title="[a, month]" v-if="destributor.date_sales[a]" style="height: 80px;">R@{{ destributor.date_sales[a].toLocaleString('en-US') }}</td>
                                            <td class="border-right " :title="[a, month]" v-else style="height: 80px;"></td> 
                                        </template>
                                    </tr>                                 
                                {{--  Rep Right table --}}
                                <tr v-for="rep,z in destributor.reps">
    
                                    <template v-for="a in lastDay" >
                                         <td class="border-right text-success font-weight-bold" :title="[a, month  ]" v-if="rep.date_sales[a]" style="height: 80px;">R@{{ rep.date_sales[a].toLocaleString('en-US') }}</td>
                                        <td class="border-right " :title="[a, month]" v-else style="height: 80px;"></td> 
                                     </template>
                               
                                </tr>   
                                </template>
                                 
                            </template>
                        </tbody>
                </table>
             </div>
        </div>

        <hr>

        <div class="card p-2 mb-5">

            <div class="row mx-0 animated fadeInDown">
                <div class="col-12 text-center p-0 m-0">
                    <p class="animated pulse w-100 pt-2">@include('inc.messages')</p>
                </div>
             </div>    
        <p class="font-weight-bold h4 d-flex justify-content-between">
            <span> Rep with no Targets </span>
            <a  class="btn btn-warning rounded btn-sm font-weight-bold" data-toggle="modal" data-target="#update_rep_target">Update Rep Target</a>
            <a  class="btn btn-success rounded btn-sm font-weight-bold" data-toggle="modal" data-target="#set_rep_target">Set Rep Target</a>
            <a  class="btn btn-info rounded btn-sm font-weight-bold" data-toggle="modal" data-target="#set_des_target">Set Rep Target By Destributor</a>
        </p>
        <?php $i = 1 ?>
        <table class="table table-striped w-auto p-0 " >
            <thead class=" m-0 p-0">
                <tr class="border font-weight-bold shadow bg-dark text-light rounded"  >
                    <th>#</th>
                    <th>Rep Name</th>         
                    <th>Rep number</th>         
                     <th>Target Amount</th>             
                </tr>
                </thead>
                <tbody>  
                    @foreach ($reps_with_notargets as $reps)
                    <tr>
                        <td scope="row">{{$i}}</td>
                        <td>{{$reps->first_name}}</td>
                        <td >{{$reps->rep_number}}</td>  
                        {{-- <td >{{$reps->rep_number}}</td>   --}}
                        <td >R0.00</td>  
                    <?php $i++ ?>
                    @endforeach 
                    
                </tbody>
        </table>
        @if (count($reps_with_notargets) <= 0)
        <i class="font-weight-bold grey-text h3 text-center">
            No Data Available...
        </i>
        @endif

    </div>

{{-- ////////////////////////////////// --}}
{{-- /// start modal --}}
<div class="modal fade" id="update_rep_target" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="/a" enctype="multipart/form-data" method="post" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Update Rep Tartget </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body container">
                <div class="container" > 
                    <table class="table table-striped table-inverse table-responsive">
                        <thead class="thead-inverse">
                            <tr>
                                <th>Rep #</th>
                                <th>Rep Names</th>
                                <th>Destibutor</th>
                                <th>Current Target</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($rep_targets as $rep_target)
                                <tr>
                                    <td scope="row">{{$rep_target->rep_number}} </td>
                                    <td>{{$rep_target->first_name}}</td>
                                    <td>{{$rep_target->name}}</td>
                                    <td>{{$rep_target->target_amount}}</td>
                                    <td>
                                        <a href="{{ route('update_rep_target', [$rep_target->repID] )}} " title="Update Rep target" class=" text-dark"> <i class="fas fa-pencil-alt  text-info  "></i>  </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                    </table> 
                        </div>
                    <hr>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success btn-sm">Save</button>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="set_rep_target" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ route('create_rep_target') }}" enctype="multipart/form-data" method="post" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Set Rep Tartget </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                <div class=""> 
                    <div class="form-group"> 
                      <label for="">Select Rep</label>
                      <select class="form-control" name="repID" required>
                        <option class="" @disabled(true) selected>Select Rep</option>
                        @foreach ($reps_with_notargets as $rep)
                            <option value="{{$rep->repID}}">{{$rep->rep_number}} {{$rep->first_name}} </option>
                        @endforeach
                      </select>
                    </div>
                    <div class="form-group">
                        <label for="">Set Target in Rands (For the current month)</label>
                        <input type="number" class="form-control" name="target_amount" placeholder="Set Target For the current months" >
                      </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success btn-sm">Save</button>
            </div>
        </form>
    </div>
</div>

{{-- /////////////// --}}
<div class="modal fade" id="set_des_target" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ route('create_rep_target_bydes') }}" enctype="multipart/form-data" method="post" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Set Rep Tartget By Destributor</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                <div class=""> 
                    <div class="form-group"> 
                      <label for="">Select Destribution</label>
                      <select class="form-control" name="des" required>
                        <option class="" @disabled(true) selected>Select Destribution</option>
                        @foreach ($destributors as $destributor)
                            <option value="{{$destributor->destributorID}}">{{$destributor->name}} {{$destributor->address}} </option>
                        @endforeach
                      </select>
                    </div>
                    <div class="form-group">
                        <label for="">Set Target in Rands (For the current month)</label>
                        <input type="number" class="form-control" name="target_amount" placeholder="Set Target For the current months" >
                      </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success btn-sm">Save</button>
            </div>
        </form>
    </div>
</div>
 
</main>
{{--    date("Y-m-d", strtotime("first day of 0 months"))     --}}
 
<input type="hidden" name="" id="sales" value="{{$sales}}">
<input type="hidden" name="" id="date" value="{{date("Y-M-d", strtotime("last day of ".$date))}}">
<input type="hidden" name="" id="month" value="{{date("m", strtotime($date))}}">
<script>

const { createApp } = Vue;
      createApp({
        data() {
          return {
            data: [],
            stores: [],
            month: '',
            lastDay: 0,
            report_date: '',            
            next_url: ''    
          }          
        },
       async created() {

        let d =  document.getElementById("date").value;
        let m =  document.getElementById("month").value;

           d = d.split('-');
           this.next_url = this.report_date;    //d[0]+'-'+m; 

           this.month = d[1];
           this.lastDay = Number(d[2]); 
           console.log(this.next_url)
           console.log(m)

            // complete once got fomuler
           let working_days_monfry = 0
           let working_days_monsat = 26

        let sales = JSON.parse( document.getElementById("sales").value );
  
        let repIDs = []; let reps = [];
        for (let i = 0; i < sales.length; i++) {
            let repID = sales[i].repID;
            let date = sales[i].date.split(' ');

            if (!repIDs.includes(repID)) {
                    reps[ repID ] = [];   // add array of sales for that day
                    repIDs.push(repID);
                    reps[ repID ]['rep_name'] =  sales[i].first_name;    
                    reps[ repID ]['destributor_name'] =  sales[i].name;    
                    reps[ repID ]['date'] =  sales[i].date;    
                    reps[ repID ]['rep_number'] =  sales[i].rep_number;    
                    reps[ repID ]['target_amount'] = this.toDecimal(sales[i].target_amount);    
                    reps[ repID ]['projections'] = 0;    
                    reps[ repID ]['current_sales'] = 0;    
                    reps[ repID ]['nettsales'] = 0;    
                    reps[ repID ]['vat'] = 0;    
                    reps[ repID ]['target_percent'] = 0;    
                    reps[ repID ]['required_daily_rr'] = 0;    
                    reps[ repID ]['dates'] = [];    
                    reps[ repID ]['date_sales'] = [];   
            }  
            reps[ repID ]['nettsales'] += this.toDecimal(sales[i].NettSales)
            reps[ repID ]['vat'] += this.toDecimal(sales[i].VAT)
            reps[ repID ]['current_sales'] = reps[ repID ]['nettsales'] + reps[ repID ]['vat']
            reps[ repID ]['target_percent'] = (reps[ repID ]['current_sales'] / reps[ repID ]['target_amount'] )*100;    
            reps[ repID ]['projections'] = reps[ repID ]['current_sales'];  // Do your projections fomular
            reps[ repID ]['required_daily_rr'] = reps[ repID ]['target_amount'] / working_days_monsat;    

            let day = date[0].split('-'); 
                day = Number(day[2]);
            let sale = this.toDecimal(sales[i].NettSales) + this.toDecimal(sales[i].VAT)
             reps[ repID ]['date_sales'][day] =  sale
            reps[ repID ]['dates'].push(day)  
        }

        reps = reps.filter( e => e)

       let deIDs = []; let destributors = [];
        for (let x = 0; x < reps.length; x++) {
            let deID = reps[x].destributor_name 
            if (!deIDs.includes(deID)) {
                    deIDs.push(deID);
                    destributors[ deID ] = []; 
                    destributors[ deID ]["des_name"] = reps[x].destributor_name; 
                    destributors[ deID ]["reps"] = []; 
                    destributors[ deID ]["target_amount"] = 0; 
                    destributors[ deID ]["required_daily_rr"] = 0; 
                    destributors[ deID ]["projections"] = 0; 
                    destributors[ deID ]["current_sales"] = 0;
                    destributors[ deID ]['date_sales'] = new Array(this.lastDay); 
                    destributors[ deID ]['date_sales'].fill(0 ,0, this.lastDay);

                // let des_days = new Array(this.lastDay)   required_daily_rr
            }
            destributors[ deID ]["reps"].push(reps[x]); 
            destributors[ deID ]["target_amount"] += reps[x].target_amount; 
            destributors[ deID ]["current_sales"] += reps[x].current_sales; 
            destributors[ deID ]['target_percent'] = (destributors[ deID ]['current_sales'] / destributors[ deID ]['target_amount'] )*100;    

            for (let z = 0; z < reps[x]['date_sales'].length; z++) {
                if (isNaN(destributors[ deID ]['date_sales'][z])) {
                    destributors[ deID ]['date_sales'][z] = 0
                }
                if (isNaN(reps[x]['date_sales'][z])) {
                    reps[x]['date_sales'][z] = 0
                }
                destributors[ deID ]['date_sales'][z] += reps[x]['date_sales'][z]
 
            } 
            destributors[ deID ]["projections"] = destributors[ deID ]["current_sales"]; 
            destributors[ deID ]["required_daily_rr"] = destributors[ deID ]["target_amount"]  / working_days_monsat; 

            // console.log(destributors[ deID ]);     
            console.log(reps[x]['date_sales']);                
           

        } 

        destributors = Object.values(destributors)
 
        let desIDs = []; let main_destributors = [];
        for (let y = 0; y < destributors.length; y++) {
            let desID = destributors[y].des_name.split(' '); desID = desID[0];

            if (!desIDs.includes(desID)) {
                    desIDs.push(desID);
                    main_destributors[ desID ] = []; 
                    main_destributors[ desID ]["main_des_name"] = desID ; 
                    main_destributors[ desID ]["destributors"] = [];
                    main_destributors[ desID ]["current_sales"] = 0;
                    main_destributors[ desID ]["target_percent"] = 0;
                    main_destributors[ desID ]["target_amount"] = 0;
                    main_destributors[ desID ]["projections"] = 0;
                    main_destributors[ desID ]["required_daily_rr"] = 0;
                    main_destributors[ desID ]['date_sales'] = new Array(this.lastDay); 
            }   //  required_daily_rr
 
            main_destributors[ desID ]["target_amount"] += destributors[y].target_amount;
            main_destributors[ desID ]["current_sales"]  += destributors[y].current_sales;
            main_destributors[ desID ]["target_percent"] = (main_destributors[ desID ]["current_sales"] / main_destributors[ desID ]["target_amount"] ) * 100;;
            main_destributors[ desID ]["destributors"].push(destributors[y])

            for (let z = 0; z < destributors[y]['date_sales'].length; z++) {
                if (isNaN(main_destributors[desID]['date_sales'][z])) {
                    main_destributors[ desID ]['date_sales'][z] = 0
                }
                main_destributors[ desID ]['date_sales'][z] += destributors[y]['date_sales'][z]
            } 
            main_destributors[ desID ]["required_daily_rr"] = main_destributors[ desID ]["target_amount"]  / working_days_monsat;
            main_destributors[ desID ]["projections"] = main_destributors[ desID ]["current_sales"]; //


            // console.log(main_destributors); 
        }

        main_destributors = Object.values(main_destributors)

        // /// Display totals for the store level ( Stokkafela as a whole ) //////
         let stores = {current_sales: 0, target_amount: 0,projections: 0, target_percent: 0, daily_rr: 0, date_sales: []};
        for (let z = 0; z < main_destributors.length; z++) {

            stores["target_amount"] += main_destributors[z].target_amount;
            stores["current_sales"] += main_destributors[z].current_sales;// stores["target_amount"] / working_days_monsat;
            stores["projections"] += main_destributors[z].current_sales;
            stores["target_percent"] = (stores["current_sales"] / stores["target_amount"] )*100;
             
            for (let a = 0; a < main_destributors[z]['date_sales'].length; a++) {
                if (isNaN(stores['date_sales'][a])) {
                    stores['date_sales'][a] = 0
                }
                stores['date_sales'][a] += main_destributors[z]['date_sales'][a]
            } 
            stores["daily_rr"] = stores["target_amount"] / working_days_monsat ;

         } 
        //  console.log(main_destributors)
        //  console.log(stores['date_sales'])

////////////////////////////////////////////////////
console.log("////////////////////////////////////////////////////");

        // console.log( stores);
        console.log( main_destributors);
 
        this.stores = [ ... [stores]]
        this.data = [ ... main_destributors]
         },
        methods:
        {
            toDecimal: function(num)
            {
                let number = num.replace(/,/g, "");
                    number = Number.parseFloat(number)
                return number; 
            },
            change_date: function( )
            {
                let current_url = window.location.href.replace(/analysis.*/,'');
                location.href = current_url+"analysis/"+this.report_date;                
            },
         }
   }).mount("#app");

    </script>
</x-app-layout>
