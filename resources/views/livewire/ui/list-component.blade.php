<div x-data="tableComponent(@js($data))">
    <br />
    <div class="row">
        <div class="col-12 col-lg-8 col-md-6">
            <h2> {{$title}} </h2>
        </div>
    </div>
    <br />
    <div class="row">
        <div class="mx-auto col-12 col-lg-8 col-md-6">
            <input type="text" class="form-control" x-model="search" placeholder="{{$searchPlaceholder}}" aria-label="Recipient’s dataItemname" aria-describedby="button-addon2">
        </div>
    </div>
    <br />
    <div class="row" x-data="fieldsIdentifier(@js($columns))">
        <div class="mx-auto col-12 col-lg-8 col-md-6">
            <div class="accordion" id="accordionPanelsStayOpenExample">
                <template x-for="(item,index) in filteredItems" :key="item.id">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button" :class="index > 0 ? 'collapsed' : ''" type="button" data-bs-toggle="collapse" :data-bs-target="'#panelsStayOpen-collapse' + index" :aria-expanded="index < 1 ? 'true' : 'false'" :aria-controls="'panelsStayOpen-collapse' + index">
                                <i :class="'ti ti-number-'+(index+1)+'-small'" style="font-size:24px;"></i> - &nbsp; 
                                <span class="badge bg-primary ms-2"  x-text="item[fields[0]]"></span> 
                                <span class="badge bg-dark ms-2" x-text="item[fields[1]]"></span>
                                <span class="badge bg-warning text-dark ms-2" x-html="`${item.contact}`"></span>
                            </button>
                        </h2>
                        <div :id="'panelsStayOpen-collapse' + index" class="accordion-collapse collapse" :class="index < 1 ? 'show' : ''" :aria-labelledby="'panelsStayOpen-heading' + index">
                            <div class="accordion-body">
                                <div class="row">
                                    <div class="col-12 col-lg-8 col-md-6">
                                    </div>
                                    <div class="col-12 col-lg-4 col-md-6">
                                        <template x-if="item.image">
                                            
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>
</div>
<script>
    function tableComponent(data) {
        console.log(data);
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
    function fieldsIdentifier(columns) {
        console.log(columns);
        return {
            columns: columns,
            get fields() {
            return this.columns.map(column => column.field);
            }
        }
    }

</script>