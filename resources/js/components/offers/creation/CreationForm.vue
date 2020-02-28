<template>
    <div class="card card-info" id="createOfferAccordion">
      <a class="card-header collapsed" @click="active=!active" data-parent="#createOfferAccordion" href="#collapseOne" aria-expanded="false" data-toggle="collapse">
        <h3 class="card-title text-wrap col-10">Nueva Oferta</h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool ml-auto " >
            <personal-fab :active="active" />
          </button>
        </div>
      </a>

      <div id="collapseOne" class="panel-collapse in collapse" >
        <div class="card-body">
  
          <div class="d-flex flex-row w-100 justify-content-around flex-wrap">

            <div class="form-group col-xl-6 col-lg-6 col-md-6 col-12">
            <label>Empresa</label>
            <select class="custom-select" v-model="company">
              <option value="" class="d-none" selected>Empresa</option>
              <option v-for="(company,index) in companies" :key="index" :value="company.name">{{company.name}}</option>
            </select>
            <!-- 
            <autocomplete-vue
            v-model="company"
            url="/api/companies"
            requestType="get"
            placeholder="Empresa"
            property="name"
            :required="true"
            inputClass="form-control"
            ></autocomplete-vue> 
            -->
            </div>

          <!--<company-select @company="setCompany" :companies="companies" ></company-select>-->
          
            <div class="form-group col-xl-6 col-lg-6 col-md-6 col-12">
              <label>Servicio</label>
              <select @change="getFields" class="custom-select" v-model="service">
                <option :value="service.id" v-for="service in services" :key="service.id">{{service.name}}</option>
              </select>
            </div>
            <div class="form-group col-xl-4 col-lg-4 col-md-6 col-12" v-for="(field,index) in fields" :key="index" >
              <label>{{field.name+(field.unit?" ("+field.unit+")":"")}}</label>
              <input v-model="fieldsValues[index]" class="form-control">
            </div>
          </div>

          <div class="d-flex flex-row w-100 justify-content-around flex-wrap my-3">
            <div class="form-group col-12">
              <label>Descripcion</label>
              <textarea class="form-control" rows="3" placeholder="Descripcion..." v-model="benefits" style="resize: none;"></textarea>
            </div>
          </div>

          <zone-custom-selection @departments="setDepartments" @municipalities="setMunicipalities" 
          ref="zoneSelectRef" ></zone-custom-selection>



          <div class="d-flex flex-row w-100 justify-content-around flex-wrap my-3">
            <div class="form-group col-xl-4 col-lg-4 col-md-6 col-12">
              <label>Tarifa</label>
              <input v-model="tariff" class="form-control">
            </div>
            <div class="form-group col-xl-4 col-lg-4 col-md-6 col-12">
              <label>Tipo</label>
              <select class="custom-select" v-model="type">
                <option :value="null" selected>Todos</option>
                <option value="private">Hogar</option>
                <option value="company">Empresa</option>
              </select>
            </div>
            <div class="form-group col-xl-4 col-lg-4 col-md-6 col-12">
              <label>
                Puntuacion
              </label>
              <select class="custom-select" v-model="points">
                <option value="0" selected>0</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
              </select>
                <p class="text-muted text-sm mb-1" >
                  <span class="text-danger">*</span> Este campo es opcional.
                </p>
            </div>
          </div>
        </div>

        <div class="card-footer">
          <button type="button" class="btn btn-outline-success" @click="createOffer">Agregar</button>
        </div>
      </div>
    </div>
</template>

<script>
export default {
  props: ['services'],
  data(){
    return {
      active:false,
      active2:false,
      company: "",
      departments: [],
      municipalities: [],
      type: null,
      tariff: "",
      benefits: "",
      service: null,
      points: 0,
      fields: [],
      fieldsValues: [],
      companies: [],
    }
  },

  mounted(){
    this.refreshData();
  },
  methods:{
    refreshData(){
      let loader = this.$loading.show();
      axios.get(baseUrl+'/api/companies')
      .then(res=>{
        console.log(res);
        this.companies=res.data;
      }).catch(err=>{
        if(err.response.status===403){
          window.location.replace(baseUrl+"/login");
        }
        console.log("ERROR FROM SERVER ",err.response);
        if (err.response.data.errorMessage){
          toastr.error(err.response.data.errorMessage);
        }else{
          toastr.error('Error al obtener las empresas');
        }
      }).finally(()=>loader.hide());
    },
    
    setDepartments(departments){
      this.departments=departments;
    },

    setMunicipalities(municipalities){
      this.municipalities=municipalities;
    },

    getFields(){
      axios.get(baseUrl+"/api/service/"+this.service+"/fields")
      .then(res=>{
        this.fields=res.data
      }).catch(err=>toastr.error("error al obtener los campos del servicio"))
    },

    /*setCompany(company){
      this.company=company.name
    },*/

    async createOffer(){
      let continueCreation=true;
      let valuesArray=[];

      await this.fields.map((field, i)=>{
        if (!this.fieldsValues[i]||this.fieldsValues[i]==""){
           continueCreation=false;
        }
        else valuesArray.push({
          "field_id":field.id,
          "value":this.fieldsValues[i]
        });
      });

      if(!continueCreation) {
        return toastr.error('Debe llenar los campos referentes al servicio seleccionado');
      }

      let fd= new FormData();
      fd.append("company", this.company);
      if(this.departments.length) fd.append("departments", JSON.stringify(this.departments));
      if(this.municipalities.length) fd.append("municipalities", JSON.stringify(this.municipalities));
      if(this.type) fd.append("type", this.type);
      fd.append("tariff", parseInt(this.tariff));
      fd.append("benefits", this.benefits);
      fd.append("service", this.service);
      fd.append("points", this.points);
      fd.append("fields_values", valuesArray.length?JSON.stringify(valuesArray):null);

      let loader = this.$loading.show();

      axios.post(baseUrl+'/api/offer',fd)
      .then(res=>{
        console.log("RESPONSE FROM SERVER ",res);
        toastr.success("Oferta creada con éxito");
        this.company = "";
        this.departments = [];
        this.municipalities = [];
        this.type = "private";
        this.tariff = "";
        this.benefits = "";
        this.service = null;
        this.points = 0;
        this.fields_values = [];
        this.$refs.zoneSelectRef.reset();
        this.$emit('refresh');
      }).catch(err=>{
        if(err.response.status===403){
          window.location.replace(baseUrl+"/login");
        }
        console.log("ERROR FROM SERVER ",err.response);
        if (err.response.data.errorMessage){
          toastr.error(err.response.data.errorMessage);
        }else {
          let allErrors = err.response.data;
          for (var errorkey in allErrors) {
            if (allErrors[errorkey]){
              for (var error of allErrors[errorkey]) {
                toastr.error(error);
              }
            }
          }
        }
      }).finally(()=>loader.hide());
    }
  }
}

</script>
