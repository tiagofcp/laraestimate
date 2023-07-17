

@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row animated slideInLeft faster">

        <div class="col-sm-12 mb-4">
            <h1>@lang('app.estimates')</h1>
            <a href="{{ route('estimates.create') }}" class="btn btn-primary btn-lg"><i class="icon ion-md-add"></i> @lang('app.add_estimate')</a>
        </div>

        <div class="col-sm-12">
            <div class="searchbar mt-4 mb-4">
                <form>
                    <div class="input-group">
                        <input id="listItemsSearch" type="text" name="search" placeholder="Procurar..." class="form-control form-control-lg" value="{{ isset($search) ? $search : '' }}" onkeyup="onSearchFilter()">
                        {{-- <div class="input-group-append">
                            <button type="submit" class="btn btn-primary btn-lg" type="button">
                                <i class="icon ion-md-search"></i>
                            </button>
                        </div> --}}
                    </div>
                </form>
            </div>
        </div>

        
        <div class="col-sm-12">
            <div id="filters">
                <select name="fetchauthor" id="fetchauthor" onchange="onChangeAuthor()">
                    
                    <option value="" selected="">Mostrar Todos</option>
                    @foreach ($authors as $author)

                        <option value="{{$author->id}}">{{$author->name}}</option>
                     
                    @endforeach
                    
                </select>
                <select name="fetchtags" id="fetchtags" onchange="onChangeTag()">
                    
                    <option value="" selected="">Mostrar Todos</option>
                    @foreach ($tags as $tag)


                        <option value="{{$tag}}">{{$tag}}</option>
                                
                    @endforeach
                    
                </select>
            </div>

        </div>

        <div class="row" id="estimates-row" style="width: 100%">
            
            @forelse ($estimates as $estimate)  
            
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ $estimate->name }}</h4>

                        <div class="row mt-2">
                            <div class="col">

                                <span class="card-subtitle" style="display: inline-block"> Criado por: </span>
                                <p class="card-subtitle text-black-50" style="display: inline-block"><i class="icon ion-md-person"></i>{{ is_null(\App\Models\User::find($estimate->created_by)) ? 'Sem Autor' : \App\Models\User::find($estimate->created_by)->name }}</p>
                                <p class="card-subtitle text-black-50" style="display: inline-block"><i class="icon ion-md-time"></i>{{ $estimate->created_at->diffForHumans() }}</p>

                            </div>
                        </div>
                        
                        <div class="row mt-2">
                            <div class="col">

                                <span class="card-subtitle" style="display: inline-block"> Última Atualização: </span>
                                <p class="card-subtitle text-black-50" style="display: inline-block"><i class="icon ion-md-person"></i>{{ is_null(\App\Models\User::find($estimate->updated_by)) ? 'Sem Autor' : \App\Models\User::find($estimate->updated_by)->name }}</p>
                                <p class="card-subtitle text-black-50" style="display: inline-block"><i class="icon ion-md-time"></i>{{ $estimate->updated_at->diffForHumans() }}</p>

                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col">
                                <a href="{{ route('estimates.edit', $estimate) }}" class="btn btn-light text-primary btn-sm"><i class="icon ion-md-create"></i> @lang('app.labels.edit')</a>
                                <a href="{{ route('estimates.show', $estimate) }}" target="_blank" class="btn btn-light text-primary btn-sm"><i class="icon ion-md-document"></i>  @lang('app.labels.view')</a>
                                <a href="{{ route('estimates.duplicate', $estimate) }}" target="_blank" class="btn btn-light text-primary btn-sm"><i class="icon ion-md-copy"></i> @lang('app.labels.duplicate')</a>
                            </div>
                            <div class="col">
                                <form id="deleteEstimateForm{{ $estimate->id }}" action="{{ route('estimates.destroy', $estimate) }}" method="POST" onsubmit="return estimates.confirmDelete(event, '{{ $estimate->id }}')">
                                        
                                    @method('DELETE')
                                    @csrf
                                    
                                    <button type="submit" class="btn btn-light text-danger float-right btn-sm">
                                        <i class="icon ion-md-trash"></i> @lang('app.labels.remove')
                                    </button>
        
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            @empty
                @lang('app.no_estimates_found')
            @endforelse

            <div class="row" id="pagination" style="width: 100%">
                <div class="col-sm-12">
                    {{ $estimates->render() }}
                </div>
            </div>  

        </div>
    </div>
    <input type="hidden" name="hidden_page" id="hidden_page" value="1" />
    <input type="hidden" name="hidden_created_by" id="hidden_created_by" value="" />
    <input type="hidden" name="hidden_tag" id="hidden_tag" value="" />


</div>
@endsection


@push('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script>
    var estimates = {

        confirmDelete: function(event, id) {

            event.preventDefault();
            event.stopPropagation();

            bootbox.confirm('{{ trans("app.dialogs.are_you_sure") }}', function(confirmed) {
                if(confirmed) {
                    document.getElementById('deleteEstimateForm' + id).submit();
                }
            });

            return false;

        }

    };

    function fetchData(page, created_by,search,tag){

        $.ajax({
            url: "/estimates/filter?page="+page+"&created_by="+created_by+"&tag="+tag+"&search="+search,
            type: 'GET',
            data: {
                page: page,
                created_by: created_by,
                tag: tag,
            },
            beforeSend: function(){
                $("#estimates-row").html("<span>A carregar...</span>");
                //$("#pagination").empty();
            },
            success: function(data){
                $("#estimates-row").html(data); 
                //console.log(data);
            
            }
        }); 
    };

    function onChangeAuthor(){

        const value = document.getElementById("fetchauthor").value;
        //const estimates = {!! json_encode($estimates, JSON_HEX_TAG) !!};
        //const authors = {!! json_encode($authors, JSON_HEX_TAG) !!};
        //const search = {!! json_encode($search, JSON_HEX_TAG) !!};

        let tag = $('#hidden_tag').val();
        let page = $('#hidden_page').val();
        $('#hidden_created_by').val(value);
        let searchItem = $('#listItemsSearch').val();
        
        fetchData(page,value,searchItem,tag);
        
    };

    function onChangeTag(){

        const value = document.getElementById("fetchtags").value;

        let search = $('#listItemsSearch').val();
        let page = $('#hidden_page').val();
        let author = $('#hidden_created_by').val();
        $('#hidden_tag').val(value);    

        fetchData(page,author,search,value);

    };

    function onSearchFilter(){

        let search = $('#listItemsSearch').val();
        let page = $('#hidden_page').val();
        let value = $('#hidden_created_by').val();
        let tag = $('#hidden_tag').val();

        fetchData(page,value,search,tag);
    };

   


    $(document).on('click', '.pagination a', function(event){

        event.preventDefault();
        let page = $(this).attr('href').split('page=')[1];
        $('#hidden_page').val(page);
        let value = $('#hidden_created_by').val();
        let search = $('#listItemsSearch').val();
        let tag = $('#hidden_tag').val();

        fetchData(page,value,search,tag);
    });

    



</script>
@endpush