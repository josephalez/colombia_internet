<template>
    <div class="planComparator-bg py-4 px-lg-4 px-md-4">
        <div class="d-flex flex-row h-100 w-100 flex-wrap justify-content-around align-items-start">
            <div class="filterCard col-10 col-lg-4 col-xl-3">
                <filter-card @customFiltering="refreshData" :fields="compFields" />
            </div>
            <filter-table @consultItem="consultItem" @viewItem="viewItem" @pageSwitch="changePage" :fields="compFields" :items="compPagination.data" :currentpage="compPagination.current_page" :lastpage="compLastpage" ></filter-table>
        </div>
        <offer-consult v-if="currentItem&&consultMode" :offerMode="true" :offer="currentItem"></offer-consult>
        <offer-modal v-if="currentItem&&viewMode" :offer="currentItem" ></offer-modal>
    </div>
</template>

<script>
export default {
    props:["pagination", "fields", "query", "lastpage"],

    data(){
        return {
            compPagination:this.pagination,
            compFields:this.fields,
            compLastpage:this.lastpage,
            customFilters:null,
            pageIndex:"&page=1",
            currentItem:null,
            viewMode:false,
            consultMode:false,
        };
    },

    mounted(){
        console.log("wi pagination", this.pagination);
    },

    methods:{

        consultItem(index){

            this.currentItem= this.pagination.data[index];
            
            this.consultMode=true;
            this.viewMode=false;

        },

        viewItem(index){

            this.currentItem= this.pagination.data[index];

            this.viewMode=true;
            this.consultMode=false;

        },

        changePage(page=1){
            this.pageIndex="&page="+page;
            this.refreshData();
        },

        refreshData(filters=this.customFilters){
            //window.location.replace(baseUrl+"/offers/search"+this.query+(filters?filters:"")+this.pageIndex)

            let loader = this.$loading.show();

            this.loading=true;

            console.log(baseUrl+"/offers/search"+this.query+(filters?filters:"")+this.pageIndex)            

            axios.get(baseUrl+"/offers/search"+this.query+(filters?filters:"")+this.pageIndex)
            .then(res=>{
                console.log("response ", res)
                this.compPagination=res.data.pagination;
                this.compLastpage=res.data.last_page;
                this.compFields=res.data.fields;
                //res.query=res.data.query;
            }).catch(err=>{
                toastr.error("ha ocurrido un error al cargar los datos, vuelva a intentarlo");
            })
            .finally(()=>{loader.hide()})
             
        }
    }
    
}
</script>

