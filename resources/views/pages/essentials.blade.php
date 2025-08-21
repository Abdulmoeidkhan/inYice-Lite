@auth
@extends('layouts.layout')
@section("content")

@if(session()->get('user')->roles[0]->name === "admin" || session()->get('user')->roles[0]->name === "snseaUser")
<div class="row">
    <div class="d-flex justify-content-center">
        <livewire:essential-modal-form-component wire:id="{{rand()}}" wire:key="{{rand()}}" modalId="add_country"
            name="Country" colorClass="success" :className="$modelClass=App\Models\Country::class"
            btnName="Add Country" />
    </div>
</div>
<br />
@endif
<div class="row">
    <div class="card w-100">
        <div class="card-body p-4">
            <h5 class="card-title fw-semibold mb-4">Add Country</h5>
            <div class="table-responsive">
                <table id="table1" data-filter-control-multiple-search="true"
                    data-filter-control-multiple-search-delimiter="," data-virtual-scroll="true" data-flat="true" table
                    id="table" data-filter-control-multiple-search="true"
                    data-filter-control-multiple-search-delimiter="," data-show-refresh="true"
                    data-show-pagination-switch="true" data-click-to-select="true" data-toggle="table"
                    data-url="{{route('request.countryData')}}" data-pagination="true" data-show-toggle="true"
                    data-show-export="true" data-show-columns="true" data-show-columns-toggle-all="true"
                    data-page-list="[10, 25, 50, 100,200]">
                    <thead>
                        <tr>
                            <th data-field="id">Id</th>
                            <th data-field="name" data-sortable="true">Country Name</th>
                            <th data-field="display_name" data-sortable="true">Country Display Name</th>
                            {{-- <th data-field="id" data-sortable="true" data-formatter="operateEvents">Actions</th>
                            --}}
                            <th data-field="operate" data-formatter="operateFormatter" data-events="operateCountry">
                                Actions</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
<br />
@if(session()->get('user')->roles[0]->name === "admin" || session()->get('user')->roles[0]->name === "snseaUser")
<div class="row">
    <div class="d-flex justify-content-center">
        <livewire:essential-modal-form-component wire:id="{{rand()}}" wire:key="{{rand()}}" modalId="add_city"
            name="City" colorClass="primary" :className="$modelClass=App\Models\Cities::class" btnName="Add City" />
    </div>
</div>
@endif
<br />
<div class="row">
    <div class="card w-100">
        <div class="card-body p-4">
            <h5 class="card-title fw-semibold mb-4">Add City</h5>
            <div class="table-responsive">
                <table id="table2" data-filter-control-multiple-search="true" data-virtual-scroll="true"
                    data-show-pagination-switch="true" data-click-to-select="true" data-toggle="table"
                    data-show-export="true" data-show-columns="true" data-show-columns-toggle-all="true"
                    data-url="{{route('request.cityData')}}" data-pagination="true" data-show-toggle="true"
                    data-filter-control-multiple-search-delimiter="," data-show-refresh="true" data-flat="true"
                    data-page-list="[10, 25, 50, 100,200]">
                    <thead>
                        <tr>
                            <th data-field="id">Id</th>
                            <th data-field="name" data-sortable="true">City Name</th>
                            <th data-field="display_name" data-sortable="true">City Display Name</th>
                            <th data-field="operate" data-formatter="operateFormatter" data-events="operateCity">
                                Actions</th>
                            {{-- <th data-field="id" data-sortable="true" data-formatter="operateCities">Actions</th>
                            --}}
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
@if(session()->get('user')->roles[0]->name === "admin" || session()->get('user')->roles[0]->name === "snseaUser")
<div class="row">
    <div class="d-flex justify-content-center">
        <livewire:essential-modal-form-component wire:id="{{rand()}}" wire:key="{{rand()}}" modalId="add_group"
            name="Group" colorClass="warning" :className="$modelClass=App\Models\Group::class" btnName="Add Group" />
    </div>
</div>
@endif
<br />
<div class="row">
    <div class="card w-100">
        <div class="card-body p-4">
            <h5 class="card-title fw-semibold mb-4">Add Group</h5>
            <div class="table-responsive">
                <table id="table3" data-filter-control-multiple-search="true" data-virtual-scroll="true"
                    data-show-pagination-switch="true" data-click-to-select="true" data-toggle="table"
                    data-show-export="true" data-show-columns="true" data-show-columns-toggle-all="true"
                    data-url="{{route('request.groupData')}}" data-pagination="true" data-show-toggle="true"
                    data-filter-control-multiple-search-delimiter="," data-show-refresh="true" data-flat="true"
                    data-page-list="[10, 25, 50, 100,200]">
                    <thead>
                        <tr>
                            <th data-field="id">Id</th>
                            <th data-field="name" data-sortable="true">Group Name</th>
                            <th data-field="display_name" data-sortable="true">Group Display Name</th>
                            <th data-field="operate" data-formatter="operateFormatter" data-events="operateGroup">
                                Actions</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
@include("layouts.tableFoot")
<script>
    const $table1 = $('#table1'),$table2 = $('#table2'),$table3 = $('#table3');

    function operateCities(value, row, index) {
        if (value) {
            return `<div class="left"><button class="btn btn-badar" onclick="deleteAction('${path}',${value},${index},'#table1')"><svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M18 6l-12 12" /><path d="M6 6l12 12" /></svg></button></div>`;
        }
    }



    function operateFormatter (value, row, index) {
        // console.log(value,row,index)
        return[
        `<a class='remove btn btn-badar' href='javascript:void(0)' title='Remove'><svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M18 6l-12 12" /><path d="M6 6l12 12" /></svg></a>`
      ]
    }

    window.operateCountry={
          [`click .remove`]: (e, value, row) => {
            axios.post('{{route("request.deleteCountry")}}', {
                    id:[row.id]
                }).then(
                    function(response) {
                        console.log(response)
                    }).catch(function(error) {
                        console.log(error);
                    })
            $table1.bootstrapTable('refresh');
        }
    }

    window.operateCity={
        [`click .remove`]: (e, value, row) => {
            axios.post('{{route("request.deleteCity")}}', {
                    id:[row.id]
                }).then(
                    function(response) {
                        console.log(response)
                    }).catch(function(error) {
                        console.log(error);
                    })
            $table2.bootstrapTable('refresh');
        }
    }

    window.operateGroup={
        [`click .remove`]: (e, value, row) => {
            axios.post('{{route("request.deleteGroup")}}', {
                    id:[row.id]
                }).then(
                    function(response) {
                        console.log(response)
                    }).catch(function(error) {
                        console.log(error);
                    })
            $table3.bootstrapTable('refresh');
        }
    }
           

</script>
@endsection
@endauth