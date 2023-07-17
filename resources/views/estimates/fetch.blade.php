
<?php 

    
    if(isset($estimates)){
        //dd($estimates);
        ?>
        
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
                    {!! $estimates->links() !!}
                </div>
            </div>
            
    <?php   }
?>



