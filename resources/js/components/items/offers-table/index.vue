<template>
<div class="col-12 col-lg-8 col-xl-9">
      <div class="d-flex flex-column w-100">

        <div class="d-flex flex-row w-100 justify-content-around py-3 pb-5 align-items-center p-2">
          <button :disabled="currentpage==1" @click="setPage" class="col-2 col-md-1 col-lg-1 col-xl-1 d-flex justify-content-center align-items-center page-item rounded-pill btn btn-light"><i class="fas fa-arrow-left"></i></button>
          <div class="d-flex flex-row justify-content-center col-8 col-lg-6 col-xl-6">
            <button v-for="(item,k1) in compLastpage" @click="setPage(item)" :key="k1" :class="'mx-2 d-flex justify-content-center align-items-center btn btn-sm py-2 text-white rounded-pill page-item'+(currentpage==item?' bg-main-blue':' bg-dark-blue')">
              <span class="text-center pr-1">
                {{item}}
              </span>
            </button>
          </div>
          <button :disabled="currentpage==compLastpage" @click="setPage(currentpage)" class="col-2 col-md-1 col-lg-1 col-xl-1 d-flex justify-content-center align-items-center page-item rounded-pill btn btn-light"><i class="fas fa-arrow-right"></i></button>
        </div>

        <div class="d-flex flex-row w-100 justify-content-around mb-2 mt-3">
          <div class="col-xl-2 col-lg-3 col-md-4 px-1">
            <div class="text-center p-2 offer-table-label w-100 text-white mx-auto bg-dark-blue rounded-pill  p-1 text-wrap ">PROVEEDOR</div>
          </div>
          
          <div v-for="(field,k2) in compFields" :key="k2" :class="'col-xl-2 px-1 col-lg-3 col-md-4 col-sm-4 offer-benefits hidden-md hidden-xs hidden-sm '+(!k2?'d-lg-flex':'hidden-lg')">
            <div class="text-center p-2 offer-table-label w-100 text-white mx-auto bg-dark-blue rounded-pill  p-1 text-wrap ">{{field.name}}</div>
          </div>

          <div class="col-xl-2 col-lg-3 col-md-4 co px-1 col-sm-4 hidden-xs hidden-sm">
            <div class="text-center p-2 offer-table-label w-100 text-white mx-auto bg-dark-blue rounded-pill  p-1 text-wrap ">DESCRIPCION</div>
          </div>
          
          <div class="col-xl-2 col-lg-3 col-md-4 px-1">
            <div class="text-center p-2 offer-table-label w-100 text-white mx-auto bg-dark-blue rounded-pill p-1 text-wrap ">PRECIO</div>
          </div>
        </div>

        <div v-for="(offer,k) in compItems" :key="k" class="d-flex w-100 justify-content-around my-1 mb-3 offer offers-pagination-item pb-3">
          <div class="col-xl-2 col-lg-3 col-md-4 col-sm-4 col-6 d-flex flex-column align-items-center justify-content-center">
            <img :src="baseUrl+'/storage/'+offer.company_logo" class="img-fluid p-2" style="max-height:130px;">
            <h6 class="text-dark-blue pt-2">{{offer.company_name}}</h6> 
          </div>
          
          <div v-for="(fieldValue,k3) in offer.fields_values" :key="k3" :class="'text-wrap col-xl-2 col-lg-3 text-center flex-column align-items-center justify-content-center d-xl-flex hidden-md hidden-xs hidden-sm '+(!k3?'d-lg-flex':'hidden-lg')">
            <h6 class="text-lg">
              {{fieldValue.value}} <span v-if="fields[k3].unit">{{fields[k3].unit}}</span>
            </h6>
          </div>

          <div class="text-wrap col-xl-2 col-lg-3 col-md-4 col-sm-4 text-center flex-column align-items-center justify-content-center d-xl-flex d-lg-flex d-md-flex hidden-xs hidden-sm">
            <h6 class="text-sm">
              {{offer.benefits}}
            </h6>
          </div>

          <div class="col-xl-2 col-lg-3 col-md-4 col-sm-4 col-6 py-2 text-center d-flex flex-column align-items-center justify-content-center">
            <h6 class="text-dark-blue offer-table-price text-wrap-all">$ {{showPrice(offer.tariff)}}</h6>
            <div class="stars-container flex-row justify-content-center mb-2">
              <i v-for="(starCount,k4) in 5" :key="k4" :class="(starCount>offer.points?'far':'fas')+' fa-star'"></i>
            </div>
            <div class="d-flex flex-row">
              <button type="button" data-toggle="modal" @click="emitConsult(k)" data-target="#modalConsultOffer" class="btn btn-sm btn-main-blue rounded-pill mx-1 px-1">Consultar</button>
              <!--
                <button type="button" data-toggle="modal" @click="emitView(k)" data-target="#offerView" class="btn btn-sm btn-main-pink rounded-pill mx-1 hidden-xl hidden-xl-xl"><i class="fas fa-eye"></i></button>
              -->
            </div>
          </div>
        </div>

        <div class="d-flex flex-row w-100 justify-content-around py-3 pt-5 align-items-center p-2">
          <button :disabled="currentpage==1" @click="setPage" class="col-2 col-md-1 col-lg-1 col-xl-1 d-flex justify-content-center align-items-center page-item rounded-pill btn btn-light"><i class="fas fa-arrow-left"></i></button>
          <div class="d-flex flex-row justify-content-center col-8 col-lg-6 col-xl-6">
            <button :disabled="currentpage==item" v-for="(item,k1) in compLastpage" @click="setPage(item)" :key="k1" :class="'mx-2 d-flex justify-content-center align-items-center btn btn-sm py-2 text-white rounded-pill page-item'+(currentpage==item?' bg-main-blue':' bg-dark-blue')">
              <span class="text-center pr-1">
                {{item}}
              </span>
            </button>
          </div>
          <button :disabled="currentpage==compLastpage" @click="setPage(currentpage)" class="col-2 col-md-1 col-lg-1 col-xl-1 d-flex justify-content-center align-items-center page-item rounded-pill btn btn-light"><i class="fas fa-arrow-right"></i></button>
        </div>

      </div>
    </div>
</template>

<script>
export default {
    props:["items", "fields", "lastpage", "currentpage"],

    data(){
        return{
            baseUrl:baseUrl,
        }
    },

    mounted(){
      console.log("current page ", this.currentpage)
    },

    methods:{
      showPrice(price){
          return price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
      },
      setPage(pageNumber=1){
        this.$emit("pageSwitch", pageNumber);
      },

      emitConsult(index){
        this.$emit("consultItem",index);
      },

      emitView(index){
        this.$emit("viewItem",index);
      }
    },

    computed:{
      compFields:{
        get(){
          console.log("new ",this.fields);
          return this.fields
        }
      },
      compLastpage:{
        get(){
          console.log("new ", this.lastpage);
          return this.lastpage;
        }
      },
      compItems:{
        get(){
          console.log("new ",this.items);
          return this.items
        }
      }
    }
}
</script>
