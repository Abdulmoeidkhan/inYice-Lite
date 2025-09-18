<div x-data="tableComponent(@js($data))">
    <br />
    <div class="row">
        <div class="col-12 col-lg-8 col-md-6">
            <h2> {{$title}} </h2>
        </div>
        <div class="col-12 col-lg-4 col-md-6">
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="{{$searchPlaceholder}}" aria-label="Recipient’s dataItemname" aria-describedby="button-addon2">
                <button class="btn btn-outline-warning" type="button" id="button-addon2">Search</button>
            </div>
        </div>
    </div>
    <br />
    <div class="accordion" id="accordionPanelsStayOpenExample">
        @foreach($data as $key=>$dataItem)
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button {{$key>0?'collapsed':''}}" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapse{{$key}}" aria-expanded="{{$key<1?'true':'false'}}" aria-controls="panelsStayOpen-collapse{{$key}}">
                    {{$dataItem['name']}} - {{$dataItem['email']}}
                </button>
            </h2>
            <div id="panelsStayOpen-collapse{{$key}}" class="accordion-collapse collapse {{$key<1?'show':''}}" aria-labelledby="panelsStayOpen-heading{{$key}}">
                <div class="accordion-body">
                    <div class="row">
                        <div class="col-12 col-lg-8 col-md-6">
                        </div>
                        <div class="col-12 col-lg-4 col-md-6">
                        </div>

                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <br />
    <br />
    <br />

    <input type="text" class="form-control" x-model="search" placeholder="{{$searchPlaceholder}}" aria-label="Recipient’s dataItemname" aria-describedby="button-addon2">

    <div class="accordion" id="accordionPanelsStayOpenExample">
        <template x-for="(item,index) in filteredItems" :key="item.id">
            
            <li x-text="item.name+' - '+item.email + ' - ' +index+1"></li>
        </template>
    </div>
</div>
<script>
    function tableComponent(data) {
        return {
            search: '',
            data: data.map(dataItem => ({
                id: dataItem.id,
                name: dataItem.name,
                email: dataItem.email,
            })),
            get filteredItems() {
                if (!this.search) return this.data;
                const term = this.search.toLowerCase();

                return this.data.filter(dataItem =>
                    dataItem.name.toLowerCase().includes(term) ||
                    dataItem.email.toLowerCase().includes(term)
                );
            }
        }
    }
</script>