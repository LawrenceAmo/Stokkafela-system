<x-app-layout>
    <main class="m-0  p-4    w-100" id="app">

        <div class="card p-3">
            <div class="d-flex justify-content-between">
                <div class=""></div>
            <div class=""><a data-toggle="modal" data-target="#new_doc" class="btn btn-sm btn-dark rounded">upload new document</a></div>
         </div>
        </div>
        <hr>
         
    <div class="card   rounded p-3 w-100">
 <div class=" row">
    <div class="col-md-3">
        <p class="h5">Important Documents</p>
    </div>
    <div class="col-md-9">
        <div class="form-group">
           <input type="text" name="" id="" class="form-control" placeholder="Search Document by Name" aria-describedby="helpId">
        </div>
    </div>
 </div> <hr>
 <div class="row mx-0 animated fadeInDown">
    <div class="col-12 text-center p-0 m-0">
        <p class="animated pulse w-100 pt-2">@include('inc.messages')</p>
    </div>
 </div>
 
 <div class="">
    <table class="table   table-striped table-inverse table-responsive">
        <thead class="thead-inverse">
            <tr class="h5">
                <th>#</th>
                <th>Document Name</th>
                <th>Created By</th>
                <th>File Type</th>
                <th>File Size</th>
                <th>Created At</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for=" doc,i in documents">
                <td scope="row">@{{i+1}}</td>
                <td>@{{doc.name}}</td>
                <td>@{{doc.first_name}} @{{doc.last_name}}</td>
                <td>@{{doc.type}}</td>
                <td v-if="doc.size != 0">@{{doc.size}}MB</td>
                <td v-else> < 0.01MB</td>
                <td>@{{doc.created_at}}</td>
                <td> 
                    {{-- <a class="text-primary"> <i class="fa fa-pencil-alt" aria-hidden="true"></i> </a> &nbsp; | &nbsp;  --}}
                    <a class="text-info" @click="download_doc_fun(doc);" data-toggle="modal" data-target="#download_doc"> <i class="fa fa-download" aria-hidden="true"></i> </a> &nbsp; | &nbsp;
                    <a class="text-danger" @click="delete_doc_fun(doc);" data-toggle="modal" data-target="#delete_doc"> <i class="fas fa-trash    "></i> </a>
                </td>
            </tr>           
        </tbody>
    </table>
 </div>

    </div>
 
    {{-- //////////////////////////////       Modal         //////////////////////////////// --}}
    <!-- Modal -->
    <div class="modal fade" id="download_doc" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                 <div class="modal-header">
                    <h5 class="modal-title">Download Document</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
    
                    <div class="d-flex justify-content-between">
                        <div class="">
                            <span>Document Name:</span><br>
                            <b>@{{ download_doc.name }}</b>
                        </div>
                        <div class="">
                            <a download="true" target="_blank" :href="document_storage(download_doc.url)" class="btn btn-sm btn-info rounded">download document</a>
                        </div>
                    </div> <hr>
                    <div class="">
                        <p class="h5">Document Info:</p> <br>
                        <p class="p-1">@{{download_doc.description}}</p>
                    </div>   
                </div>
                
            </div>
         </div>
    </div>
{{-- //// End Modal 1 --}}

<!-- Modal -->
<div class="modal fade" id="new_doc" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ route('document_create') }}" enctype="multipart/form-data" method="post" class="modal-content">
            @csrf
             <div class="modal-header">
                <h5 class="modal-title">Upload New Document</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">

               <div class="form-group">
                 <label for="">Choose File</label>
                 <input type="file" class="form-control-file" name="file" placeholder="" aria-describedby="fileHelpId">
               </div>
               <div class="form-group">
                 <label for="">File Name</label>
                 <input type="text" name="name" class="form-control" placeholder="Write a file name" aria-describedby="helpId">
               </div>

               <div class="form-group">
                 <label for="">Description <small><i>(optional)</i></small></label>
                 <textarea class="form-control" name="description" rows="3"></textarea>
               </div>


            </div>
            <div class="modal-footer">
                 <button type="submit" class="btn btn-dark btn-sm rounded"> upload</button>
            </div>
        </form>
     </div>
</div>

<!-- Modal -->
<div class="modal fade" id="delete_doc" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
             <div class="modal-header">
                <h5 class="modal-title">Delete This Document?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">

                <div class="d-flex justify-content-between">
                    <div class="">
                        <span>Document Name:</span><br>
                        <b>@{{ delete_doc.name }}</b>
                    </div>
                    <div class="">
                        <a @click="delete_file(delete_doc.documentID)" class="btn btn-sm btn-danger rounded">yes delete document</a>
                    </div>
                </div> <hr>
                <div class="">
                    <p class="h5 text-danger"><b class="">Please Note:</b></p>  
                    <p class="">
                        This action is irreversible. Once the document is deleted, you won't be able to recover it. It will be permanently removed from our database. We advise you to make a backup by downloading it first.
                    </p>
                </div>   
            </div>
            
        </div>
     </div>
</div>
{{-- //// End Modal 1 --}}
  
    </main>
    
    <script>
 
        const { createApp } = Vue;
             createApp({
                data() {
                  return {                       
                    documents: [], 
                    update_doc: [],             
                    download_doc: [],             
                    delete_doc: [],           
                  }          
                },
               async created() { 
                      let doc = @json($documents);
                      this.documents = doc;
                      console.log(doc)
                },
               methods:{ 
                document_storage: function (val) {
                    return `{{ asset('storage/documents/${val}')}}`;
                },
                update_doc_fun: async function(doc){
                    console.log(doc)
                    // this.update_doc = doc;
                },
                download_doc_fun: async function(doc){
                    console.log(doc)
                    this.download_doc = doc;
                },
                delete_doc_fun: async function(doc){
                    console.log(doc)
                    this.delete_doc = doc;
                },
                delete_file: async function(doc){
                    console.log(doc)
                    location.href = '{{ route("delete_doc", '') }}/' + doc;
                },
               }
           }).mount("#app");
        </script>

</x-app-layout>
